<div id="app">
    <v-app light>

        <v-toolbar dark color="primary">
            <v-toolbar-side-icon></v-toolbar-side-icon>
            <v-toolbar-title v-text="title"></v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn flat>Entrar <a v-text="lat"></a> <a v-text="lon"></a></v-btn>
            </v-toolbar-items>
        </v-toolbar>


        <v-content>
            <section>
                <v-layout
                        height="600"
                        column
                        align-center
                        justify-center>

                    <v-toolbar
                            dense
                            v-bind:style="{width: ($vuetify.breakpoint.smAndDown ? '80%' : '40%'), marginTop:'20px'}"
                    >
                        <v-btn icon>
                            <v-icon>search</v-icon>
                        </v-btn>

                        <v-text-field
                                hide-details
                                single-line
                                clearable
                        ></v-text-field>

                        <v-btn icon>
                            <v-icon>my_location</v-icon>
                        </v-btn>

                        <v-btn icon>
                            <v-icon>more_vert</v-icon>
                        </v-btn>
                    </v-toolbar>

                </v-layout>
            </section>


            <section>
                <v-layout
                        column
                        wrap
                        class="my-5"
                        align-center
                >
                    <v-flex xs12 sm4 class="my-3">
                        <div class="text-xs-center">
                            <h2 class="headline">The best way to start developing</h2>
                            <span class="subheading">
                Cras facilisis mi vitae nunc
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