Vue.component('vd-navigation', {
    name: 'vd-navigation',
    props: ['defaultTitle', 'rootUri'],
    data: function () {
        return {
            drawer: {
                open: false
            },
            title: this.defaultTitle
        }
    },
    methods: {
        produtos: function () {
            location.href = `${this.rootUri}vender-produtos`
        }
    },
    template: `
        <div>
        <v-toolbar app fixed>
            <v-toolbar-side-icon @click="drawer.open = !drawer.open"></v-toolbar-side-icon>
            <v-toolbar-title v-text="title"></v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-menu offset-y>
                    <v-btn slot="activator" color="orange" flat>VENDER</v-btn>
                    <v-list>
                        <v-list-tile @click="produtos">
                            <v-list-tile-avatar>
                                <v-icon color="orange">shopping_basket</v-icon>
                            </v-list-tile-avatar>
                            <v-list-tile-title color="orange">PRODUTOS</v-list-tile-title>
                        </v-list-tile>
                    </v-list>
                </v-menu>
            </v-toolbar-items>
        </v-toolbar>
        <v-navigation-drawer
                v-model="drawer.open"
                fixed
                app
        >
            <v-toolbar flat class="transparent">
                <v-list class="pa-0">
                    <v-list-tile avatar>
                        <v-list-tile-avatar>
                            <img src="https://randomuser.me/api/portraits/men/85.jpg">
                        </v-list-tile-avatar>

                        <v-list-tile-content>
                            <v-list-tile-title>John Leider {{drawer.open}}</v-list-tile-title>
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
        </div>
        `
})