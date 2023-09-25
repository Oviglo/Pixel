# Première page

Chaque page de l'application possède une route, c'est à partir de cette route que Symfony va appeler une méthode définie dans un controlleur. La méthode du contrôleur doit retourner une réponse.

## Les annotations

Une annotation est une instruction écrite dans un commentaire PHPDoc qui sera transformé en code PHP automatiquement lors de la génération du cache. L'instruction contient des paramètres, ça permet de rendre les codes plus lisibles et de développer plus rapidement.

Par exemple, l'annotation @Route permet de définir une route (url) pour une page.

## Le contrôlleur

Le controller va générer une réponse en fonction de la requête, par exemple, il va appeler les fonctions de requêtes de base de données et appeler la vue pour afficher la page. Il peut:

- Intercepter les superglobales GET et POST
- Générer un formulaire
- Appeler des fonctions de requête SQL
- Envoyer des données à la vue

Une classe controller peut hériter de la classe abstraite *AbstractController* fournie pas Sf qui possède des méthodes qui seront utilisées plus tard.

Le code suivant va retourner une réponse (simple texte) lorsque le client affiche la page index (route '/').

```php 
// src/Controller/AppController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
    * @Route("/")
    */
    #[Route("/")]
    public function home(): Response
    {
        return new Response("Hello World");
    }
}

```
Note: tous les fichiers PHP qui se trouvent dans le dossier src ont un espace de nom commençant par 'App'.

## Twig pour créer une page html

Pour une maintenance plus confortable, le code html est séparé du code PHP. Sf inclut un
moteur de template appelé Twig, il apporte des fonctions utiles et permet de sécuriser les
vues. Par exemple, le développeur back (PHP) va pouvoir contrôler les valeurs que le
développeur front (Twig) va utiliser. Plus d'informations sur le site de Twig
twig.symfony.com

Les fichiers Twig doivent se trouver dans le dossier templates, il existe par défaut le fichier
base.html.twig qui contient le code html commun à toutes les pages (balises html, head et
body). Pour plus de lisibilité du projet, le dossier templates sera organisé en fonction des
contrôleurs, ainsi les vues liées au controller **"AppController"** seront inclus dans le dossier
app (sans majuscule pour les templates).

```twig
{# templates/app/home.html.twig #}

{% extends "base.html.twig" %}

{% block body %}
<p>Bonjour à tous</p>
{% endblock %}
```

Cette vue va hériter de base.html.twig et redéfinir le contenu du block body.

Il reste ensuite à indiquer au contrôleur qu'il faut interpréter la vue et retourner le code html
généré grâce à la méthode render() fournie dans AbstractController.

```php
// src/Controller/AppController.php

public function home(): Response
{
    return $this->render('app/home.html.twig');
}

```