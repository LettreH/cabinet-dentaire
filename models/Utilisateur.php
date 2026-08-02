<?php
/**
 * Entite Utilisateur - membre de l'equipe (back office).
 * Table "utilisateurs".
 * Fichier : models/Utilisateur.php
 */
class Utilisateur extends Entity
{
    private ?int    $id          = null;
    private string  $nom         = '';
    private string  $prenom      = '';
    private string  $email       = '';
    private string  $motDePasse  = '';   // toujours HACHE
    private string  $role        = 'assistant';

    public function getId(): ?int          { return $this->id; }
    public function getNom(): string       { return $this->nom; }
    public function getPrenom(): string    { return $this->prenom; }
    public function getEmail(): string     { return $this->email; }
    public function getMotDePasse(): string { return $this->motDePasse; }
    public function getRole(): string      { return $this->role; }

    public function setId(int|string $id): void       { $this->id = (int) $id; }
    public function setNom(string $nom): void         { $this->nom = trim($nom); }
    public function setPrenom(string $prenom): void   { $this->prenom = trim($prenom); }
    public function setEmail(string $email): void     { $this->email = trim($email); }
    public function setRole(string $role): void       { $this->role = $role; }

    // Le setter accepte le nom de colonne SQL "mot_de_passe" via l'hydratation
    public function setMotDePasse(string $hash): void { $this->motDePasse = $hash; }

    // ---------------- METHODES METIER ----------------
    public function getNomComplet(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function estAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
