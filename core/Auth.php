<?php
/**
 * Classe Auth
 * Le "garde" de l'application : elle sait qui est connecte,
 * ouvre et ferme les sessions, et bloque l'acces aux pages protegees.
 * Toutes ses methodes sont statiques : on les appelle sans creer d'objet,
 * ex : Auth::estConnecte()
 * Fichier : core/Auth.php
 */
class Auth
{
    /**
     * Demarre la session si ce n'est pas deja fait.
     * A appeler une fois au debut de index.php.
     */
    public static function demarrer(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Enregistre un patient connecte dans la session.
     */
    public static function connecterPatient(int $id, string $nomComplet): void
    {
        // On regenere l'id de session : protection contre le vol de session
        session_regenerate_id(true);

        $_SESSION['patient_id']  = $id;
        $_SESSION['patient_nom'] = $nomComplet;
    }

    /**
     * Enregistre un membre de l'equipe connecte dans la session.
     */
    public static function connecterAdmin(int $id, string $nomComplet, string $role): void
    {
        session_regenerate_id(true);

        $_SESSION['admin_id']   = $id;
        $_SESSION['admin_nom']  = $nomComplet;
        $_SESSION['admin_role'] = $role;
    }

    // ---------- PATIENTS ----------
    public static function patientConnecte(): bool
    {
        return isset($_SESSION['patient_id']);
    }

    // ---------- ADMIN ----------
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
            header('Location: index.php?page=connexion');
            exit;
        }
    }

    /**
     * Deconnexion : on vide et on detruit la session.
     */
    public static function deconnecter(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
