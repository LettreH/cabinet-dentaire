<?php
/**
 * Point d'entree unique du site (front controller).
 * Fichier : public/index.php
 */

/* ---------- AUTOLOAD ---------- */
spl_autoload_register(function (string $nomClasse): void {
    $dossiers = [
        __DIR__ . '/../config/',
        __DIR__ . '/../core/',
        __DIR__ . '/../models/',
        __DIR__ . '/../controllers/',
    ];
    foreach ($dossiers as $dossier) {
        $fichier = $dossier . $nomClasse . '.php';
        if (file_exists($fichier)) {
            require_once $fichier;
            return;
        }
    }
});

/* ---------- SESSION ---------- */
Auth::demarrer();

/* ---------- ROUTAGE ---------- */
$router = new Router();

// ---- Pages publiques (front office) ----
$router->ajouter('accueil',    'PageController', 'accueil');
$router->ajouter('services',   'PageController', 'services');
$router->ajouter('actualites', 'PageController', 'actualites');
$router->ajouter('actualite',  'PageController', 'actualiteDetail');   // ?page=actualite&id=3
$router->ajouter('apropos',    'PageController', 'apropos');
$router->ajouter('rendezvous', 'PageController', 'rendezvous');
$router->ajouter('erreur404',  'PageController', 'erreur404');

// ---- Authentification (equipe) ----
$router->ajouter('admin_connexion', 'AuthController', 'connexionAdmin');
$router->ajouter('deconnexion',     'AuthController', 'deconnexion');

// ---- Back office : tableau de bord ----
$router->ajouter('admin', 'AdminController', 'tableauBord');

// ---- Back office : rendez-vous ----
$router->ajouter('admin_rdv',           'AdminController', 'rendezVous');
$router->ajouter('admin_rdv_confirmer', 'AdminController', 'rdvConfirmer');
$router->ajouter('admin_rdv_annuler',   'AdminController', 'rdvAnnuler');
$router->ajouter('admin_rdv_modifier',  'AdminController', 'rdvModifier');
$router->ajouter('admin_rdv_supprimer', 'AdminController', 'rdvSupprimer');

// ---- Back office : patients ----
$router->ajouter('admin_patients',          'AdminController', 'patients');
$router->ajouter('admin_patient_form',      'AdminController', 'patientFormulaire');
$router->ajouter('admin_patient_supprimer', 'AdminController', 'patientSupprimer');

// ---- Back office : services ----
$router->ajouter('admin_services',          'AdminController', 'services');
$router->ajouter('admin_service_form',      'AdminController', 'serviceFormulaire');
$router->ajouter('admin_service_supprimer', 'AdminController', 'serviceSupprimer');

// ---- Back office : actualites ----
$router->ajouter('admin_actualites',          'AdminController', 'actualites');
$router->ajouter('admin_actualite_form',      'AdminController', 'actualiteFormulaire');
$router->ajouter('admin_actualite_supprimer', 'AdminController', 'actualiteSupprimer');

// ---- Back office : horaires ----
$router->ajouter('admin_horaires', 'AdminController', 'horaires');

$page = $_GET['page'] ?? 'accueil';
$router->router($page);
