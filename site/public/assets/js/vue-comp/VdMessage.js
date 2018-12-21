Vue.component('vd-message', {
    name: 'vd-message',
    data: function () {
        return {
            snackbar: {
                visible: false,
                text: '',
                loading: false,
                timeout: 0,
                showClose: false,
                color: ''
            }
        }
    },
    mounted: function () {

    },
    methods: {
        showLoadingMessage: function (message) {
            this.snackbar.loading = true;
            this.snackbar.text = message;
            this.snackbar.visible = true;
        },
        showErrorMessage: function (message) {
            this.snackbar.loading = false;
            this.snackbar.text = message;
            this.snackbar.visible = true;
            this.snackbar.timeout = 6000;
            this.snackbar.showClose = true;
            this.snackbar.color = 'error';
        },
        showWaningMessage: function (message) {
            this.snackbar.loading = false;
            this.snackbar.text = message;
            this.snackbar.visible = true;
            this.snackbar.timeout = 6000;
            this.snackbar.showClose = true;
            this.snackbar.color = 'warning';
        },
        hideMessage: function () {
            this.snackbar.loading = false;
            this.snackbar.text = '';
            this.snackbar.visible = false;
        },
    },
    template: `
        <v-snackbar
            top
            :timeout="snackbar.timeout"
            v-model="snackbar.visible"
            :color="snackbar.color">
    
        <v-layout row align-center justify-center>
            <div>
                <v-progress-circular
                        v-if="snackbar.loading"
                        indeterminate
                        color="primary"/>
            </div>
            <div style="margin-left:10px;">
               {{ snackbar.text }}
            </div>
        </v-layout>
        <v-btn
                v-if="snackbar.showClose"
                flat
                @click="snackbar.visible = false">
            Fechar
        </v-btn>
    </v-snackbar>
    `
})