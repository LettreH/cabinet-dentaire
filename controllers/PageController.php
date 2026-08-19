<?php
/**
 * PageController - affichage des pages du front office.
 * Fichier : controllers/PageController.php
 */
class PageController extends Controller
{
    // ============================================================
    // ACCUEIL
    // ============================================================
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

    // ============================================================
    // SERVICES
    // ============================================================
    public function services(): void
    {
        $serviceManager = new ServiceManager();

        $this->rendre('services', [
            'titrePage' => 'Nos services',
            'services'  => $serviceManager->lister()
        ]);
    }

    // ============================================================
    // ACTUALITES : la liste
    // ============================================================
    public function actualites(): void
    {
        $actualiteManager = new ActualiteManager();

        $this->rendre('actualites', [
            'titrePage'  => 'Actualites',
            'actualites' => $actualiteManager->lister()
        ]);
    }

    // ============================================================
    // ACTUALITE : un article en detail
    // ============================================================
    public function actualiteDetail(): void
    {
        $actualiteManager = new ActualiteManager();

        // (int) securise : une valeur non numerique devient 0
        $id        = (int) ($_GET['id'] ?? 0);
        $actualite = $actualiteManager->trouverParId($id);

        // Article inexistant -> page 404
        if ($actualite === null) {
            http_response_code(404);
            $this->erreur404();
            return;
        }

        $this->rendre('actualite_detail', [
            'titrePage' => $actualite->getTitre(),
            'actualite' => $actualite
        ]);
    }

    // ============================================================
    // A PROPOS
    // ============================================================
    public function apropos(): void
    {
        $this->rendre('apropos', ['titrePage' => 'A propos']);
    }

    // ============================================================
    // PRISE DE RENDEZ-VOUS : affichage ET traitement du formulaire
    // ============================================================
    public function rendezvous(): void
    {
        $serviceManager = new ServiceManager();

        $erreurs = [];
        $succes  = false;

        // Le formulaire a-t-il ete envoye ?
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // ---------- 1) Recuperation des champs ----------
            $nom       = trim($_POST['nom'] ?? '');
            $prenom    = trim($_POST['prenom'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $serviceId = (int) ($_POST['service_id'] ?? 0);
            $date      = $_POST['date_rdv'] ?? '';
            $heure     = $_POST['heure_rdv'] ?? '';
            $comment   = trim($_POST['commentaire'] ?? '');

            // ---------- 2) Validation cote serveur ----------
            // (le "required" du HTML se contourne facilement,
            //  on revalide donc toujours cote serveur)

            if ($nom === '' || $prenom === '' || $email === '') {
                $erreurs[] = 'Merci de renseigner votre nom, prenom et email.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erreurs[] = 'Adresse email invalide.';
            }

            if ($serviceId <= 0 || $serviceManager->trouverParId($serviceId) === null) {
                $erreurs[] = 'Merci de choisir un type de consultation.';
            }

            if ($date === '' || $heure === '') {
                $erreurs[] = 'Merci d indiquer une date et une heure.';
            }

            // La date doit etre dans le futur
            $dateHeure = $date . ' ' . $heure . ':00';
            if ($date !== '' && $heure !== '' && strtotime($dateHeure) < time()) {
                $erreurs[] = 'La date choisie est deja passee.';
            }

            // Le cabinet est-il ouvert ce jour-la ?
            if ($date !== '' && empty($erreurs)) {
                $jours = ['Monday'=>'lundi','Tuesday'=>'mardi','Wednesday'=>'mercredi',
                          'Thursday'=>'jeudi','Friday'=>'vendredi','Saturday'=>'samedi',
                          'Sunday'=>'dimanche'];

                $nomJour = $jours[date('l', strtotime($date))] ?? '';
                $horaire = (new HoraireManager())->trouverParJour($nomJour);

                if ($horaire !== null && $horaire->estFerme()) {
                    $erreurs[] = 'Le cabinet est ferme le ' . $nomJour . '.';
                }
            }

            // ---------- 3) Enregistrement ----------
            if (empty($erreurs)) {
                try {
                    // a) Le patient : on le retrouve ou on cree sa fiche
                    $patient = new Patient([
                        'nom'       => $nom,
                        'prenom'    => $prenom,
                        'email'     => $email,
                        'telephone' => $telephone
                    ]);

                    $patientManager = new PatientManager();
                    $patient        = $patientManager->trouverOuCreer($patient);

                    // b) Le rendez-vous, rattache a ce patient
                    $rdv = new RendezVous([
                        'date_heure'  => $dateHeure,
                        'statut'      => 'en attente',
                        'commentaire' => $comment,
                        'patient_id'  => $patient->getId(),
                        'service_id'  => $serviceId
                    ]);

                    $rdvManager = new RendezVousManager();

                    if ($rdvManager->ajouter($rdv)) {
                        $succes = true;
                        // On vide le formulaire apres succes
                        $_POST = [];
                    } else {
                        $erreurs[] = 'Une erreur est survenue, merci de reessayer.';
                    }

                } catch (InvalidArgumentException $e) {
                    $erreurs[] = $e->getMessage();
                } catch (PDOException $e) {
                    $erreurs[] = 'Une erreur technique est survenue, merci de reessayer.';
                }
            }
        }

        $this->rendre('rendezvous', [
            'titrePage' => 'Prendre rendez-vous',
            'services'  => $serviceManager->lister(),
            'erreurs'   => $erreurs,
            'succes'    => $succes
        ]);
    }

    // ============================================================
    // PAGE 404
    // ============================================================
    public function erreur404(): void
    {
        $this->rendre('erreur404', ['titrePage' => 'Page introuvable']);
    }
}
