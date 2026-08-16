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

// Pages publiques
$router->ajouter('accueil',    'PageController', 'accueil');
$router->ajouter('services',   'PageController', 'services');
$router->ajouter('actualites', 'PageController', 'actualites');
$router->ajouter('apropos',    'PageController', 'apropos');
$router->ajouter('rendezvous', 'PageController', 'rendezvous');
$router->ajouter('erreur404',  'PageController', 'erreur404');

// Authentification : SEULEMENT le back office (equipe).
// Les patients n'ont pas de compte : ils prennent RDV via le formulaire public.
$router->ajouter('admin_connexion', 'AuthController', 'connexionAdmin');
$router->ajouter('deconnexion',     'AuthController', 'deconnexion');

// Back office (protege par Auth::exigerAdmin dans le controleur)
$router->ajouter('admin', 'AdminController', 'tableauBord');

$page = $_GET['page'] ?? 'accueil';
$router->router($page);
