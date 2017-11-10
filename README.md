# atelierLpCisiie

Ce projet a été réalisé dans le cadre du 1er Atelier de la License Pro. CISIIE. 
Les auteurs de ce projet sont :

- [Allan DEMARBRE](https://github.com/demarbre1u)
- [Luc ANDRÉ](https://github.com/lucandreiut)
- [Mohamed ALHASNE](https://github.com/alhasnecode)

Le code PHP a été linté avec le Linter [PHP_CodeSniffer](http://pear.php.net/package/PHP_CodeSniffer).

### Installation via Composer
- Clonez le dépôt git :
```
$ git clone git@github.com:lucandreiut/atelierLpCisiie.git
```
- Exécutez la commande `$ composer update`
- Changez les paramètres de la base de données dans le fichier `config/database.php`, changez les identifiants MySQL,puis donnez lui les droits suivants (sous Linux) :
```
$ chmod 666 config/database.php
```
- Créez la base de données dont vous avez indiqué le nom dans le fichier `config/database.php` précédemment, puis créez le schéma de la base de données en exécutant la commande `$ php migrate`
- Démarrez l'application sur le serveur interne de PHP en exécutant la commande `$ php -S localhost:8000`
- Allez sur l'url http://localhost:8000/ pour accéder à l'application
- Donnez les droits au répertoire `storage/` (sous Linux) :
```
$ chmod -R 777 storage
```
