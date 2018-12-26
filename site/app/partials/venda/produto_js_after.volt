{{ assets.outputJs('dialogAddVideoJs') }}
{{ assets.outputJs('youtubeVidJs') }}

<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                passo: 1,
                data: {
                    id: '',
                    titulo: '',
                    descricao: '',
                    tags: [],
                    fotos: [],
                    fotosNomes: [],
                    videos: [],
                    localizacao: {
                        lat: null,
                        lng: null
                    },
                    endereco: {
                        cep: '',
                        logradouro: '',
                        bairro: '',
                        cidade: '',
                        uf: ''
                    }, vendedor: {
                        nome: '',
                        email: '',
                        telefone: ''
                    },
                },
                fotosBase64: {},
                sugestaoTags: [],
                dragOver: false,
                buscandoEndereco: true,
                tituloRules: [
                    function (v) {
                        return !!v || 'Título é requerido.'
                    },
                    function (v) {
                        return v.length <= 150 || 'O título deve ter menos de 150 caracteres.'
                    }
                ],
                descricaoRules: [
                    function (v) {
                        return !!v || 'É necessário informar uma descrição.'
                    },
                    //v => /.+@.+/.test(v) || 'E-mail must be valid'
                ],
                tagsRules: [
                    function (v) {
                        return v.length >= 2 || 'É necessario informar no mínimo duas TAGS.'
                    }
                ],
                nomeRules: [
                    function (v) {
                        return !!v || 'É necessário informar o nome.'
                    }
                ],
                cepRules: [
                    function (v) {
                        return !!v || 'É necessário informar o CEP.'
                    }
                ],
                emailRules: [
                    function (v) {
                        return !!v || 'É necessário informar o email.'
                    },
                    function (v) {
                        return /.+@.+/.test(v) || 'Informe um email válido.'
                    }
                ],
                telefoneRules: [
                    function (v) {
                        return !!v || 'É necessário informar o telefone.'
                    }
                ],
                tasks: {}
            }
        },
        watch: {
            passo(val) {
                saveDraft(`protudo_${app.data.id}`, app.data);
            },
            'data.localizacao': function (val, oldVal) {
                if (val.lat && val.lng) {
                    app.buscandoEndereco = true;
                    getAddress(val.lat, val.lng)
                        .then(function (endereco) {
                            // app.buscandoEndereco = false;
                            app.data.endereco = {
                                cep: endereco.cep,
                                logradouro: endereco.logradouro,
                                bairro: endereco.bairro,
                                cidade: endereco.cidade,
                                uf: endereco.uf
                            }
                        })
                        .catch(function (error) {
                            // app.buscandoEndereco = false;
                        })
                }
            }
        },
        mounted: function () {

            this.carregarRascunho();

            initGoogleMaps({{ constant("MAPS_API_KEY") }});
            initYoutube();

            if (isDragSupported()) {
                document.querySelector("#dropzone").addEventListener("dragenter", function (e) {
                    e.preventDefault();
                    if (!app.dragOver)
                        app.dragOver = true;
                });

                // document.querySelector("#dropzone").addEventListener("dragleave", function (e) {
                //     e.preventDefault();
                //     app.dragOver = false;
                // });

                document.querySelector("#dropzone").addEventListener("dragover", function (e) {
                    e.preventDefault();
                    if (!app.dragOver)
                        app.dragOver = true;
                });
                document.querySelector("#dropzone").addEventListener("drop", function (e) {
                    e.preventDefault();
                    app.dragOver = false;
                    var files = e.dataTransfer.files;
                    for (var i = 0; i < files.length; i++) {
                        var foto = files[i];
                        app.uploadPicture(foto);
                    }
                });
            }
        },
        methods: {
            carregarRascunho: function () {
                this.$refs.vdMessage.showLoadingMessage('Carregando...');
                getDraft()
                    .then(function (draft) {
                        app.$refs.vdMessage.hideMessage();
                        app.data = draft;
                    })
                    .catch(function (error) {
                        app.getId();
                    })
            },
            getId: function () {
                fetch('{{ constant("API_URL")~"/next-seq" }}')
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (novoId) {
                        app.$refs.vdMessage.hideMessage();
                        app.data.id = novoId;
                    })
                    .catch(function (error) {
                        app.$refs.vdMessage.showErrorMessage('Erro ao obter id');
                    })
            },
            cancelarCadastro: function () {
                location.href = "{{ url('') }}"
            },
            adicionarFoto: function (event) {
                event.preventDefault();
                var file = event.target.files[0];
                this.uploadPicture(file);
            },
            removerFoto: function (index) {
                var foto = this.data.fotos[index];

                this.data.fotos.splice(index, 1);
                this.data.fotosNomes.splice(index, 1);

                if (foto.principal && this.data.fotos.length > 0) {
                    this.data.fotos[0].principal = true;
                }

                if (foto.url) {
                    var storageRef = firebase.storage().ref().child(`${foto.folderPath}/${foto.name}`);
                    storageRef.delete().then(function () {
                        var thumbRef = firebase.storage().ref().child(`${foto.folderPath}/thumb_${foto.name}`);
                        thumbRef.delete();
                    });
                } else {
                    if (foto.uploading && app.tasks[foto.name]) {
                        app.tasks[foto.name].cancel();
                        delete app.tasks[foto.name];
                    }
                }
            },
            mainPictureChanged(value, index) {
                app.data.fotos = app.data.fotos.map(function (value, idx) {
                    if (index !== idx) {
                        value.principal = false;
                    }
                    return value;
                })
            },
            uploadPicture: function (file) {
                if (!isImage(file)) {
                    app.$refs.vdMessage.showWaningMessage(`Arquivo ${file.name} não é uma imagem`);
                    return;
                }
                if (app.data.fotosNomes.indexOf(file.name) > -1) {
                    app.$refs.vdMessage.showWaningMessage(`Arquivo ${file.name} já foi adicionado`);
                    return;
                }
                var reader = new FileReader();
                reader.onloadend = function () {

                    var novaFoto = {
                        name: file.name,
                        url: '',
                        folderPath: `temp/produtos/pictures/${app.data.id}`,
                        principal: app.data.fotos.length == 0 ? true : false,
                        uploading: false,
                        progress: 0
                    };

                    app.data.fotos = app.data.fotos.concat([novaFoto])
                    app.data.fotosNomes = [file.name].concat(app.data.fotosNomes);

                    app.fotosBase64[novaFoto.name] = reader.result;

                    var storageRef = firebase.storage().ref().child(`${novaFoto.folderPath}/${file.name}`);

                    app.tasks[novaFoto.name] = storageRef.put(file);

                    app.tasks[novaFoto.name].on('state_changed', function (snapshot) {
                        novaFoto.uploading = true;
                        novaFoto.progress = parseInt((snapshot.bytesTransferred / snapshot.totalBytes) * 100);
                    }, function (error) {
                        novaFoto.uploading = false;
                        delete app.tasks[novaFoto.name];
                    }, function () {
                        novaFoto.uploading = false;
                        app.tasks[novaFoto.name].snapshot.ref.getDownloadURL()
                            .then(function (remoteUrl) {
                                novaFoto.url = remoteUrl;
                                delete app.tasks[novaFoto.name];
                            })
                            .catch(function (error) {
                                app.tasks[novaFoto.name].snapshot.ref.getDownloadURL()
                                    .then(function (remoteUrl) {
                                        novaFoto.url = remoteUrl;
                                        delete app.tasks[novaFoto.name];
                                    });
                            });
                    });
                }
                reader.readAsDataURL(file);
            },
            showAddVideoDialog() {
                this.$refs.dialogAddVideo.show();
            },
            addVideo: function (videoUrl) {
                var videoId = youTubeGetId(videoUrl);
                app.data.videos = app.data.videos.concat([{id: videoId}]);
                app.videoUrl = '';
                app.dialogAddVideo = false;
            },
            playVideoError: function (error) {
                this.$refs.vdMessage.showErrorMessage("Não foi possível tocar o vídeo.");
            },
            removerVideo: function (index) {
                this.data.videos.splice(index, 1);
            },
            getMyLocation: function () {
                getLocalizacao().then(function (endereco) {
                    var localizacao = {lat: endereco.localizacao.lat, lng: endereco.localizacao.lon};
                    app.data.localizacao = localizacao;

                    if (app.marcacao) {
                        app.marcacao.setMap(null);
                    }

                    app.marcacao = new google.maps.Marker({
                        position: localizacao,
                        map: app.map,
                        draggable: true,
                        title: "Arraste para mudar sua localização!"
                    });

                    app.marcacao.addListener('dragend', function (event) {
                        var localizacao = {lat: event.latLng.lat(), lng: event.latLng.lng()};
                        app.data.localizacao = localizacao;
                    });
                })
            },
            removerTags: function (item) {
                this.data.tags.splice(this.data.tags.indexOf(item), 1);
            }
        }
    });

    function initMap() {
        var lat = parseFloat(getValue('lat'));
        var lng = parseFloat(getValue('lon'));

        if (lat && lng) {
            var localizacao = {lat: lat, lng: lng};
            app.data.localizacao = localizacao;
            app.map = new google.maps.Map(document.getElementById('map'), {
                center: localizacao,
                zoom: 14
            });

            app.marcacao = new google.maps.Marker({
                position: localizacao,
                map: app.map,
                draggable: true,
                title: "Arraste para mudar sua localização!"
            });

            app.marcacao.addListener('dragend', function (event) {
                var localizacao = {lat: event.latLng.lat(), lng: event.latLng.lng()};
                app.data.localizacao = localizacao;
            });
        } else {
            app.getMyLocation();
        }
    }

    function onYouTubeIframeAPIReady() {
    }
</script>


