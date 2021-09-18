# Cours Symfony

## Installation

### Nouveau projet
Commande pour créer un nouveau
```
symfony new Pixel --full
```

Pour installer les bibliothèques PHP externes entrez cette commande 
```
composer install
```

Configurez l'accés à la base de données dans le fichier .env
Ensuite mettre à jour la base de donnée avec la commande
```
php bin/console doctrine:schema:update --force
```

### Webpack
Webpack permet de condenser tous les fichiers assets dans un seul
Ex tous les fichier js sont minifiés et placés dans un seul fichier
Encore est un bundle Sf pour féciliter l'installation de Webpack

Pour installer les modules 
```
npm install --save-dev
```

Pour générer les fichier CSS et JS entrez la commande
```
npm run dev
```

Pour générer les fichier en production
```
npm run build
```

Pour observer les changements en dev
```
npm run watch
``` 
