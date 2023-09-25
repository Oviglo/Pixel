# Twig

Le moteur de template Twig propose une maniére d'écrire du code plus orienté template que le langage PHP, il est plus facile à maitriser pour un développeur front.

## Syntaxe

Il existe 3 sortes de balises dans Twig:

- *Balises d'affichage* ``{{ }}`` Utilisées pour afficher quelques choses sur la page html
- *Balises de procédure* ``{% %}`` Utilisées pour faire des conditions, boucles etc.
- *Balises de commentaire* ``{# #}`` Utilisées pour afficher un commentaire

## Afficher et transformer des valeurs

Les balises d'affiche sont utilisées pour afficher une valeur provenant du controlleur.

```twig
{{ value }}
```
Il est possible de transformer une valeur grâce aux filtres

```twig
{{ value|upper }}
```

Pour formatter une date

```twig
{{ datePublished|date('d/m/Y') }}
```

Il est également possible de mettre plusieurs filtres à la suite

```twig
{{ title|trim|striptags|upper }}
```

Des variables peuvent être créés dans un template

```twig
{% set name = 'Paul' %}
```

## Array et objets

La syntaxe des tableaux ressemble au Javascript

```twig
{% set array = [1, 2, 3] %}
{% set article = {'title': 'Mon article', 'public': true} %}
```

Pour afficher propriétés d'un objet le point est utilisé, ainsi Twig va d'abord appeler la propriété si elle est en public, sinon il va appeler automatiquement le getter.

```twig
{# Twig va appeler la méthode getUsername() de l'objet #}
{{ user.username }}
```

## Conditions

Simple condition if

```twig
{% if value == 10 %}
Affiché si la condition est vraie
{% endif %}
```

Test si une valeur existe

```twig
{% if value is defined %}
La valeur est définie
{% endif %}
```

Il existe des mots clés pour faire des tests tel que **even, odd, empty ou null**, le mot clé not permet la négation.
Exemple de conditions chainées

```twig
{% if value < 10 %}
...
{% elseif value < 100 %}
...
{% else %}
...
{% endif %}
```

## Boucles

Dans Twig, il existe qu'un type de boucle, la boucle for qui est équivalente au foreach.

```twig
{% for i in 0..10 %}
{{ i }},
{% endfor %}

{% for article in articles %}
{{ article.title }},
{% endfor %}

{% for key, article in articles %}
{{ key }}: {{ article.title }},
{% endfor %}
```

A l'intérieur d'une boucle existe une valeur ``loop`` pour obtenir des informations sur la boucle tel que l'index ``loop.index0``, si c'est la première ou la dernière itération ``loop.first``, ``loop.last``.

## Héritage et blocks

L'héritage permet de ne pas réécrire du code html dans chaque pages

C'est un des avantage de Twig, les blocks permettent de modifier des parties de code d'un template parent.

```twig
{# base.html.twig #}
<!DOCTYPE html>
<html>
    <head>
    <title>{% block title %}Mon site{% endblock %}</title>
    </head>
    <body>
        <div class="container">
        {% block body %}
        {% endblock %}
        </div>
    </body>
</html>
```

```twig
{# app/home.html.twig #}
{% extends 'base.html.twig' %}
{# la fonction parent() va afficher le contenu de base.html.twig => "Page d'accueil - Mon site" #}
{% block title %}Page d'accueil - {{ parent() }}{% endblock %}

{% block body %}
Contenu de la page
{% endblock %}
```

## L'intégration(embed)

Permet d'intégrer une partie de code html et de modifier certaines partie.

Par exemple une card de Bootstrap contient une partie header, body et footer. Embed permet d'ajouter une card et de modifier seulement ces parties.

```twig
{# decorator/_card.html.twig #}
<div class="card">
    <div class="card-header">
        {{ block('header') }}
    </div>

    <div class="card-body">
        {{ block('body') }}
    </div>

    <div class="card-footer">
        {{ block("footer") }}
    </div>
</div>
```

Cette partie peut être intégrée dans un autre template.

```twig
{% embed "decorator/_card.html.twig" %}
    {% block header %}Hello{% endblock %}
    {% block body %}
        Contenu de la card
    {% endblock %}
    {% block footer %}{{ "now"|date("d/m/Y") }}{% endblock %}
{% endembed %}

```

## Fonctions

- ``{{ path('route_name', {}) }}`` Génére un lien à partir du nom de la route