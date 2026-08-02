<?php
/**
 * Classe Manager (classe PARENTE de tous les managers)
 * Un manager s'occupe UNIQUEMENT du dialogue avec la base de donnees.
 * L'entite, elle, ne fait que porter les donnees.
 * Fichier : models/Manager.php
 */
abstract class Manager
{
    // protected : accessible dans cette classe et dans les classes filles
    protected PDO $pdo;

    public function __construct()
    {
        $database  = new Database();
        $this->pdo = $database->getConnexion();
    }
}
