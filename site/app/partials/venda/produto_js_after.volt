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
                        lon: null
                    },
                    vendedor: {
                        nome: '',
                        cep: '',
                        email: '',
                        telefone: ''
                    }
                },
                sugestaoTags: [],
                dragOver: false,
                tituloRules: [
                    function (v) {
                        return !!v || 'Name is required'
                    },
                    function (v) {
                        return v.length <= 10 || 'Name must be less than 10 characters'
                    }
                ],
                descricaoRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid'
                ]
            }
        },
        mounted: function () {
            this.getId();
            initGoogleMaps();
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
            getId: function () {
                this.$refs.vdMessage.showLoadingMessage('Carregando');
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
            removerFoto: function(index){
                var foto = this.data.fotos[index];
                this.data.fotos = this.data.fotos.splice(index, 1);
                this.data.fotosNomes = this.data.fotosNomes.splice(index, 1);
                if(foto.principal && this.data.fotos.length > 0){
                    this.data.fotos[0].principal = true;
                }
            },
            uploadPicture: function (file) {
                if (!isImage(file)) {
                    app.showWaningMessage(`Arquivo ${file.name} não é uma imagem`);
                    return;
                }
                if (app.data.fotosNomes.indexOf(file.name) > -1) {
                    app.showWaningMessage(`Arquivo ${file.name} já foi adicionado`);
                    return;
                }
                var reader = new FileReader();
                reader.onloadend = () => {
                    app.data.fotos = app.data.fotos.concat([{
                        file: file,
                        name: file.name,
                        url: reader.result,
                        principal: app.data.fotos.length == 0 ? true : false
                    }])
                    app.data.fotosNomes = [file.name].concat(app.data.fotosNomes);
                }
                reader.readAsDataURL(file)
            },
            showAddVideoDialog(){
                this.$refs.dialogAddVideo.show();
            },
            adicionarVideo: function (videoUrl) {
                var videoId = youTubeGetId(videoUrl);
                app.data.videos = app.data.videos.concat([{id: videoId}]);
                app.videoUrl = '';
                app.dialogAddVideo = false;
            },
            videoError: function (error) {
                this.$refs.vdMessage.showErrorMessage("Não foi possível tocar o vídeo.");
            },
            alterouPrincipal(value, index){
                app.data.fotos = app.data.fotos.map(function (value, idx) {
                    if(index !== idx){
                        value.principal = false;
                    }
                    return value;
                })
            }
        }
    });

    function initMap() {
        var lat = parseFloat(getValue('lat'));
        var lon = parseFloat(getValue('lon'));
        var localizacao = {lat: lat, lng: lon};

        app.map = new google.maps.Map(document.getElementById('map'), {
            center: localizacao,
            zoom: 14
        });
        app.marcacao = new google.maps.Marker({position: localizacao, map: app.map});
    }

    function onYouTubeIframeAPIReady() {
        console.log('Youtube esta ok');
    }
</script>


