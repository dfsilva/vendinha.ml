<!DOCTYPE html>
<html>
<head>
    {% block title %}{{ get_title() }}{% endblock %}
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    {% block head %}{% endblock %}

    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>
<body>
<div id="app" v-cloak>
    <v-app dark>

        <v-navigation-drawer
                v-model="drawer.open"
                permanent
                absolute
                app
        >
            <v-toolbar flat class="transparent">
                <v-list class="pa-0">
                    <v-list-tile avatar>
                        <v-list-tile-avatar>
                            <img src="https://randomuser.me/api/portraits/men/85.jpg">
                        </v-list-tile-avatar>

                        <v-list-tile-content>
                            <v-list-tile-title>John Leider</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-toolbar>

            <v-list class="pt-0" dense>
                <v-divider></v-divider>

                <v-list-tile @click="">
                    <v-list-tile-action>
                        <v-icon>search</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>Item 1</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>

        <v-toolbar app fixed>
            <v-toolbar-side-icon @click="toggleDrawer"></v-toolbar-side-icon>
            <v-toolbar-title v-text="title"></v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-menu offset-y>
                    <v-btn slot="activator" flat>VENDER</v-btn>
                    <v-list>
                        <v-list-tile @click="venderProdutos">
                            <v-list-tile-avatar>
                                <v-icon color="primary">shopping_basket</v-icon>
                            </v-list-tile-avatar>
                            <v-list-tile-title>PRODUTOS</v-list-tile-title>
                        </v-list-tile>
                    </v-list>
                </v-menu>
            </v-toolbar-items>
        </v-toolbar>

        <v-content style="margin-top:20px;" class="scroll-y">
            {% block content %}{% endblock %}
        </v-content>

        <v-footer
                fixed
                mt-2
                height="auto">
            <v-flex
                    lighten-2
                    py-3
                    text-xs-center
                    white--text
                    xs12
            >
                &copy;2018 — <strong>Vendinha - Todos os direitos resevados</strong>
            </v-flex>
        </v-footer>
    </v-app>
</div>


{% if constant("APP_ENV") === 'prod' %}
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
{% else %}
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
{% endif %}
<script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>

{% block footer %}{% endblock %}

</body>
</html>