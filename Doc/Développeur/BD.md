# Description de la base de données

Toutes le clés étrangères donnent lieu à des contraites sur la suppression.

## Flux

### id : Int 
Clé primaire de la table (incrément automatique).

### categorie : Varchar[255]
Catégorie du flux parmis :
* Benne
* DDS
* Autres déchets

### societe : Varchar[255]
Société qui réalise l'enlèvement du flux.

### type : Varchar[255]
Type ou intitulé du flux (ex : Tout venant, bois...).

### type_contact : Varchar[255]
Manière de joindre la société d'enlèvement, parmis :
* MAIL
* SMS
* APPEL 

### contact : Varchar[255]
Mail ou numéro de téléphone de la société à joindre pour les commandes.

### poids_moyen_benne : Int
Poids moyen d'une benne ou d'un contenant.

### delai_enlevement : Varchar[255]
Délai d'enlèvement en heure.

### horaires_commande_matin : Time
Horaire, s'il y a lieu, de commande du matin.

### horaires_commande_aprem : Time
Horaire, s'il y a lieu, de commande de l'après-midi.

### jour_commande : Varchar[255]
Jours possible de commande sous la forme x-x-x... où x est un entier parmis les suivants :
- 0 : dimanche
- 1 : lundi
- 2 : mardi
- 3 : mecredi
- 4 : jeudi
- 5 : vendredi
- 6 : samedi

## User (comptes)

### id : Int 
Clé primaire de la table (incrément automatique).

### name : Varchar[255] 
Nom d'utilisateur (unique).

### email : Varchar[255]
Email de l'utilisateur.

### password : Varchar[255]
Hash par bcrypt du mot de passe de l'utilisateur.

### type : Varchar[255]
Type de l'utilisateur parmis : 
* Administrateur
* Gérant
* Agent
* Agglomération

## Dechetterie

### id : Int 
Clé primaire de la table (incrément automatique).
### nom : Varchar[255]
Nom de la déchetterie (contrainte d'intégrité : unique).

### lien : Varchar[255] (lien d'identification)
Complément de la route login/{token} pour l'identification de la déchetterie.

## Commande (enregistrement)

Il serait plus juste de parler d'enregistrement que de commande. Chaque commande apparait plusieurs fois : une fois pour chaque action effectuée pour celle-ci. 

### id : Int 
Clé primaire de la table (incrément automatique).

### numero : Int 

Numéro de la commande (une commande correspond à un unique flux).

### numero_groupe : Int 

Numéro de groupe de la commande.

### multiplicite : Int 
Nombre de bennes, caisses ou autre contenant demandé.

### nc : Varchar[255] 
Non-conformité saisie par le gardien lors de la validation de l'enlèvement.

### ncagglo : Varchar[255] 
Non-conformité saisie par l'agglomération.

### todo : Varchar[255] 
Intitulé de l'action effectué sur la commande parmis :
* **À supprimer :** Indique que l'agent doit supprimer la commande.
* **Transmise :** Indique que la commande à été transmise par l'agglomération.


### statut : Varchar[255] 
Intitulé de l'action effectué sur la commande parmis :
* **En attente d'envoie :** Création de la commande.
* **Passée :** Passage de la commande avec contact de la société d'enlèvement.
* **Modifiée :** Modification de la commande.
* **Relancée :** Rappel effectué pour la commande.
* **NC (agglo) :** Ajout d'une non-conformité par l'agglomération.
* **Supprimée :** Commande supprimée et société prévenu du changement.
* **Annulée :** Anulation de la commande avant son envoi.
* **Annulée :** Modification du paramètre todo.

### dechetterie : Int 
Clé étrangère identifiant la déchetterie.

### flux : Int 
Clé étrangère identifiant le flux.
### compte : Int 
Clé étrangère identifiant le compte.

### contact_at : Int 
Heure de contact de la société d'enlèvement.

### created_at : Int 
Heure de création de l'enregistrement.

### updated_at : Int 

Heure de modification de l'enregistrement (inutile mais ajouté automatiquement avec le précédent par Laravel).
