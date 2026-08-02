<?php
/**
 * UtilisateurManager - requetes sur la table "utilisateurs".
 * Fichier : models/UtilisateurManager.php
 */
class UtilisateurManager extends Manager
{
    public function trouverParEmail(string $email): ?Utilisateur
    {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $requete->execute([':email' => $email]);

        $ligne = $requete->fetch();

        return $ligne ? new Utilisateur($ligne) : null;
    }

    public function trouverParId(int $id): ?Utilisateur
    {
        $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id");
        $requete->execute([':id' => $id]);

        $ligne = $requete->fetch();

        return $ligne ? new Utilisateur($ligne) : null;
    }
}
