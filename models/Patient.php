<?php
/**
 * Entite Patient
 * Represente UN patient. Ne contient aucune requete SQL :
 * c'est PatientManager qui s'en charge.
 * Fichier : models/Patient.php
 */
class Patient extends Entity
{
    private ?int    $id            = null;
    private string  $nom           = '';
    private string  $prenom        = '';
    private string  $email         = '';
    private ?string $telephone     = null;
    private ?string $dateNaissance = null;

    // ---------------- GETTERS ----------------
    public function getId(): ?int             { return $this->id; }
    public function getNom(): string          { return $this->nom; }
    public function getPrenom(): string       { return $this->prenom; }
    public function getEmail(): string        { return $this->email; }
    public function getTelephone(): ?string   { return $this->telephone; }
    public function getDateNaissance(): ?string { return $this->dateNaissance; }

    // ---------------- SETTERS ----------------
    // Les setters sont la porte d'entree : on en profite pour VALIDER.

    public function setId(int|string $id): void
    {
        $this->id = (int) $id;
    }

    public function setNom(string $nom): void
    {
        $nom = trim($nom);
        if ($nom === '') {
            throw new InvalidArgumentException('Le nom ne peut pas etre vide.');
        }
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        $prenom = trim($prenom);
        if ($prenom === '') {
            throw new InvalidArgumentException('Le prenom ne peut pas etre vide.');
        }
        $this->prenom = $prenom;
    }

    public function setEmail(string $email): void
    {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Adresse email invalide : ' . $email);
        }
        $this->email = $email;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = ($telephone === null || trim($telephone) === '')
            ? null
            : trim($telephone);
    }

    public function setDateNaissance(?string $date): void
    {
        $this->dateNaissance = ($date === null || $date === '') ? null : $date;
    }

    // ---------------- METHODES METIER ----------------
    // Voila tout l'interet de l'objet : il sait faire des choses,
    // contrairement a un simple tableau.

    public function getNomComplet(): string
    {
        return $this->prenom . ' ' . strtoupper($this->nom);
    }

    public function getAge(): ?int
    {
        if ($this->dateNaissance === null) {
            return null;
        }

        $naissance = new DateTime($this->dateNaissance);
        return $naissance->diff(new DateTime())->y;
    }
}
