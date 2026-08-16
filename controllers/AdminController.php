<?php
/**
 * AdminController - tout le back office.
 * Chaque methode = une action du CRUD.
 * Le constructeur exige un admin connecte : toutes les pages
 * de ce controleur sont donc protegees automatiquement.
 * Fichier : controllers/AdminController.php
 */
class AdminController extends Controller
{
    public function __construct()
    {
        Auth::exigerAdmin();   // LE GARDE : bloque tout si pas connecte
    }

    // ============================================================
    // TABLEAU DE BORD
    // ============================================================
    public function tableauBord(): void
    {
        $patientManager = new PatientManager();
        $serviceManager = new ServiceManager();
        $rdvManager     = new RendezVousManager();

        $this->rendre('tableau_bord', [
            'titrePage'  => 'Tableau de bord',
            'nomAdmin'   => $_SESSION['admin_nom'] ?? '',
            'nbPatients' => count($patientManager->lister()),
            'nbServices' => count($serviceManager->lister()),
            'statuts'    => $rdvManager->compterParStatut()
        ], 'back');
    }

    // ============================================================
    // RENDEZ-VOUS
    // ============================================================
    public function rendezVous(): void
    {
        $rdvManager = new RendezVousManager();

        $this->rendre('rdv_liste', [
            'titrePage' => 'Gestion des rendez-vous',
            'rdvs'      => $rdvManager->lister()
        ], 'back');
    }

    public function rdvConfirmer(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        (new RendezVousManager())->changerStatut($id, 'confirme');
        header('Location: index.php?page=admin_rdv');
        exit;
    }

    public function rdvAnnuler(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        (new RendezVousManager())->changerStatut($id, 'annule');
        header('Location: index.php?page=admin_rdv');
        exit;
    }

    public function rdvSupprimer(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        (new RendezVousManager())->supprimer($id);
        header('Location: index.php?page=admin_rdv');
        exit;
    }

    public function rdvModifier(): void
    {
        $rdvManager     = new RendezVousManager();
        $serviceManager = new ServiceManager();
        $id             = (int) ($_GET['id'] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rdv = new RendezVous([
                'id'          => $id,
                'date_heure'  => ($_POST['date'] ?? '') . ' ' . ($_POST['heure'] ?? '') . ':00',
                'service_id'  => $_POST['service_id'] ?? null,
                'commentaire' => $_POST['commentaire'] ?? ''
            ]);
            $rdvManager->modifier($rdv);
            header('Location: index.php?page=admin_rdv');
            exit;
        }

        $this->rendre('rdv_modifier', [
            'titrePage' => 'Modifier le rendez-vous',
            'rdv'       => $rdvManager->trouverParId($id),
            'services'  => $serviceManager->lister()
        ], 'back');
    }

    // ============================================================
    // PATIENTS
    // ============================================================
    public function patients(): void
    {
        $patientManager = new PatientManager();

        $this->rendre('patients_liste', [
            'titrePage' => 'Gestion des patients',
            'patients'  => $patientManager->lister()
        ], 'back');
    }

