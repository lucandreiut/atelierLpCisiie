# atelierLpCisiie

##Installation via Composer

- Si vous êtes sous linux exécuter les deux commandes suivantes:
```
$ chmod -R 777 storage
$ chmod 666 config/database.php
```
- Exécuter la commande `$ composer update`
- Changer les paramètres de la base de données dans le fichier `config/database.php`
- Créer le schéma de la base de données en exécutant la commande `$ php migrate`
- Démmarer l'application sur le serveur interne de PHP en exécutant la commande `$ php -S localhost:8000`
- Aller sur l'url http://localhost:8000/lists pour visualiser la page de demo
