P6 Projet Application syfony php 

Site collaboratif 

Obj : faire connaître le sport au grand public + aider à l'apprentissage des figures (tricks)

1_ contenu riche avec l'intérêt des utilisateurs 
2_ Buisiness de mise en raltion avec les marques de snowboard 
3_ fichier readme pour installation du projet 


--

1- un annuaire des figures de snowboard (10 figures)
2- création, modification, consultation des figures 
3- espace de dsicussion commun 

1 page d'accueil avec liste des figures 
Page de création
Page de modif 
Page de présentation d'une figure

Objectifs : 
url : compréhension rapide + référencement naturel 
site responsive 
écrire les issues 
bundle externe pour charger les données des figures snowboard

Issues : 

- Faire les diagrammes UML (modèles de données, classes, séquences, uses cases)
- Créer repisotory gitHub + issues 
- 



Installation Composer : https://getcomposer.org/download/ 


php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

To install Composer in the directory : 

sudo mv composer.phar /usr/local/bin/composer


Utilisation de Simfony CLI : 

 ➜ symfony new --full P6_23102022


Pour lancer le serveur : 

 ➜ cd P6_09122022
 ➜ symfony server:start

 Pour y accéder : http://localhost:8000/ 
 Pour stopper le serveur local : Ctrl + C  en ligne de commande


Pour installer symfony flex:  https://symfony.com/doc/current/setup/flex.html
Pour comprendre, via cet article : https://afsy.fr/avent/2017/08-symfony-flex-la-nouvelle-facon-de-developper-avec-symfony
composer require symfony/flex 


