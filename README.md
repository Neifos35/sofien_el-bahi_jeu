# Welcome to fabulous Kasyno
## Avant-Propos
### Description
Le projet Kasyno est un jeu web sur le thème du Casino.  
Le jeu est réalisé en HTML, CSS, JavaScript et possède une base de données.  
  
### Accès à Kasyno
Le code du jeu est libre et est disponible sur github : https://github.com/Neifos35/sofien_el-bahi_jeu  

  
## Installer le projet en local  
Le projet Kasyno possède un back-end, il faut donc impérativement avoir un serveur web tel que Apache, Nginx ou tout autre serveur compatible avec PHP et MySQL pour l'exécuter localement. Voici les étapes à suivre pour installer le projet Kasyno en local :

* #### Prérequis :

Assurez-vous d'avoir un serveur web (comme Apache ou Nginx) installé sur votre machine.
Vous aurez besoin de PHP et MySQL installés également. Vous pouvez installer ceux-ci individuellement ou via des solutions telles que XAMPP, WAMP ou MAMP qui fournissent un ensemble complet de serveur web, PHP et MySQL.


* #### Téléchargement du code source :  

Rendez-vous sur le dépôt GitHub du projet Kasyno : https://github.com/Neifos35/sofien_el-bahi_jeu  
Téléchargez le code source en cliquant sur le bouton "Code" et en sélectionnant "Download ZIP", ou clônez le dépôt avec Git si vous êtes familier avec Git.  

* #### Extraction du code source :

Une fois le téléchargement terminé, extrayez le contenu du fichier ZIP dans un répertoire de votre choix sur votre machine.  

* #### Configuration de la base de données :  

Créez une base de données MySQL vide sur votre serveur local.    
Importez le fichier SQL fourni avec le projet (kasyno.sql) dans votre base de données fraîchement créée. Cela créera les tables nécessaires pour le jeu.  

* #### Configuration du fichier de configuration :  

Dans le répertoire du projet, recherchez un fichier Connexion.php au chemin : src/lib/Connexion.php et permettant de paramétrer la connexion à la base de données.  
Ouvrez ce fichier dans un éditeur de texte et modifiez les paramètres de connexion à la base de données pour correspondre à votre configuration locale (nom d'utilisateur, mot de passe, nom de la base de données, etc.).  

* #### Déploiement sur le serveur web :  

Déplacez le répertoire contenant le code source extrait dans le répertoire du serveur web de votre choix. Pour Apache, il s'agit souvent du répertoire htdocs ou www.  

*  #### Accès au jeu :  

Une fois les étapes précédentes terminées, ouvrez un navigateur web et accédez au jeu en tapant l'URL correspondant à votre serveur local suivi du chemin vers le répertoire où vous avez déployé le jeu.   

http://localhost/Kasyno/home.php.  

Pour pouvoir accéder au jeu, il faudra d'abord s'inscrire ou se connecter via une page de login. 


* #### Poker Texas hold'em :  
Pour le jeu de Texas hold'em, il est possible de jouer en ligne avec d'autres joueurs. 
Pour cela, il vous faudra lancer le server websocket en entrant la commande suivante dans le terminal (à la racine du projet) :  
```bash  
php websocket_server.php
```
Information supplémentaire concernant le jeu de poker :
- Le jeu de poker est en cours de développement et n'est pas encore totalement fonctionnel.
- Il est possible de créer une table de poker
- Il est possible de rejoindre une table de poker
- Une fois que 2 utilisateurs sont connectés à la même table, 2 cartes sont distribuées à chaque joueur.

* #### Gestion de l'amitié :  
Il est possible d'ajouter des amis et de les supprimer.
Pour cela, il suffit de se rendre sur la page 'Friendship.php' et de rechercher un utilisateur. Il est ensuite possible de lui envoyer une demande d'ami et une fois cette demande d'ami accepté, alors il apparaîtra dans vos amis.

* #### Jeux hors ligne :  
Il est possible de jouer au blackjack et à la roulette (face à la banque et ne nécessitant pas de connexion internet).
NB: La roulette est encore en cours de développement.
