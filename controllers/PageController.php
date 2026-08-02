<?php
/**
 * PageController - affichage des pages du front office.
 * Les classes sont chargees automatiquement par l'autoload
 * declare dans public/index.php : plus aucun require_once ici.
 * Fichier : controllers/PageController.php
 */
class PageController extends Controller
{
    public function accueil(): void
    {
        $serviceManager = new ServiceManager();
        $horaireManager = new HoraireManager();

        $this->rendre('accueil', [
            'titrePage' => 'Accueil',
            'services'  => $serviceManager->lister(),
            'horaires'  => $horaireManager->lister()
        ]);
    }

    public function services(): void
    {
        $serviceManager = new ServiceManager();

        $this->rendre('services', [
            'titrePage' => 'Nos services',
            'services'  => $serviceManager->lister()
        ]);
    }

    public function actualites(): void
    {
        $actualiteManager = new ActualiteManager();

        $this->rendre('actualites', [
            'titrePage'  => 'Actualites',
            'actualites' => $actualiteManager->lister()
        ]);
    }

    public function apropos(): void
    {
        $this->rendre('apropos', ['titrePage' => 'A propos']);
    }

    public function rendezvous(): void
    {
        $serviceManager = new ServiceManager();

        $this->rendre('rendezvous', [
            'titrePage' => 'Prendre rendez-vous',
            'services'  => $serviceManager->lister()
        ]);
    }

    public function erreur404(): void
    {
        $this->rendre('erreur404', ['titrePage' => 'Page introuvable']);
    }
}
