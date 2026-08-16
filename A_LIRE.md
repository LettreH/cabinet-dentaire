# Nettoyage : suppression de l'espace patient

D'apres le retour du mentor, les patients n'ont PAS de compte.
On retire donc toute la connexion / inscription patient.
Le formulaire public de prise de rendez-vous, lui, reste intact.

## 1. Extraire l'archive (remplace 4 fichiers)

    unzip -o nettoyage_patient.zip -d ~/cabinet-dentaire

Fichiers remplaces :
  public/index.php              -> routes patient retirees
  controllers/AuthController.php -> ne garde que connexionAdmin + deconnexion
  core/Auth.php                 -> ne garde que la logique admin
  views/partials/header.php     -> plus de lien connexion dans le menu

## 2. Supprimer les 2 vues devenues inutiles

    rm ~/cabinet-dentaire/views/front/inscription.php
    rm ~/cabinet-dentaire/views/front/connexion.php

## 3. (Optionnel) Retirer inscribe/getHash du PatientManager

Dans models/PatientManager.php, tu peux supprimer les methodes
inscrire() et getHashParEmail() : elles ne servent plus puisque
les patients ne se connectent pas.
Tu GARDES en revanche trouverOuCreer(), ajouter(), lister(), etc.

## 4. (Optionnel) La colonne mot_de_passe de la table patients

Elle ne gene pas si tu la laisses. Pour etre rigoureux :

    sudo mariadb
    USE cabinet_dentaire;
    ALTER TABLE patients DROP COLUMN mot_de_passe;
    exit;

## 5. Tester

    cd ~/cabinet-dentaire/public && php -S localhost:8000

  - Le site public fonctionne, le menu n'a plus "Connexion".
  - Prise de RDV : http://localhost:8000/?page=rendezvous  (sans compte)
  - Connexion equipe : http://localhost:8000/?page=admin_connexion
  - Back office protege : http://localhost:8000/?page=admin

## A dire en soutenance

"Les patients n'ont pas de compte : ils prennent rendez-vous via un
formulaire public, et leur fiche est creee automatiquement grace au
mecanisme trouver-ou-creer base sur l'email unique. Seule l'equipe
s'authentifie, pour acceder au back office."
