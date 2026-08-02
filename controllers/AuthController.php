<?php
/**
 * AuthController
 * Gere l'inscription, la connexion et la deconnexion.
 * Fichier : controllers/AuthController.php
 */
class AuthController extends Controller
{
    // ============================================================
    // INSCRIPTION PATIENT
    // ============================================================
    public function inscription(): void
    {
        $erreurs = [];
        $succes  = false;

        // Le formulaire a-t-il ete envoye ?
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1) On recupere et nettoie les champs
            $nom       = trim($_POST['nom'] ?? '');
            $prenom    = trim($_POST['prenom'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $mdp       = $_POST['mot_de_passe'] ?? '';
            $mdp2      = $_POST['mot_de_passe_confirmation'] ?? '';

            // 2) Validations
            if ($nom === '' || $prenom === '' || $email === '') {
                $erreurs[] = 'Merci de remplir tous les champs obligatoires.';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erreurs[] = 'Adresse email invalide.';
            }
            if (strlen($mdp) < 8) {
                $erreurs[] = 'Le mot de passe doit contenir au moins 8 caracteres.';
            }
            if ($mdp !== $mdp2) {
                $erreurs[] = 'Les deux mots de passe ne correspondent pas.';
            }

            // 3) L'email est-il deja utilise ?
            $manager = new PatientManager();
            if (empty($erreurs) && $manager->trouverParEmail($email) !== null) {
                $erreurs[] = 'Un compte existe deja avec cet email.';
            }

            // 4) Tout est bon -> on cree le compte
            if (empty($erreurs)) {
                try {
                    $patient = new Patient([
                        'nom'       => $nom,
                        'prenom'    => $prenom,
                        'email'     => $email,
                        'telephone' => $telephone
                    ]);

                    $manager->inscrire($patient, $mdp);
                    $succes = true;

                } catch (InvalidArgumentException $e) {
                    $erreurs[] = $e->getMessage();
                }
            }
        }

        $this->rendre('inscription', [
            'titrePage' => 'Inscription',
            'erreurs'   => $erreurs,
            'succes'    => $succes
        ], 'front');
    }

    // ============================================================
    // CONNEXION PATIENT
    // ============================================================
    public function connexionPatient(): void
    {
        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $mdp   = $_POST['mot_de_passe'] ?? '';

            $manager = new PatientManager();
            $hash    = $manager->getHashParEmail($email);

            // Message volontairement identique dans les deux cas :
            // on ne dit pas si c'est l'email ou le mot de passe qui est faux
            // (on ne veut pas aider un attaquant a deviner les emails valides)
            if ($hash === null || !password_verify($mdp, $hash)) {
                $erreurs[] = 'Email ou mot de passe incorrect.';
            } else {
                $patient = $manager->trouverParEmail($email);
                Auth::connecterPatient($patient->getId(), $patient->getPrenom());

                header('Location: index.php?page=accueil');
                exit;
            }
        }

        $this->rendre('connexion', [
            'titrePage' => 'Connexion',
            'erreurs'   => $erreurs
        ], 'front');
    }

    // ============================================================
    // CONNEXION ADMIN (back office)
    // ============================================================
    public function connexionAdmin(): void
    {
        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $mdp   = $_POST['mot_de_passe'] ?? '';

            $manager     = new UtilisateurManager();
            $utilisateur = $manager->trouverParEmail($email);

            if ($utilisateur === null || !password_verify($mdp, $utilisateur->getMotDePasse())) {
                $erreurs[] = 'Email ou mot de passe incorrect.';
            } else {
                Auth::connecterAdmin(
                    $utilisateur->getId(),
                    $utilisateur->getNomComplet(),
                    $utilisateur->getRole()
                );

                header('Location: index.php?page=admin');
                exit;
            }
        }

        $this->rendre('connexion_admin', [
            'titrePage' => 'Espace professionnel',
            'erreurs'   => $erreurs
        ], 'back');
    }

    // ============================================================
    // DECONNEXION (patient ou admin)
    // ============================================================
    public function deconnexion(): void
    {
        Auth::deconnecter();
        header('Location: index.php?page=accueil');
        exit;
    }
}
