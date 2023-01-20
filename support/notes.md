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


Prochaine fois (29 décembre / 18h15) :
- formulaires Angular

Avancer sur :
- roles de l'admin
- upload de message
- font awesome (?)
- affichage de tous les commentaires sur une page
- menu + chat : seulement si on est loggué

Prochaine fois (6 janvier) :
- formulaires Angular

Avancer sur :
- roles de l'admin ✅
- menu + chat : seulement si on est loggué ✅

Problèmes de la semaine : 
- n'arrive pas à connecter main.css
- upload image qui bug
- nom de l'auteur dans les messages

Prochaine fois (20  janvier) :

- bouton supprimer commentaire : delete js is confirm ? 
- faire un fonction asset twig pour connecter css
- préparer soutenance blanche !
- ne pas pouvoir ajouter une noouvelle figure si admin (admin avant dans l'url ?)
- rediriger main au truc principal 
- enlever difficulté ? + statut d'un message
- enlever boutons éditer + supprimer sur toutes les figures (peut-être qu'on peut l'éditer que si on est créateur ?)
- enlever ajouter une figure si loug_out ! 
- conntecter images (défuat celle qui y est et si il y a un fichier on le met!) => + mettre en fichier des jolies photos ! 