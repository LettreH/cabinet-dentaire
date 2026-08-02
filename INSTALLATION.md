# Sequence 4 - Architecture MVC (version Entite + Manager)

## Ce qui change par rapport a la version precedente

| Avant | Maintenant |
| --- | --- |
| Un `require_once` par classe | Un **autoload** unique dans `public/index.php` |
| `Patient` faisait entite + SQL | `Patient` (entite) et `PatientManager` (SQL) separes |
| Les modeles renvoyaient des tableaux | Ils renvoient des **objets** hydrates |
| `$patient['nom']` dans les vues | `$patient->getNom()` |

## Installation

1. Extraire l'archive dans le dossier du projet (les fichiers existants sont remplaces) :

       unzip -o sequence4_mvc_v2.zip -d ~/cabinet-dentaire

2. Supprimer l'ancien fichier devenu inutile :

       rm -f ~/cabinet-dentaire/models/Model.php

3. Lancer le serveur :

       cd ~/cabinet-dentaire/public && php -S localhost:8000

4. Ouvrir http://localhost:8000

## Structure des classes

    config/
      config.php            identifiants MySQL (non versionne)
      Database.php          connexion PDO

    core/
      Router.php            associe une page a un controleur

    controllers/
      Controller.php        classe parente : methode rendre()
      PageController.php    pages du front office

    models/
      Entity.php            classe parente : hydrater()
      Manager.php           classe parente : connexion PDO
      Patient.php           entite   + PatientManager.php
      Service.php           entite   + ServiceManager.php
      Actualite.php         entite   + ActualiteManager.php
      Horaire.php           entite   + HoraireManager.php

    views/
      partials/             header.php, footer.php
      front/                accueil, services, actualites, apropos,
                            rendezvous, erreur404

    public/
      index.php             autoload + routage
      css/style.css         responsive mobile first

## Le mecanisme "trouver ou creer"

Utilise a la prise de rendez-vous en ligne :

    $patient = new Patient([
        'nom'    => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'email'  => $_POST['email']
    ]);

    $manager = new PatientManager();
    $patient = $manager->trouverOuCreer($patient);

    // $patient->getId() est maintenant disponible
    // pour rattacher le rendez-vous

Si l'email existe deja, on recupere la fiche existante.
Sinon la fiche est creee. Cela evite les doublons.
