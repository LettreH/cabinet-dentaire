# Sequence 6 - Authentification (guide d'installation)

## 1. La colonne mot_de_passe (deja fait)

    ALTER TABLE patients ADD COLUMN mot_de_passe VARCHAR(255) NULL AFTER email;

## 2. Extraire l'archive

    unzip -o sequence6_auth.zip -d ~/cabinet-dentaire

Cela ajoute / remplace :
  core/Auth.php                    (le "garde" : sessions)
  controllers/AuthController.php   (inscription, connexion, deconnexion)
  controllers/AdminController.php  (back office protege)
  controllers/Controller.php       (mis a jour : front / back)
  models/Utilisateur.php           (entite)
  models/UtilisateurManager.php    (requetes)
  views/front/inscription.php
  views/front/connexion.php
  views/back/connexion_admin.php
  views/back/tableau_bord.php
  views/partials/header.php        (mis a jour : liens connexion)
  public/index.php                 (mis a jour : session + routes)

## 3. Completer PatientManager.php

Ouvre models/PatientManager.php et colle le contenu de
models/PatientManager_AJOUTS.txt AVANT la derniere accolade }.
(Deux methodes : inscrire() et getHashParEmail())

## 4. Completer le CSS

Colle le contenu de css_ajouts.txt a la fin de
public/css/style.css.

## 5. Donner un mot de passe a l'admin de test

L'admin "Dr. Dupont" existe deja en base mais son mot de passe
etait un faux hash. On le remplace par un vrai.

a) Genere un hash pour le mot de passe "Admin2026" :

    php -r "echo password_hash('Admin2026', PASSWORD_DEFAULT), PHP_EOL;"

b) Copie le resultat (commence par \$2y\$) et mets-le en base :

    sudo mariadb
    USE cabinet_dentaire;
    UPDATE utilisateurs
    SET mot_de_passe = 'COLLER_LE_HASH_ICI'
    WHERE email = 'jean.dupont@cabinet-dentaire.fr';
    exit;

## 6. Tester

    cd ~/cabinet-dentaire/public && php -S localhost:8000

Parcours a essayer :
  - Inscription patient    : http://localhost:8000/?page=inscription
  - Connexion patient      : http://localhost:8000/?page=connexion
  - Connexion equipe       : http://localhost:8000/?page=admin_connexion
       email : jean.dupont@cabinet-dentaire.fr
       mdp   : Admin2026
  - Back office protege    : http://localhost:8000/?page=admin
       (te redirige vers la connexion si tu n'es pas admin)
  - Deconnexion            : http://localhost:8000/?page=deconnexion

## Points de securite (a savoir expliquer)

  - password_hash() : le mot de passe est hache (irreversible).
  - password_verify() : verifie sans jamais dechiffrer.
  - session_regenerate_id() : nouvel id a la connexion -> anti vol de session.
  - Message d'erreur identique "email ou mot de passe incorrect" :
    on n'aide pas un attaquant a deviner les emails valides.
  - Auth::exigerAdmin() dans le constructeur d'AdminController :
    une seule ligne protege toutes les pages du back office.
