# Documentation utilisateur

## Admin

### Crédits BuzzExpert

L'interface envoie des SMS et des appels en utilisant des crédits BuzzExpert. Le nombre de crédit restant est visible sur l'accueil de l'inteface administrateur. 

### Flux
La saisie des horaires et des jours pour les flux correpondent au moment où la prochaine commande pourra être passée. En particulier, les jours de commande se saisissent de la manière suivante :
* Champ vide : tous
* x-x-x... où x est un entier parmis les suivants :
- 0 : dimanche
- 1 : lundi
- 2 : mardi
- 3 : mecredi
- 4 : jeudi
- 5 : vendredi
- 6 : samedi

## Administrateur système

### Fichier .env

Le fichier .env contient toutes les informations de paramétrage de l'interface dont :
* Le nom de l'application (affiché en haut à gauche)
* APP_DEBUG qui affiche une version plus complète des erreurs si la valeur est à true
* Les informations de connexion à la base de données
* Les informations de connexion à BuzzExpert
* Les information de connexion au serveur mail
* L'adresse mail utilisé pour les envois
* Le numero utilisé pour les appels
* La date d'analyse par défaut de début d'analyse pour la partie stat


### Fichiers de logs

Dans le dossier src/storage se situent trois fichiers de logs :

* **log_Appel.txt** : Correspond au texte des éventuelles erreurs lors du passage d'appels.
* **log_SMS.txt** : Correspond au texte des éventuelles erreurs lors de l'envoi de SMS.
* **log_BuzzExpert.txt** : Correpond aux réponses et accusés reception de BuzzExpert.

Signification des valeurs d'accusé reception :

* 1: Appel reçu, message transmis
* 2:Pas de réponse (nouvelle tentative dans 1h, dans la limite de 3 tentatives)
* 4: Occupé (nouvelle tentative dans 10 minutes, dans la limite de 3 tentatives) 
* 8: Décrochage du client 
* 16: Numéro non attribué / injoignable 
* 32: Erreur inconnue
* 64: Communication coupée (DLR inactif)
* 128: Appel en cours
* 256: Erreur interne (média non supporté) 
* 512: Erreur interne (numéro introuvable)

## Fonctionnement non-intuitif de l'interface

* Le responsable de commande dans les commandes groupées correpond à la dernière personne qui a fait l'action sur la commande, c'est-à-dire potentiellement l'utilisateur "Système" ou alors l'utlisateur de l'aglomération qui a mis une non-conformité.



## Statistiques

* Il faut toujours actualiser avant de générer un rapport.

* Une deuxiéme non-conformité sur une même commande dans l'interface "statistiques" efface la précédente. 