    public function patientFormulaire(): void
    {
        $patientManager = new PatientManager();
        $id             = (int) ($_GET['id'] ?? 0);
        $erreurs        = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $patient = new Patient([
                    'nom'            => $_POST['nom'] ?? '',
                    'prenom'         => $_POST['prenom'] ?? '',
                    'email'          => $_POST['email'] ?? '',
                    'telephone'      => $_POST['telephone'] ?? '',
                    'date_naissance' => $_POST['date_naissance'] ?? ''
                ]);

                if ($id > 0) {
                    $patient->setId($id);
                    $patientManager->modifier($patient);
                } else {
                    $patientManager->ajouter($patient);
                }
                header('Location: index.php?page=admin_patients');
                exit;

            } catch (InvalidArgumentException $e) {
                $erreurs[] = $e->getMessage();
            }
        }

        $this->rendre('patient_formulaire', [
            'titrePage' => $id > 0 ? 'Modifier un patient' : 'Ajouter un patient',
            'patient'   => $id > 0 ? $patientManager->trouverParId($id) : null,
            'erreurs'   => $erreurs
        ], 'back');
    }

    public function patientSupprimer(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        (new PatientManager())->supprimer($id);
        header('Location: index.php?page=admin_patients');
        exit;
    }

    // ============================================================
    // SERVICES
    // ============================================================
    public function services(): void
    {
        $serviceManager = new ServiceManager();

        $this->rendre('services_liste', [
            'titrePage' => 'Gestion des services',
            'services'  => $serviceManager->lister()
        ], 'back');
    }

    public function serviceFormulaire(): void
    {
        $serviceManager = new ServiceManager();
        $id             = (int) ($_GET['id'] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service = new Service([
                'nom'         => $_POST['nom'] ?? '',
                'description' => $_POST['description'] ?? '',
                'duree'       => $_POST['duree'] ?? 30,
                'prix'        => $_POST['prix'] ?? 0
            ]);

            if ($id > 0) {
                $service->setId($id);
                $serviceManager->modifier($service);
            } else {
                $serviceManager->ajouter($service);
            }
            header('Location: index.php?page=admin_services');
            exit;
        }

        $this->rendre('service_formulaire', [
            'titrePage' => $id > 0 ? 'Modifier un service' : 'Ajouter un service',
            'service'   => $id > 0 ? $serviceManager->trouverParId($id) : null
        ], 'back');
    }

    public function serviceSupprimer(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        (new ServiceManager())->supprimer($id);
        header('Location: index.php?page=admin_services');
        exit;
    }

    // ============================================================
    // ACTUALITES
    // ============================================================
    public function actualites(): void
    {
        $actualiteManager = new ActualiteManager();

        $this->rendre('actualites_liste', [
            'titrePage'  => 'Gestion des actualites',
            'actualites' => $actualiteManager->lister()
        ], 'back');
    }

    public function actualiteFormulaire(): void
    {
        $actualiteManager = new ActualiteManager();
        $id               = (int) ($_GET['id'] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $actualite = new Actualite([
                'titre'            => $_POST['titre'] ?? '',
                'contenu'          => $_POST['contenu'] ?? '',
                'image'            => $_POST['image'] ?? '',
                'date_publication' => $_POST['date_publication'] ?? date('Y-m-d')
            ]);

            if ($id > 0) {
                $actualite->setId($id);
                $actualiteManager->modifier($actualite);
            } else {
                // On rattache l'article a l'admin connecte
                $actualite->setUtilisateurId($_SESSION['admin_id'] ?? null);
                $actualiteManager->ajouter($actualite);
            }
            header('Location: index.php?page=admin_actualites');
            exit;
        }

        $this->rendre('actualite_formulaire', [
            'titrePage' => $id > 0 ? 'Modifier une actualite' : 'Ajouter une actualite',
            'actualite' => $id > 0 ? $actualiteManager->trouverParId($id) : null
        ], 'back');
    }

    public function actualiteSupprimer(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        (new ActualiteManager())->supprimer($id);
        header('Location: index.php?page=admin_actualites');
        exit;
    }

    // ============================================================
    // HORAIRES
    // ============================================================
    public function horaires(): void
    {
        $horaireManager = new HoraireManager();

        // Enregistrement des modifications (tous les jours d'un coup)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($horaireManager->lister() as $horaire) {
                $id    = $horaire->getId();
                $ferme = isset($_POST['ferme'][$id]);

                $horaire->setFerme($ferme);
                $horaire->setHeureOuverture($ferme ? null : ($_POST['ouverture'][$id] ?? null));
                $horaire->setHeureFermeture($ferme ? null : ($_POST['fermeture'][$id] ?? null));

                $horaireManager->modifier($horaire);
            }
            header('Location: index.php?page=admin_horaires');
            exit;
        }

        $this->rendre('horaires_formulaire', [
            'titrePage' => 'Gestion des horaires',
            'horaires'  => $horaireManager->lister()
        ], 'back');
    }
}
