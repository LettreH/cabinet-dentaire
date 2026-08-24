# Cabinet dentaire Dr. Dupont

Application web de gestion d'un cabinet dentaire, developpee en PHP et MySQL
selon une architecture MVC, sans framework.

Projet realise dans le cadre du titre professionnel Developpeur Web et Web Mobile.

---

## Fonctionnalites

### Front office (public)

- Page d'accueil : presentation du cabinet, services et horaires d'ouverture
- Prise de rendez-vous en ligne (sans creation de compte)
- Liste detaillee des soins proposes
- Page "A propos" : le praticien et son equipe
- Actualites sante, avec page de detail par article
- Navigation responsive (mobile, tablette, ordinateur)

### Back office (reserve a l'equipe)

- Tableau de bord : rendez-vous en attente, confirmes, patients, services
- Gestion des rendez-vous : consulter, confirmer, modifier, annuler, supprimer
- Gestion des patients : ajouter, modifier, supprimer
- Gestion des services : ajouter, modifier, supprimer
- Gestion des actualites : ajouter, modifier, supprimer
- Gestion des horaires d'ouverture

---

## Prerequis

- PHP 8.2 ou superieur
- MySQL 8 ou MariaDB 10.4 ou superieur
- Un serveur web (Apache, Nginx, ou le serveur integre de PHP)

---

## Installation

### 1. Recuperer le projet

    git clone https://github.com/LettreH/cabinet-dentaire.git
    cd cabinet-dentaire

### 2. Creer la base de donnees

    mysql -u root -p < database/01_creation_cabinet_dentaire.sql
    mysql -u root -p < database/02_insertion_cabinet_dentaire.sql

Le premier script cree la base et les six tables.
Le second insere un jeu de donnees de demonstration.

### 3. Creer un utilisateur MySQL dedie

Par principe de moindre privilege, l'application n'utilise pas le compte root :

    CREATE USER 'dentiste'@'localhost' IDENTIFIED BY 'votre_mot_de_passe';
    GRANT ALL PRIVILEGES ON cabinet_dentaire.* TO 'dentiste'@'localhost';
    FLUSH PRIVILEGES;

### 4. Configurer la connexion

Creer le fichier `config/config.php` :

    <?php
    return [
        'host'     => 'localhost',
        'dbname'   => 'cabinet_dentaire',
        'user'     => 'dentiste',
        'password' => 'votre_mot_de_passe'
    ];

Ce fichier est exclu du depot par le `.gitignore` : il ne doit jamais
etre publie car il contient les identifiants de la base.

### 5. Definir le mot de passe administrateur

Generer une empreinte :

    php -r "echo password_hash('VotreMotDePasse', PASSWORD_DEFAULT), PHP_EOL;"

Puis l'enregistrer en base :

    UPDATE utilisateurs
    SET mot_de_passe = 'empreinte_generee'
    WHERE email = 'jean.dupont@cabinet-dentaire.fr';

### 6. Lancer l'application

    cd public
    php -S localhost:8000

Le site est accessible sur http://localhost:8000

---

## Utilisation

| Page | Adresse |
| --- | --- |
| Accueil | `?page=accueil` |
| Services | `?page=services` |
| Actualites | `?page=actualites` |
| Un article | `?page=actualite&id=1` |
| A propos | `?page=apropos` |
| Prendre rendez-vous | `?page=rendezvous` |
| Connexion equipe | `?page=admin_connexion` |
| Back office | `?page=admin` |

---

## Architecture

    config/       connexion a la base (classe Database, PDO)
    core/         Router (routage) et Auth (sessions et protection)
    models/       entites et managers
    controllers/  PageController, AuthController, AdminController
    views/
      front/      pages publiques
      back/       pages d'administration
      partials/   header, footer, menu d'administration
    public/       point d'entree (index.php), CSS, images
    database/     scripts SQL de creation et d'insertion
    tests/        tests unitaires PHPUnit

### Le patron MVC

- **Modele** : les managers interrogent la base, les entites portent les donnees
  et la logique metier
- **Vue** : uniquement de l'affichage, aucune requete SQL
- **Controleur** : recoit la demande, appelle le modele, transmet a la vue

Toutes les pages passent par un point d'entree unique, `public/index.php`,
qui declare les routes et delegue au routeur.

### Entite et manager

Chaque table a deux classes distinctes, selon le principe de responsabilite unique :

- l'**entite** (`Patient`) represente un enregistrement et porte les methodes metier
- le **manager** (`PatientManager`) contient les requetes SQL et retourne des entites

Les entites heritent de `Entity`, qui fournit l'**hydratation** : une ligne SQL
est transformee en objet en appelant automatiquement les setters correspondants.

---

## Securite

- Mots de passe stockes sous forme d'empreinte (`password_hash`), verifies par
  `password_verify` : ils ne sont jamais dechiffrables
- Requetes preparees systematiques (protection contre les injections SQL)
- Echappement de toutes les sorties avec `htmlspecialchars` (protection XSS)
- `session_regenerate_id()` a la connexion (protection contre le vol de session)
- Message d'erreur de connexion identique quel que soit le cas, afin de ne pas
  reveler quels comptes existent
- Utilisateur MySQL restreint a la seule base du projet
- Toutes les pages du back office protegees par `Auth::exigerAdmin()`, appele
  dans le constructeur du controleur
- Validation systematique cote serveur, sans se fier aux controles HTML
- Identifiants de connexion exclus du depot Git

---

## Tests

Les tests unitaires couvrent les entites : hydratation, validation des setters
et methodes metier de formatage.

    php phpunit.phar

Ou, si PHPUnit est installe via Composer :

    ./vendor/bin/phpunit

---

## Auteur

Projet realise par Hermann.
Depot : https://github.com/LettreH/cabinet-dentaire
