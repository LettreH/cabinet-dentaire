<?php
/**
 * AdminController
 * Pages du back office. Toutes protegees : on exige un admin connecte.
 * Fichier : controllers/AdminController.php
 */
class AdminController extends Controller
{
    public function __construct()
    {
        // LE GARDE : cette ligne bloque l'acces a TOUTES les methodes
        // de ce controleur si aucun admin n'est connecte.
        Auth::exigerAdmin();
    }

    // Tableau de bord : quelques chiffres cles
    public function tableauBord(): void
    {
        $patientManager = new PatientManager();
        $serviceManager = new ServiceManager();

        $this->rendre('tableau_bord', [
            'titrePage'   => 'Tableau de bord',
            'nbPatients'  => count($patientManager->lister()),
            'nbServices'  => count($serviceManager->lister()),
            'nomAdmin'    => $_SESSION['admin_nom'] ?? ''
        ], 'back');
    }
}
