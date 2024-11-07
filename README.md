# Projet Deefy
# Author: SOM Desty S3C
# Date: 06/11/2024

#### RAPPORT ####
Voici le rendu attendu pour le mini-projet Deefy, qui inclut principalement les fonctionnalités développées lors des TD pour l’application Deefy.

- Le fichier README.md
- Le tableau de bord de l'application Deefy
- Le fichier de configuration de la base de données (scriptSql.txt)
- Le fichier de test de l'application Deefy

ATTENTION !!!
> Afin de vous connecter à la base de données mySql, vous devrez compléter le fichier de configuration en modifiant les valeurs de "dbname","username","password" et "database" src/repository/Config.db.ini.

Pour tester toutes les fonctions de l'application, vous pouvez utiliser l'utilisateur administrateur suivant :
- email : admin@mail.com
- mot de passe : admin

Vous pouvez aussi créer un nouvel utilisateur ou utiliser un utilisateur existant comme :
- email : user1@mail.com
- mot de passe : user1

## Tableau de bord de l'application Deefy

### Fonctionnalités principales

| 1-/ Ajouter une Playlist : Formulaire permettant de créer une nouvelle playlist en saisissant son nom |
| 2-/ Ajouter une Piste Podcast : Formulaire pour ajouter un podcast à une playlist (nom + fichier .mp3) |
| 3-/ Inscription Utilisateur : Formulaire d'inscription avec vérification de l'email et du mot de passe via 
 AuthnProvider::register()                                                                                   |
| 4-/ Connexion Utilisateur : Formulaire de connexion avec authentification via AuthnProvider::signin()       |
| 5-/ Afficher une Playlist : Affiche les pistes d'une playlist spécifique, choisie parmi toutes celles affichées ou via l'URL après vérification des droits d'accès utilisateur |
| 6-/ Afficher Toutes les Playlists : Affiche les playlists spécifiques à l'utilisateur connecté |

> [!NotaBene]
> - Chaque utilisateur peut créer une playlist, ajouter des pistes à une playlist, et afficher les playlists qu'il a créées.
> - L'administrateur peut afficher toutes les playlists et les pistes de chaque playlist.
> - Les utilisateurs connectés peuvent accéder à leurs différentes playlists et pistes.
> - Les utilisateurs non connectés doivent s'inscrire ou se connecter pour accéder aux fonctionnalités de l'application.
> - Les mots de passe sont stockés en base de données après chiffrement via password_hash().
> - Les utilisateurs sont authentifiés via AuthnProvider::signin() et Authn
> - Le style css permet à l'application de s'adapter à différente taille de fenêtre et d'écran pour une utilisation responsive de l'application

### Données et Gestion des Utilisateurs

| Sessions : Utilisées pour stocker la session utilisateur et les données relatives aux playlists |
| Authentification : Gestion des utilisateurs via la classe AuthnProvider, avec exception en cas d'erreur 
 d'identification                                                                                           |
| Authorization : Validation des droits d'accès pour afficher une playlist, via Authz::checkPlaylistOwner() |
| Données Utilisateurs : Stockées dans la table `users` de la base de données |
| Données Playlists : Stockées dans la table `playlists` de la base de données |
| Données Pistes : Stockées dans la table `tracks` de la base de données |

###  Compléments proposés

- [x] Affichage d’une playlist et l’ajout d’une piste à une playlist sont réservés au propriétaire de la playlist ou au rôle ADMIN.
- [x] Stockage adéquat des mots de passe, parades contre l’injection XSS et SQL.
- [x] Code HTML généré valide.
- [x] Utilisation d’un framework CSS pour la mise en page.


### Problèmes rencontrés
- [x] Le mot de passe est stocké en base de données après chiffrement via password cependant la vérification n'est pas valide même si les mots de passe correspondent en clair et en hachage
- Problème au niveau de l'accessibilité des fichier mp3


### Mon ressenti à la fin du mini projet 

    Étant en train de travailler de mon côté sur un bot permettant de lier un compte Spotify ou Youtube music à un tchat twitch pour créér un jeu de blindtest en ligne, travailler sur un projet d'une application de gestion de piste audio a été très intéressant et enrichissant pour mes projets personnels.

    En ce qui concerne les visuels, il est difficile de ne pas s'inspirer des plateforme de streaming populaire tel que Spotify, j'ai opté pour un code couleur bleuté rappelant les couleurs des menus playstations dont je suis fan. Je n'ai pas oublié de rendre l'application responsive en adaptant l'affichage en fonction de la taille de la fenêtre ou de l'écran/appareil utilisé.

En somme, j'ai apprécié travailler sur ce projet et m'y replongerai certainement plus tard même si je ne pense pas que je puisse innover le marché du streaming digital. C'est une expérience qui me permet de mieux visualiser et comprendre le fonctionnement des applications que l'on utilise quotidiennement. 
