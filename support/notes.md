Installer symfony : composer require symfony/flex (?bonne commande ? Pas noté !)

1. création controller : php bin/console make:controller TestController
2. création entity : src/Entity/Person.php
3. mettre en base de donnée : php bin/console d:s:u (doctrine:schéma update)

Pour mettre à jour :
php bin/console make:entity Person => mettre à jour l'entity
Puis remettre en base de donnée : php bin/console d:s:u -f

Semaine prochaine :
rajouter des personnes dans phpMyAdmin => Brad Pitt => formulaire pour ajouter une personne
Puis afficher les personnes dans la route (r = Read de CRUD (= SELECT de SQL))

ORM : composer req orm-pack => installer ORM (Object Relational Mapper)

Vendredi 25 nov
Pour la semaine pro : Voir pour le delete + modification
+ formulaires à customiser
+ refaire des controlleurs + formulaires
à voir : messages flash

dbdiagram.io

Vendredi 9 décembre
Diagrammes SQL (+ si possible commencer les formulaires des figures) + formulaires Angular
Authentification 