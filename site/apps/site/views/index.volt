{% extends 'layouts/base_tpl.volt' %}

{% block title %}Vendinha{% endblock %}

{% block content %}
    {{ content() }}
{% endblock %}

{% block footer %}

    {% if templateAfter is defined %}
        {% include(templateAfter) %}
    {% endif %}

    {% include('firebase') %}
{% endblock %}