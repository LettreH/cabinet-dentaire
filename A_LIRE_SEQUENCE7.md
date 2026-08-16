# Sequence 7 - Back office complet (CRUD)

Cette archive ajoute tout l'espace d'administration : tableau de bord
+ gestion des rendez-vous, patients, services, actualites et horaires.

## 1. Extraire l'archive

    unzip -o back_office.zip -d ~/cabinet-dentaire

Fichiers ajoutes / remplaces :
  models/RendezVous.php            (nouvelle entite)
  models/RendezVousManager.php     (nouveau manager)
  controllers/AdminController.php  (remplace : les 6 sections CRUD)
  public/index.php                 (remplace : toutes les routes admin)
  views/partials/menu_admin.php    (menu lateral du back office)
  views/partials/fin_admin.php     (fermeture de la zone)
  views/back/tableau_bord.php      (remplace)
  views/back/rdv_liste.php
  views/back/rdv_modifier.php
  views/back/patients_liste.php
  views/back/patient_formulaire.php
  views/back/services_liste.php
  views/back/service_formulaire.php
  views/back/actualites_liste.php
  views/back/actualite_formulaire.php
  views/back/horaires_formulaire.php

## 2. Ajouter le CSS du back office

Colle tout le contenu de css_back_office.txt a la FIN de
public/css/style.css.

## 3. Tester

    cd ~/cabinet-dentaire/public && php -S localhost:8000

Connecte-toi au back office :
  http://localhost:8000/?page=admin_connexion
  (jean.dupont@cabinet-dentaire.fr / Admin2026)

Puis navigue dans le menu lateral :
  - Tableau de bord : les chiffres cles
  - Rendez-vous     : confirmer / modifier / annuler / supprimer
  - Patients        : ajouter / modifier / supprimer
  - Services        : ajouter / modifier / supprimer
  - Actualites      : ajouter / modifier / supprimer
  - Horaires        : modifier les horaires de la semaine

## Le patron CRUD (a savoir expliquer)

Chaque section suit le meme schema :
  lister()      -> READ    (afficher la liste)
  formulaire()  -> CREATE + UPDATE (le meme formulaire pour les deux)
  supprimer()   -> DELETE

Le formulaire sert a la fois a AJOUTER et MODIFIER :
  - sans id  -> on cree
  - avec id  -> on modifie
C'est ce qui evite de dupliquer le code.

## Securite

  - Tout le controleur est protege par Auth::exigerAdmin()
    appele dans le constructeur : une seule ligne protege
    les 20+ actions du back office.
  - Toutes les requetes SQL sont preparees (anti injection).
  - Toutes les sorties HTML passent par htmlspecialchars (anti XSS).
  - Les suppressions demandent une confirmation JavaScript.
