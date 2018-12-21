Vue.component('dialog-add-video', {
    name: 'dialog-add-video',
    data: function () {
        return {
            videoUrl: '',
            videoUrlRules: [
                function (v) {
                    return !!v || 'É obrigatório informar a URL';
                }
            ],
            visible: false,
            valid: false,
            event: 'addvideo'
        }
    },
    methods: {
        adicionarVideo: function () {
            if(this.$refs.formAddVideo.validate()){
                this.$emit('addvideo', this.videoUrl);
                this.hide();
                this.videoUrl = '';
                this.$refs.formAddVideo.reset();
            }
        },
        show: function () {
            this.visible = true;
        },
        hide: function () {
            this.visible = false;
        }
    },
    template: `
    <v-dialog v-model="visible" max-width="500px">
        <v-card>
            <v-card-title>
                Adicionar um Vídeo
            </v-card-title>
            <v-card-text>
                <v-form ref="formAddVideo" v-model="valid" lazy-validation>
                    <v-text-field
                            label="Link do youtube"
                            hint="Cole aqui o link do vídeo no youtube"
                            single-line
                            v-model="videoUrl"
                            :rules="videoUrlRules"
                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" flat @click="adicionarVideo">Adicionar</v-btn>
                <v-btn color="red" flat @click="hide">Cancelar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    `
})