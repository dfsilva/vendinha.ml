<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}{% endblock %}</title>
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

{% block content %}{% endblock %}

{% if constant("APP_ENV") === 'prod' %}
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
{% else %}
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
{% endif %}
<script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>

{% block footer %}{% endblock %}


</body>
</html>