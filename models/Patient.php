<?php
/**
 * Classe Patient (Modele)
 * Gere toutes les operations sur la table "patients".
 * A placer dans : models/Patient.php
 */

require_once __DIR__ . '/../config/Database.php';

class Patient
{
    // Les donnees d'un patient (encapsulees)
    private ?int $id = null;
    private string $nom = '';
    private string $prenom = '';
    private string $email = '';
    private ?string $telephone = null;
    private ?string $dateNaissance = null;

    // La connexion a la base, partagee par toutes les methodes
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnexion();
    }

    // ------------------------------------------------------------
    // GETTERS et SETTERS : la porte d'entree vers les attributs prives
    // ------------------------------------------------------------
    public function getId(): ?int          { return $this->id; }
    public function getNom(): string       { return $this->nom; }
    public function getPrenom(): string    { return $this->prenom; }
    public function getEmail(): string     { return $this->email; }

    public function setNom(string $nom): void                { $this->nom = $nom; }
    public function setPrenom(string $prenom): void          { $this->prenom = $prenom; }
    public function setEmail(string $email): void            { $this->email = $email; }
    public function setTelephone(?string $tel): void         { $this->telephone = $tel; }
    public function setDateNaissance(?string $date): void    { $this->dateNaissance = $date; }

    // ------------------------------------------------------------
    // LISTER tous les patients
    // ------------------------------------------------------------
    public function lister(): array
    {
        $sql = "SELECT * FROM patients ORDER BY nom, prenom";
        $requete = $this->pdo->query($sql);

        return $requete->fetchAll();
    }

    // ------------------------------------------------------------
    // TROUVER un patient par son id
    // ------------------------------------------------------------
    public function trouverParId(int $id): ?array
    {
        $sql = "SELECT * FROM patients WHERE id = :id";
        $requete = $this->pdo->prepare($sql);
        $requete->execute([':id' => $id]);

        $resultat = $requete->fetch();

        return $resultat ?: null;
    }

    // ------------------------------------------------------------
    // AJOUTER un patient
    // ------------------------------------------------------------
    public function ajouter(): bool
    {
        $sql = "INSERT INTO patients (nom, prenom, email, telephone, date_naissance)
                VALUES (:nom, :prenom, :email, :telephone, :date_naissance)";

        $requete = $this->pdo->prepare($sql);

        $ok = $requete->execute([
            ':nom'            => $this->nom,
            ':prenom'         => $this->prenom,
            ':email'          => $this->email,
            ':telephone'      => $this->telephone,
            ':date_naissance' => $this->dateNaissance
        ]);

        if ($ok) {
            $this->id = (int) $this->pdo->lastInsertId();
        }

        return $ok;
    }

    // ------------------------------------------------------------
    // MODIFIER un patient existant
    // ------------------------------------------------------------
    public function modifier(int $id): bool
    {
        $sql = "UPDATE patients
                SET nom = :nom, prenom = :prenom, email = :email,
                    telephone = :telephone, date_naissance = :date_naissance
                WHERE id = :id";

        $requete = $this->pdo->prepare($sql);

        return $requete->execute([
            ':nom'            => $this->nom,
            ':prenom'         => $this->prenom,
            ':email'          => $this->email,
            ':telephone'      => $this->telephone,
            ':date_naissance' => $this->dateNaissance,
            ':id'             => $id
        ]);
    }

    // ------------------------------------------------------------
    // SUPPRIMER un patient
    // ------------------------------------------------------------
    public function supprimer(int $id): bool
    {
        $sql = "DELETE FROM patients WHERE id = :id";
        $requete = $this->pdo->prepare($sql);

        return $requete->execute([':id' => $id]);
    }
}
