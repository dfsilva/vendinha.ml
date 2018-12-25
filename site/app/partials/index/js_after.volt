<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                lat: '',
                lon: '',
                location: false,
                loadingSearch: false,
                loadingLocation: true,
                searchText: '',
                message: {
                    text: '',
                    type: ''
                },
                localizacao: {}
            }
        },
        mounted: function () {
            this.setLocation();
        },
        methods: {
            setLocation: function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        app.lat = position.coords.latitude;
                        app.lon = position.coords.longitude;
                        app.location = true;
                        app.preencherLocalizacao(app.lat, app.lon);
                    }, function (error) {
                        app.searchLocationByIp();
                    });
                } else {
                    app.searchLocationByIp();
                }
            },
            searchLocationByIp: function () {
                getGeoByIp().then(function (localizacao) {
                    app.location = false;
                    app.lat = localizacao.latitude;
                    app.lon = localizacao.longitude;
                    app.preencherLocalizacao(app.lat, app.lon)
                })
            },
            preencherLocalizacao: function (lat, lon) {
                getAddress(lat, lon).then(function (localizacao) {
                    app.localizacao = localizacao;
                    app.loadingLocation = false;
                });
            },

            efetuarBusca: function () {
                app.loadingSearch = true;
                console.log('Fazer busca');
            },

            clearSearch: function () {
                app.searchText = '';
                app.loadingSearch = false;
            }
        }
    })
</script>