<section>
    <v-layout
            mt-3
            align-center
            justify-center>

        <v-flex xs11 sm10 lg8>
            <v-text-field
                    v-model="searchText"
                    @click:clear="clearSearch"
                    :placeholder="loadingLocation ? '':'Buscar próximo a '+localizacao.logradouro+' em '+localizacao.cidade+','+localizacao.uf"
                    single-line
                    clearable
                    autofocus
                    solo
            >
                <v-btn slot="prepend" flat icon color="primary" style="margin-top: -6px;">
                    <v-icon>settings</v-icon>
                </v-btn>

                <v-tooltip slot="prepend-inner" bottom>
                    <v-btn slot="activator" flat icon>
                        <v-icon v-if="location" color="primary">location_on</v-icon>
                        <v-icon v-else color="grey">location_off</v-icon>
                    </v-btn>
                    <span v-if="location">Você autorizou o acesso a sua localização, com isso vamos conseguir fazer uma busca bem mais precisa.</span>
                    <span v-else>Você não autorizou o acesso a sua localização, mas mesmo assim vamos fazer o melhor para trazer uma busca mais precisa para você.</span>
                </v-tooltip>


                <v-fade-transition slot="append">
                    <v-progress-circular
                            v-if="loadingSearch"
                            size="24"
                            color="info"
                            indeterminate
                    />
                </v-fade-transition>


                <div slot="append-outer" style="display: flex; flex-direction: row; margin-top: -12px;">
                    <v-btn flat icon color="primary" @click="efetuarBusca">
                        <v-icon dark>search</v-icon>
                    </v-btn>
                </div>

            </v-text-field>
        </v-flex>
    </v-layout>
</section>

<section>
    <v-layout
            column
            wrap
            align-center>

        <v-flex xs12 sm4>
            <v-progress-circular
                    v-show="loadingLocation"
                    size="24"
                    color="info"
                    indeterminate
            />
        </v-flex>

        <v-flex v-show="!loadingLocation" xs12 sm4 class="my-3">
            <div class="text-xs-center">
                <h2 class="headline">{{ "{{localizacao.cidade}}, {{localizacao.uf}}" }}</h2>
                <span class="subheading">
                                {{ "{{localizacao.logradouro}}" }}
                            </span>
            </div>
        </v-flex>

        <v-flex xs12>
            <v-container grid-list-xl>
                <v-layout row wrap align-center>
                    <v-flex xs12 md4>
                        <v-card>
                            <v-img
                                    src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
                                    aspect-ratio="2.75"></v-img>

                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">Kangaroo Valley Safari</h3>
                                    <div>Located two hours south of Sydney in the <br>Southern Highlands of
                                        New South Wales, ...
                                    </div>
                                </div>
                            </v-card-title>

                            <v-card-actions>
                                <v-btn flat color="orange">Share</v-btn>
                                <v-btn flat color="orange">Explore</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-card>
                            <v-img
                                    src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
                                    aspect-ratio="2.75"
                            ></v-img>

                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">Kangaroo Valley Safari</h3>
                                    <div>Located two hours south of Sydney in the <br>Southern Highlands of
                                        New South Wales, ...
                                    </div>
                                </div>
                            </v-card-title>

                            <v-card-actions>
                                <v-btn flat color="orange">Share</v-btn>
                                <v-btn flat color="orange">Explore</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-card>
                            <v-img
                                    src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
                                    aspect-ratio="2.75"
                            ></v-img>

                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">Kangaroo Valley Safari</h3>
                                    <div>Located two hours south of Sydney in the <br>Southern Highlands of
                                        New South Wales, ...
                                    </div>
                                </div>
                            </v-card-title>

                            <v-card-actions>
                                <v-btn flat color="orange">Share</v-btn>
                                <v-btn flat color="orange">Explore</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-flex>
    </v-layout>
</section>


{% set templateAfter = 'index/js_after' %}