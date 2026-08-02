<?php
/**
 * Classe Controller (classe PARENTE)
 * Contient la methode d'affichage commune a tous les controleurs.
 * abstract = on ne peut pas creer d'objet Controller directement,
 * seulement des classes qui en heritent.
 * Fichier : controllers/Controller.php
 */
abstract class Controller
{
    /**
     * Affiche une vue entouree du header et du footer.
     *
     * @param string $vue      nom du fichier dans views/front/ (sans .php)
     * @param array  $donnees  variables transmises a la vue
     */
    protected function rendre(string $vue, array $donnees = []): void
    {
        // extract() transforme les cles du tableau en variables.
        // ['titrePage' => 'Accueil'] devient $titrePage = 'Accueil'
        extract($donnees);

        require __DIR__ . '/../views/partials/header.php';
        require __DIR__ . '/../views/front/' . $vue . '.php';
        require __DIR__ . '/../views/partials/footer.php';
    }
}
