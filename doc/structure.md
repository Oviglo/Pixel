# Structure d'un projet Symfony

Lors de la création d'un projet, Symfony ajoute une structure composée des dossiers suivants

**assets**
: Il va contenir les fichier scss, js et image de l'application, Webpack va ensuite les compacter pour créer des fichiers qui seront mis dans le dossier public

**bin**
: Contient des applications utiles pour le développement comme la console

**config**
: La conguration de l'application se fait dans ce dossier, il contient principalement des fichiers yaml

**public**
: Comme dans la plupart des projet il y a le fichier index.php dans ce dossier ainsi que les assets généré par Webpack

**src**
: Le dossier src contient le code source PHP de l'application il contient les controlleurs, entités, formulaires etc.

**templates**
: Ce dossier est la partie "vue" de l'application, il contient tous les fichiers de template qui seront générés par le moteur Twig

**tests**
: Dans une application importante, il est utile de développer des tests fonctionnels ou unitaires, ils seront écrit dans ce dossier

**translations**
: Symfony possède un outils pour traduire une application, les traductions sont placées dans ce dossier sous forme de fichier yaml

**var**
: Ce dossier contient les fichiers de cache et de log

## Dossier src

Tout les fichiers PHP dans ce dossier doivent avoir un espace de nom commencant par "App".

**Controller**
: Les controllers ont des méthodes qui sont appelées pour chacune des page de l'application, ces méthodes retournent une reponse serveur (html, json, pdf, file etc.)

**Entity**
: Les entités représente la base de données sous forme d'objet PHP

**Repository**
: Les repository sont des classes qui vont permettre de lire dans la base de données, elles contiennent les requêtes.

**Form**
: Les formulaires de l'application sont décris dans ce dossier