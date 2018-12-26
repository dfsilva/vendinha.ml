<dialog-add-video ref="dialogAddVideo" v-on:addvideo="addVideo"></dialog-add-video>

<v-stepper v-model="passo" vertical>
    <v-stepper-step step="1"
                    :rules="[() => passo <= 1 || this.$refs.formInformacoesBasicas.validate()]"
                    editable
                    :complete="passo > 1">
        Informações básicas
        <small v-if="passo > 1 && !this.$refs.formInformacoesBasicas.validate()">Existem problemas a serem corrigidos
        </small>
    </v-stepper-step>

    <v-stepper-content step="1">
        <v-form ref="formInformacoesBasicas">
            <v-text-field
                    v-model="data.titulo"
                    :rules="tituloRules"
                    :counter="150"
                    label="Título"
                    hint="Informe um título para o seu produto."
            ></v-text-field>
            <v-textarea
                    v-model="data.descricao"
                    :rules="descricaoRules"
                    label="Descrição"
                    hint="Informe a descrição detalhada do produto."
            ></v-textarea>

            <v-combobox
                    v-model="data.tags"
                    :items="sugestaoTags"
                    label="Tags"
                    hint="Digite a tag e pressione Enter para adicionar."
                    :rules="tagsRules"
                    chips
                    clearable
                    multiple
            >
                <template slot="selection" slot-scope="data">
                    <v-chip
                            :selected="data.selected"
                            close
                            @input="removerTags(data.item)">
                        <strong>{{ '{{ data.item }}' }}</strong>
                    </v-chip>
                </template>
            </v-combobox>
        </v-form>

        <v-btn color="primary" @click="passo = 2">Próximo</v-btn>
        <v-btn flat @click="cancelarCadastro">Cancelar</v-btn>
    </v-stepper-content>

    <v-stepper-step step="2"
                    editable
                    :rules="[() => passo <= 2 || data.fotos.length > 0]"
                    :complete="passo > 2">
        <div style="flex-direction:row;">
            Fotos
            <label v-if="data.id">
                <v-btn v-if="passo == 2" @click="$refs.image.click()" fab flat small>
                    <v-icon>add</v-icon>
                </v-btn>
                <input type='file'
                       ref="image"
                       multiple
                       @change="adicionarFoto($event)"
                       accept="image/*"
                       style="display:none;">
            </label>
        </div>
        <small v-if="passo > 2 && !data.fotos.length">Adicione pelo menos 1 foto.</small>
    </v-stepper-step>
    <v-stepper-content step="2">
        <v-layout>
            <v-flex>
                <div id="dropzone">
                    <v-card :class="`elevation-${dragOver ? 12 : 2}`" v-if="data.id">
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
                                                :src="fotosBase64[foto.name] || foto.url"
                                                :lazy-src="fotosBase64[foto.name] || foto.url"
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

                                            <div v-if="foto.uploading"
                                                 class="d-flex justify-center align-content-center align-center"
                                                 style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.5);">
                                                <v-progress-circular
                                                        :rotate="360"
                                                        :size="100"
                                                        :width="15"
                                                        :value="foto.progress"
                                                        color="primary"
                                                >
                                                    {{ '{{ foto.progress }}%' }}
                                                </v-progress-circular>
                                            </div>

                                            <div v-if="foto.erro"
                                                 class="d-flex justify-center align-content-center align-center"
                                                 style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.5);">

                                                <v-btn fab color="primary"
                                                       @click="reenviarFoto(index)">
                                                    <v-icon dark>arrow_upward</v-icon>
                                                </v-btn>
                                            </div>

                                            <v-btn fab dark small color="error"
                                                   @click="removerFoto(index)"
                                                   style="position: absolute; right: 5px; top: 5px;">
                                                <v-icon dark>remove</v-icon>
                                            </v-btn>

                                            <v-switch color="primary"
                                                      v-model="foto.principal"
                                                      style="position: absolute; left:5px; top:0px;"
                                                      @change="function(value){mainPictureChanged(value,index)}">
                                                <div slot="label" class="text--primary">Principal</div>
                                            </v-switch>
                                        </v-img>
                                    </v-card>
                                </v-flex>

                                <div v-if="!data.fotos.length && !dragOver"
                                     class="align-center align-content-center v-full white--text d-flex justify-center">
                                    Arraste ou pressione + para adicionar fotos
                                </div>

                                <v-expand-transition>
                                    <div
                                            v-if="dragOver"
                                            class="d-flex transition-fast-in-fast-out orange darken-2 v-card--reveal display-3 white--text"
                                            style="height: 100%;"
                                    >
                                        Solte para adicionar as Fotos
                                    </div>
                                </v-expand-transition>
                            </v-layout>
                        </v-container>
                    </v-card>
                </div>
                <div v-if="!data.id"
                     style="left: 0; top: 0; right: 0; bottom: 0; display: flex; justify-content: center; align-items: center; flex-direction: column; min-height: 200px;">
                    Nao foi possivel recuperar um código para esse cadastro.
                    <v-btn color="primary" @click="getId">Tentar Novamente</v-btn>
                </div>
            </v-flex>
        </v-layout>
        <v-btn color="primary" @click="passo = 3">Próximo</v-btn>
        <v-btn flat @click="passo = --passo">Cancelar</v-btn>
    </v-stepper-content>

    <v-stepper-step step="3"
                    editable
                    :complete="passo > 3">
        <div style="flex-direction:row;">
            Vídeos (
            <small>Opcional</small>
            )
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
                                    <youtube-vid :video-id="video.id" v-on:error="playVideoError"></youtube-vid>

                                    <v-btn fab dark small color="error"
                                           @click="removerVideo(index)"
                                           style="position: absolute; right: 5px; top: 5px;">
                                        <v-icon dark>remove</v-icon>
                                    </v-btn>
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

        <v-btn color="primary" @click="passo = 4">Próximo</v-btn>
        <v-btn flat @click="passo = --passo">Cancelar</v-btn>
    </v-stepper-content>

    <v-stepper-step step="4"
                    :complete="passo > 4"
                    editable>
        <div style="flex-direction:row;">
            Localização
            <v-btn v-if="passo == 4" @click="getMyLocation" fab flat small>
                <v-icon>my_location</v-icon>
            </v-btn>
        </div>
    </v-stepper-step>
    <v-stepper-content step="4">
        <v-layout>
            <v-container fluid>
                <div id="map" style="height:400px;width:100%;"></div>
                <v-form ref="formEndereco">
                    <v-text-field
                            v-model="data.endereco.cep"
                            label="CEP"
                            :rules="cepRules"
                            mask="#####-###"
                    ></v-text-field>

                    <v-text-field
                            v-model="data.endereco.logradouro"
                            label="Rua"
                    ></v-text-field>

                    <v-text-field
                            v-model="data.endereco.bairro"
                            label="Bairro"
                    ></v-text-field>

                    <v-text-field
                            v-model="data.endereco.cidade"
                            label="Cidade"
                    ></v-text-field>

                    <v-text-field
                            v-model="data.endereco.uf"
                            label="UF"
                    ></v-text-field>
                </v-form>
            </v-container>
        </v-layout>
        <v-btn color="primary" @click="passo = 5">Próximo</v-btn>
        <v-btn flat @click="passo = --passo">Cancel</v-btn>
    </v-stepper-content>

    <v-stepper-step step="5" editable>
        Dados do vendedor
    </v-stepper-step>

    <v-stepper-content step="5">
        <v-form ref="formDadosVendedor">
            <v-text-field
                    v-model="data.vendedor.nome"
                    :counter="400"
                    label="Nome"
                    :rules="nomeRules"
            ></v-text-field>

            <v-text-field
                    v-model="data.vendedor.email"
                    label="Email"
                    :rules="emailRules"
            ></v-text-field>

            <v-text-field
                    v-model="data.vendedor.telefone"
                    label="Telefone"
                    mask="(##) # ####-####"
                    :rules="telefoneRules"
            ></v-text-field>

        </v-form>

        <v-btn color="primary" @click="passo = 5">Enviar</v-btn>
        <v-btn flat @click="passo = --passo">Cancelar</v-btn>
    </v-stepper-content>
</v-stepper>

{% set templateAfter = 'venda/produto_js_after' %}