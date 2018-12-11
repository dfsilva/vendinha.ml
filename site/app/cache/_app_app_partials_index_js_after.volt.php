<script>
   var app = new Vue({
        el: '#app',
        data() {
            return {
                title: 'Vendinha.ml',
                lat: '',
                lon: '',
                location: false,
                loadingSearch: true,
                loadingLocation: true,
                message: {
                    text: '',
                    type: ''
                },
                localizacao:{
                }
            }
        },
        mounted: function(){
            this.setLocation();
        },
        methods: {
            setLocation: function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        console.log(position);
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
                fetch('http://api.ipstack.com/189.61.119.231?access_key=7300d36bec0dd947e62162f761292fce')
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (json) {
                        app.location = false;
                        app.lat = json.latitude;
                        app.lon = json.longitude;
                        app.preencherLocalizacao(app.lat, app.lon)
                    });
            },
            preencherLocalizacao: function(lat, lon){
                var body = {
                    "from" : 0, "size" : 1,
                    "sort": [
                        {
                            "_geo_distance": {
                                "localizacao": {
                                    "lat": lat,
                                    "lon": lon
                                },
                                "order": "asc",
                                "unit": "km",
                                "distance_type": "plane"
                            }
                        }
                    ]
                };

                fetch('https://search-tiger-strips-4fbdu7i2q6p7uhsxyaecyzqhbu.sa-east-1.es.amazonaws.com/enderecos/_search', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json; charset=utf-8"
                    },
                    body:JSON.stringify(body)
                }).then(function (response) {
                    return response.json();
                }).then(function (result) {
                    app.localizacao = result.hits.hits[0]._source;
                    app.loadingLocation = false;
                })
            },
            search: function () {


            },

            ativarLocalizacao: function () {
                console.log('ativando localizacao');
            }
        }
    })
</script>