<div id="app" v-cloak>
    <v-app light>

        <v-toolbar dark color="primary">
            <v-toolbar-side-icon></v-toolbar-side-icon>
            <v-toolbar-title v-text="title"></v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn flat>Entrar</v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <v-content>
            <section>
                <v-layout
                        mt-3
                        align-center
                        justify-center>

                    <v-flex xs11 sm10 lg8>
                        <v-text-field
                                prepend-inner-icon="search"
                                :append-icon="location ? 'location_on' : 'location_off'"
                                @click:append="ativarLocalizacao"
                                :placeholder="'Buscar proximo a '+localizacao.cidade"
                                single-line
                                clearable
                                autofocus
                                solo
                        />
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
                            <h2 class="headline"><?= '{{localizacao.cidade}}, {{localizacao.uf}}' ?></h2>
                            <span class="subheading">
                                <?= '{{localizacao.logradouro}}' ?>
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

        </v-content>
    </v-app>
</div>

<?php $templateAfter = 'index/js_after'; ?>