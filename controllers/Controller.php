<?php
/**
 * Classe Controller (parente de tous les controleurs).
 * Fichier : controllers/Controller.php
 */
abstract class Controller
{
    /**
     * Affiche une vue entouree du header et du footer.
     *
     * @param string $vue     nom du fichier (sans .php)
     * @param array  $donnees variables transmises a la vue
     * @param string $zone    'front' (defaut) ou 'back'
     */
    protected function rendre(string $vue, array $donnees = [], string $zone = 'front'): void
    {
        extract($donnees);

        require __DIR__ . '/../views/partials/header.php';
        require __DIR__ . '/../views/' . $zone . '/' . $vue . '.php';
        require __DIR__ . '/../views/partials/footer.php';
    }
}
