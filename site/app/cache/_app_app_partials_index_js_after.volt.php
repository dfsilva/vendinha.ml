<script>
   var app = new Vue({
        el: '#app',
        data() {
            return {
                title: 'Vendinha.ml',
                lat: '1111',
                lon: '',
                message: {
                    text: '',
                    type: ''
                },

            }
        },
        mounted: function(){
          console.log('mountent');
          // console.log(app.$vuetify.breakpoint);
        },
        methods: {
            setLocation: function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        this.lat = position.coords.latitude;
                        this.lon = position.coords.longitude;
                    });
                } else {
                    this.searchLocationByIp();
                }
            },
            searchLocationByIp: function () {
                fetch('http://ip-api.com/json')
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (json) {
                        this.lat = json.lat;
                        this.lon = json.lon;
                    });
            },
            search: function () {

            },
        }
    })
</script>