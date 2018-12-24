<!DOCTYPE html>
<html>
<head>
    {% block title %}{{ get_title() }}{% endblock %}
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">

    {{ assets.outputCss('cssBase') }}

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    {% block head %}{% endblock %}
</head>
<body>
<div id="app" v-cloak>
    <v-app dark>

        <vd-navigation default-title="{{ navBarTitle }}" root-uri="{{ url('') }}"></vd-navigation>

        <v-content style="margin-top:20px;" class="scroll-y">
            <vd-message ref="vdMessage"></vd-message>
            {% block content %}{% endblock %}
        </v-content>

        <v-footer
                v-if="$vuetify.breakpoint.mdAndUp"
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

{% include('firebase') %}

{{ assets.outputJs('jsBase') }}
{{ assets.outputJs('vdNavBar') }}
{{ assets.outputJs('vdMessage') }}

{% block footer %}{% endblock %}

</body>
</html>