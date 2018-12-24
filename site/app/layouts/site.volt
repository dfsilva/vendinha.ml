{% extends 'templates/base_tpl.volt' %}

{% block title %}
    {{ super() }}
{% endblock %}

{% block head %}
    {{ super() }}

    {% if include_head is defined %}
        {% include(include_head) %}
    {% else %}
        {%  include('meta') %}
    {% endif %}
{% endblock %}

{% block content %}
    {{ super() }}
    {{ content() }}
{% endblock %}

{% block footer %}
    {{ super() }}

    {% if templateAfter is defined %}
        {% include(templateAfter) %}
    {% endif %}

{% endblock %}