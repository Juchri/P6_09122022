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

diagrammes :
- https://dbdiagram.io/d/63930cf9bae3ed7c4545cd22 
- https://app.diagrams.net/#G1oKw5-AT4hdlUS7I62LZ3EV68vT1drsxr 
- https://app.diagrams.net/#G14-21RlZoN6buCyc8sQWZNCh1-Ijnt6WX 

Lectures : 
- Pour faire des étoiles: https://github.com/blackknight467/StarRatingBundle 


Prochaine fois (16 décembre) :
- diagramme UML de classes / 
- authentification avec maker
- relations entre les tables
- formulaires Angular

Avancer sur : 
- authentification + création de la table user + relations entre les tables (+ upload d'images)
- page où on voit juste une figure


Prochaine fois (21 décembre / 18h30) :
- relations entre les tables
- formulaires Angular

Avancer sur :
- upload d'images
- diagramme UML de classes
