# learn-MVC-php

## Gestion des genres de films

Cette application utilise PHP, PDO et MySQL, sans framework. Le navigateur communique avec `GenreController.php` en JSON via Fetch API.

### Prérequis

- PHP 8.1 ou plus récent avec les extensions `PDO` et `pdo_mysql`
- MySQL

### Préparer MySQL

Créez la base et la table avec cette requête :

```sql
CREATE DATABASE gestion_films
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gestion_films;

CREATE TABLE genres (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);
```

Par défaut, la connexion utilise `127.0.0.1`, la base `gestion_films`, l'utilisateur `root` et un mot de passe vide. Vous pouvez remplacer ces paramètres avec les variables d'environnement `DB_HOST`, `DB_NAME`, `DB_USER` et `DB_PASSWORD`.

### Lancer le projet

Depuis la racine du dépôt, démarrez le serveur PHP intégré :

```bash
php -S localhost:8000
```

Ouvrez ensuite [http://localhost:8000/MVC/View/](http://localhost:8000/MVC/View/). L'API est servie par `MVC/Controller/GenreController.php`.

Le formulaire ajoute un genre et actualise la liste sans recharger la page. Les erreurs de validation sont renvoyées en HTTP 400 et les erreurs serveur en HTTP 500, sans détails techniques dans la réponse affichée au navigateur.