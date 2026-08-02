<?php
/**
 * Point d'entree unique du site (front controller).
 * Fichier : public/index.php
 */

/* ------------------------------------------------------------
   AUTOLOAD
   Plus besoin d'ecrire un require_once par classe :
   PHP appelle cette fonction des qu'une classe inconnue est
   utilisee, et va chercher le fichier correspondant.

   new PatientManager()  ->  models/PatientManager.php
   ------------------------------------------------------------ */
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


/* ------------------------------------------------------------
   ROUTAGE
   ------------------------------------------------------------ */
$router = new Router();

$router->ajouter('accueil',    'PageController', 'accueil');
$router->ajouter('services',   'PageController', 'services');
$router->ajouter('actualites', 'PageController', 'actualites');
$router->ajouter('apropos',    'PageController', 'apropos');
$router->ajouter('rendezvous', 'PageController', 'rendezvous');
$router->ajouter('erreur404',  'PageController', 'erreur404');

// Page demandee dans l'URL (?page=services), accueil par defaut
$page = $_GET['page'] ?? 'accueil';

$router->router($page);
