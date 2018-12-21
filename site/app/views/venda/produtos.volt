<dialog-add-video ref="dialogAddVideo" v-on:addvideo="adicionarVideo"></dialog-add-video>

<v-stepper v-model="passo" vertical>
    <v-stepper-step step="1" editable>
        Informações básicas
    </v-stepper-step>

    <v-stepper-content step="1">

        <v-form>
            <v-text-field
                    v-model="data.titulo"
                    :rules="tituloRules"
                    :counter="150"
                    label="Título"
                    required
            ></v-text-field>
            <v-textarea
                    v-model="data.descricao"
                    :rules="descricaoRules"
                    label="Descrição do protudo"
                    hint="Informe a descrição detalhada do produto"
            ></v-textarea>

            <v-combobox
                    v-model="data.tags"
                    :items="sugestaoTags"
                    label="Tags"
                    hint="Tags para identificar o seu produto"
                    chips
                    clearable
                    multiple
            >
                <template slot="selection" slot-scope="data">
                    <v-chip
                            :selected="data.selected"
                            close
                            @input="remove(data.item)">
                        <strong>{{ '{{ data.item }}' }}</strong>
                    </v-chip>
                </template>
            </v-combobox>
        </v-form>

        <v-btn color="primary" @click="passo = 2">Continuar</v-btn>
        <v-btn flat @click="cancelarCadastro">Cancelar</v-btn>
    </v-stepper-content>

    <v-stepper-step step="2" editable>
        <div style="flex-direction:row;">
            Fotos
            <label>
                <v-btn v-if="passo == 2" @click="$refs.image.click()" fab flat small>
                    <v-icon>add</v-icon>
                </v-btn>
                <input type='file'
                       ref="image"
                       @change="adicionarFoto($event)"
                       accept="image/*"
                       style="display:none;">
            </label>
        </div>
    </v-stepper-step>
    <v-stepper-content step="2">
        <v-layout>
            <v-flex>
                <div id="dropzone">
                    <v-card :class="`elevation-${dragOver ? 12 : 2}`">
                        <v-container grid-list-sm fluid>
                            <v-layout
                                    row
                                    wrap
                                    justify-center
                                    align-center
                                    style="min-height: 200px;"
                            >
                                <v-flex
                                        v-for="(foto, index) in data.fotos"
                                        :key="index"
                                        xs4
                                        d-flex
                                >
                                    <v-card flat tile class="d-flex">
                                        <v-img
                                                :src="foto.url"
                                                :lazy-src="foto.url"
                                                aspect-ratio="1"
                                                class="grey lighten-2"
                                        >
                                            <v-layout
                                                    slot="placeholder"
                                                    fill-height
                                                    align-center
                                                    justify-center
                                                    ma-0
                                            >
                                                <v-progress-circular
                                                        indeterminate
                                                        color="grey lighten-5">
                                                </v-progress-circular>
                                            </v-layout>

                                            <v-btn fab dark small color="primary"
                                                   @click="removerFoto(index)"
                                                   style="position: absolute; right: 5px; top: 5px;">
                                                <v-icon dark>remove</v-icon>
                                            </v-btn>

                                            <v-switch color="primary"
                                                      v-model="foto.principal"
                                                      style="position: absolute; left:5px; top:0px;"
                                                        @change="function(value){alterouPrincipal(value,index)}">
                                                <div slot="label" class="text--primary">Principal</div>
                                            </v-switch>
                                        </v-img>
                                    </v-card>
                                </v-flex>

                                <div v-if="!data.fotos.length && !dragOver"
                                     class="align-center align-content-center v-full white--text d-flex justify-center">
                                    Arraste para adicionar fotos
                                </div>

                                <v-expand-transition>
                                    <div
                                            v-if="dragOver"
                                            class="d-flex transition-fast-in-fast-out orange darken-2 v-card--reveal display-3 white--text"
                                            style="height: 100%;"
                                    >
                                        SOLTE PARA ADICIONAR FOTOS
                                    </div>
                                </v-expand-transition>
                            </v-layout>
                        </v-container>
                    </v-card>
                </div>
            </v-flex>
        </v-layout>
        <v-btn color="primary" @click="passo = 3">Continuar</v-btn>
        <v-btn flat @click="passo = --passo">Cancelar</v-btn>
    </v-stepper-content>

    <v-stepper-step step="3" editable>
        <div style="flex-direction:row;">
            Vídeos
            <v-btn v-if="passo == 3" @click="showAddVideoDialog" fab flat small>
                <v-icon>add</v-icon>
            </v-btn>
        </div>
    </v-stepper-step>

    <v-stepper-content step="3">
        <v-layout>
            <v-flex>
                <v-card>
                    <v-container grid-list-sm fluid>
                        <v-layout
                                row
                                wrap
                                justify-center
                                align-center
                                style="min-height:200px;"
                        >
                            <v-flex
                                    v-for="(video, index) in data.videos"
                                    :key="index"
                                    xs4
                                    d-flex
                            >
                                <v-card flat tile class="d-flex">
                                    <youtube-vid :video-id="video.id" v-on:error="videoError"></youtube-vid>
                                </v-card>
                            </v-flex>

                            <div v-if="!data.videos.length"
                                 class="align-center align-content-center v-full white--text d-flex justify-center">
                                Nenhum vídeo adicionado
                            </div>

                        </v-layout>
                    </v-container>
                </v-card>
            </v-flex>
        </v-layout>

        <v-btn color="primary" @click="passo = 4">Continuar</v-btn>
        <v-btn flat @click="passo = --passo">Cancelar</v-btn>
    </v-stepper-content>

    <v-stepper-step step="4" editable>Localização</v-stepper-step>

    <v-stepper-content step="4">
        <v-flex>
            <v-card class="elevation-12">
                <v-container grid-list-sm fluid>
                    <div id="map" style="height:400px;width:100%;"></div>
                </v-container>
            </v-card>
        </v-flex>

        <v-btn color="primary" @click="passo = 5">Continue</v-btn>
        <v-btn flat @click="passo = --passo">Cancel</v-btn>
    </v-stepper-content>

    <v-stepper-step step="5" editable>
        Dados do vendedor
    </v-stepper-step>

    <v-stepper-content step="5">
        <v-form>
            <v-text-field
                    v-model="data.nome"
                    :counter="400"
                    label="Nome"
                    required
            ></v-text-field>

            <v-text-field
                    v-model="data.cep"
                    label="CEP"
                    required
            ></v-text-field>

            <v-text-field
                    v-model="data.email"
                    label="Email"
                    required
            ></v-text-field>

            <v-text-field
                    v-model="data.telefone"
                    label="Telefone"
                    required
            ></v-text-field>

        </v-form>

        <v-btn color="primary" @click="passo = 5">Enviar</v-btn>
        <v-btn flat @click="passo = --passo">Cancelar</v-btn>
    </v-stepper-content>
</v-stepper>

{% set templateAfter = 'venda/produto_js_after' %}