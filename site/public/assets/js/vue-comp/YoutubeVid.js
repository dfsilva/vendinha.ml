Vue.component('youtube-vid', {
    name: 'youtube-vid',
    props: ['videoId'],
    data: function () {
        return {
            event: 'error'
        }
    },
    mounted: function () {
        var self = this;
        this.player = new YT.Player(`player_${self.videoId}`, {
            videoId: self.videoId,
            events: {
                'onReady': self.onPlayerReady,
                'onStateChange': self.onPlayerStateChange,
                'onError': self.onError
            }
        });
    },
    methods: {
        onPlayerReady: function () {
            console.log('player esta ready')
        },
        onPlayerStateChange: function (event) {
            console.log('player state changed: ', event)
        },
        onError: function (error) {
            console.log('Video error');
            this.$emit('error', error);
        }
    },
    template: "<div class='video-container'><div :id='`player_${videoId}`'></div></div>"
})