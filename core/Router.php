<?php
/**
 * Classe Router
 * Fait le lien entre une page demandee (?page=services)
 * et le controleur charge de l'afficher.
 * Fichier : core/Router.php
 */
class Router
{
    // Tableau des routes : 'nom de page' => controleur + methode
    private array $routes = [];

    /**
     * Enregistre une route.
     * Exemple : ajouter('services', 'PageController', 'services')
     */
    public function ajouter(string $page, string $controleur, string $methode): void
    {
        $this->routes[$page] = [
            'controleur' => $controleur,
            'methode'    => $methode
        ];
    }

    /**
     * Trouve la route demandee et execute le bon controleur.
     */
    public function router(string $page): void
    {
        // Page inconnue -> erreur 404
        if (!isset($this->routes[$page])) {
            http_response_code(404);
            $page = 'erreur404';
        }

        $route = $this->routes[$page];

        $nomControleur = $route['controleur'];
        $nomMethode    = $route['methode'];

        // On cree l'objet controleur puis on appelle sa methode
        $controleur = new $nomControleur();
        $controleur->$nomMethode();
    }
}
