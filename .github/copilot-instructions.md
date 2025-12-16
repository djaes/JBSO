# Instructions pour agents AI — JBSO

But : rendre un agent IA immédiatement opérationnel sur ce dépôt PHP (mini‑MVC, DBAL, Twig).

Architecture clé
- Entrée HTTP : [public/index.php](public/index.php#L1) (FastRoute dispatcher).
- Routes : [src/Routes/routes.php](src/Routes/routes.php#L1) — mappe URLs vers contrôleurs.
- Contrôleurs : étendent `AbstractController` ([src/Controller/AbstractController.php](src/Controller/AbstractController.php#L1)). Ils exposent `list`, `show`, `create`, `update`, `delete` et utilisent des templates Twig.
- Repositories : étendent `AbstractRepository` ([src/Repository/AbstractRepository.php](src/Repository/AbstractRepository.php#L1)). Implémentez `getTableName()` et `getEntityClass()` ; méthodes usuelles : `findAll`, `findById`, `create`, `update`, `delete`.
- Entités : dans `src/Entity/` — mapping SQL → entité via setters (`createEntityFromArray()` convertit snake_case → `setXxx`).
- DB : `src/Database/Connection.php` gère Doctrine DBAL et lit `.env` (variables : `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_DRIVER`).

Conventions & pièges spécifiques
- Templates sous `src/templates/<templatePath>/` : noms attendus `list.html.twig`, `show.html.twig`, `create.html.twig`, `update.html.twig`.
- Les tableaux passés aux repositories doivent utiliser les noms de colonnes SQL (snake_case).
- Vérifier l'existence exacte des setters (`setColonneSql`) — pas d'ORM implicite.
- `.env` manquant cause une exception dans `Connection::getConnection()`.
- Note : `AbstractController::create()` avait une validation `Label` inversée (fix en déc. 2025) — attention aux validations reproduites.

# Instructions pour agents AI — JBSO

But : rendre un agent IA immédiatement opérationnel sur ce dépôt PHP (mini‑MVC, DBAL, Twig).

Résumé impératif
- Entités : `src/Entity/`
- Repositories : `src/Repository/`
- Contrôleurs : `src/Controller/`
- Vues / templates Twig : `src/templates/`

Architecture clé
- Entrée HTTP : [public/index.php](public/index.php#L1) (FastRoute dispatcher).
- Routes : [src/Routes/routes.php](src/Routes/routes.php#L1).
- `AbstractController` fournit les actions CRUD (`list`, `show`, `create`, `update`, `delete`) et charge les templates Twig.
- `AbstractRepository` gère la conversion array→entité et les opérations SQL via Doctrine DBAL (`src/Database/Connection.php`).

Conventions spécifiques à ce projet
- Templates attendus sous `src/templates/<templatePath>/` avec fichiers `list.html.twig`, `show.html.twig`, `create.html.twig`, `update.html.twig`.
- Données persistées : utiliser noms de colonnes SQL (snake_case) dans les tableaux passés aux repositories.
- Mapping colonne→setter : `colonne_sql` → `setColonneSql()` (vérifier l'existence exacte du setter).
- `.env` est obligatoire pour la connexion DB (voir `src/Database/Connection.php`).

Commandes & workflows
- Installer dépendances :
```bash
composer install
cp .env.example .env
```
- Lancer serveur local :
```bash
php -S localhost:8000 -t public
```
- Exécuter tests :
```bash
# Unix / WSL
./vendor/bin/phpunit -c phpunit.xml
# Windows (PowerShell)
php ./vendor/phpunit/phpunit/phpunit -c phpunit.xml
```
Les tests chargent `.env` via `tests/bootstrap.php`.

Checklist : ajouter une ressource CRUD
1. Ajouter l'entité dans `src/Entity/` (setters requis).
2. Créer le repository dans `src/Repository/` (étendre `AbstractRepository`, implémenter `getTableName()` et `getEntityClass()`).
3. Créer le controller dans `src/Controller/` (étendre `AbstractController`, définir `getTemplatePath()` / `getName()`).
4. Ajouter les templates dans `src/templates/<templatePath>/` (`list|show|create|update`).
5. Déclarer la route dans [src/Routes/routes.php](src/Routes/routes.php#L1).

Fichiers à lire en priorité
- [public/index.php](../public/index.php#L1)
- [src/Routes/routes.php](../src/Routes/routes.php#L1)
- [src/Controller/AbstractController.php](../src/Controller/AbstractController.php#L1)
- [src/Repository/AbstractRepository.php](../src/Repository/AbstractRepository.php#L1)
- [src/Database/Connection.php](../src/Database/Connection.php#L1)
- [src/templates/](../src/templates/)

Remarque
- Si vous voulez réorganiser les templates vers une racine `templates/`, mettez à jour `AbstractController` et ajustez les chemins Twig.

Indiquez-moi s'il faut ajouter exemples concrets (contrôleur + entité + template) issus du repo.
- FastRoute pour le routage (routes déclarées dans `src/Routes/routes.php`).
