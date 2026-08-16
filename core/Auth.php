<?php
/**
 * Classe Auth
 * Le "garde" de l'application : gere la session de l'equipe (back office)
 * et bloque l'acces aux pages protegees.
 * Methodes statiques : on les appelle sans creer d'objet (Auth::estConnecte()).
 * Fichier : core/Auth.php
 */
class Auth
{
    /** Demarre la session si ce n'est pas deja fait. */
    public static function demarrer(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /** Enregistre un membre de l'equipe connecte dans la session. */
    public static function connecterAdmin(int $id, string $nomComplet, string $role): void
    {
        // Nouvel id de session a la connexion : protection anti vol de session
        session_regenerate_id(true);

        $_SESSION['admin_id']   = $id;
        $_SESSION['admin_nom']  = $nomComplet;
        $_SESSION['admin_role'] = $role;
    }

    /** Un admin est-il connecte ? */
    public static function adminConnecte(): bool
    {
        return isset($_SESSION['admin_id']);
    }

    /**
     * Bloque l'acces si aucun admin n'est connecte.
     * A appeler en tete des pages du back office.
     */
    public static function exigerAdmin(): void
    {
        if (!self::adminConnecte()) {
            header('Location: index.php?page=admin_connexion');
            exit;
        }
    }

    /** Deconnexion : on vide et on detruit la session. */
    public static function deconnecter(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
