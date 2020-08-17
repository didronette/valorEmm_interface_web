# valorEmm_interface_web

Ce git contient le projet d'une interface web de gestion des déchetterie mie au point pour l'entreprise Valor'Emm codée avec le Framework Laravel.

## Fonctionnalités

L'application permet de configurer différents flux de déchets, différentes déchetterie ainsi que différents comptes. Toutes ces informations permettent par la suite de passer des commandes (avec appel, SMS ou mail automatisé) et d'en retirer des statistiques.

## Dépendance

Pour fonctionner, l'interface nécéssite la configuration d'un .env dans le dossier src. Celui-ci doit contenir les informations suivantes :

* APP_NAME=?
* APP_ENV=local
* APP_KEY=?
* APP_DEBUG=false
* APP_LOG_LEVEL=info
* APP_URL=http://localhost

* DB_CONNECTION=mysql
* DB_HOST=127.0.0.1
* DB_PORT=?
* DB_DATABASE=?
* DB_USERNAME=?
* DB_PASSWORD=?

* BROADCAST_DRIVER=log
* CACHE_DRIVER=file
* SESSION_DRIVER=file
* SESSION_LIFETIME=120
* QUEUE_DRIVER=sync

* REDIS_HOST=127.0.0.1
* REDIS_PASSWORD=null
* REDIS_PORT=6379

* MAIL_DRIVER=?
* MAIL_HOST=?
* MAIL_PORT=?
* MAIL_USERNAME=?
* MAIL_PASSWORD=?
* MAIL_ENCRYPTION=
* MAIL_FROM_ADDRESS=?
* MAIL_FROM_NAME=?

* PUSHER_APP_ID=
* PUSHER_APP_KEY=
* PUSHER_APP_SECRET=
* PUSHER_APP_CLUSTER=mt1

* BUZZ_EXPERT_LOGIN=?
* BUZZ_EXPERT_PASSWORD=?
* BUZZ_EXPERT_CALLING_NUMBER=?

L'interface nécéssite également la configuration d'un compte BuzzExpert pour les SMS et appels. Le projet nécesite également l'instalation du paquet svoxpico pour la synthèse vocale. 

## Licence

Tout le code source de l'interface est sous licence libre GNU GPL 3.0.
