{% extends 'templates/base_tpl.volt' %}

{% block title %}Vendinha{% endblock %}

{% block content %}
    {{ super() }}
    {{ content() }}
{% endblock %}

{% block footer %}
    {{ super() }}

    {% if templateAfter is defined %}
        {% include(templateAfter) %}
    {% endif %}

    {% include('firebase') %}
{% endblock %}