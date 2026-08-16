<?php
/**
 * AuthController
 * Gere UNIQUEMENT l'authentification de l'equipe (back office).
 * Les patients n'ont pas de compte : ils passent par le formulaire
 * public de prise de rendez-vous, sans connexion.
 * Fichier : controllers/AuthController.php
 */
class AuthController extends Controller
{
    // ============================================================
    // CONNEXION EQUIPE (back office)
    // ============================================================
    public function connexionAdmin(): void
    {
        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $mdp   = $_POST['mot_de_passe'] ?? '';

            $manager     = new UtilisateurManager();
            $utilisateur = $manager->trouverParEmail($email);

            // Message identique dans les deux cas : on n'indique pas
            // si c'est l'email ou le mot de passe qui est faux
            // (on n'aide pas un attaquant a deviner les comptes valides).
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
    // DECONNEXION
    // ============================================================
    public function deconnexion(): void
    {
        Auth::deconnecter();
        header('Location: index.php?page=accueil');
        exit;
    }
}
