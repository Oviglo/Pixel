# Commandes utiles 

Créer la base de donnes
``php bin/console doctrine:database:create`` 

Mettre à jour la db:
``php bin/console doctrine:schema:update --force`` 

Démarrer le serveur Symfony:
``symfony serve``

Stopper le serveur Symfony:
``symfony server:stop``

Afficher les routes:
``php bin/console debug:router``

Compiler les assets:
``npm run dev``

Observer les changement dans les assets (attention il faut ouvrir un nouveau terminal pour lancer d'autres commandes)
``npm run watch``

Créer une entité
``php bin/console make:entity``

Tester une route
``php bin/console router:match /game/new``