<?php
/**
 * Entite Horaire - les horaires d'un jour de la semaine.
 * Fichier : models/Horaire.php
 */
class Horaire extends Entity
{
    private ?int    $id             = null;
    private string  $jour           = '';
    private ?string $heureOuverture = null;
    private ?string $heureFermeture = null;
    private bool    $ferme          = false;

    public function getId(): ?int               { return $this->id; }
    public function getJour(): string           { return $this->jour; }
    public function getHeureOuverture(): ?string { return $this->heureOuverture; }
    public function getHeureFermeture(): ?string { return $this->heureFermeture; }
    public function estFerme(): bool            { return $this->ferme; }

    public function setId(int|string $id): void        { $this->id = (int) $id; }
    public function setJour(string $jour): void        { $this->jour = $jour; }
    public function setHeureOuverture(?string $h): void { $this->heureOuverture = $h; }
    public function setHeureFermeture(?string $h): void { $this->heureFermeture = $h; }
    public function setFerme(bool|int|string $f): void  { $this->ferme = (bool) $f; }

    // ---------------- METHODES METIER ----------------
    public function getJourAffiche(): string
    {
        return ucfirst($this->jour);
    }

    /** Retourne "09:00 - 18:00" ou "Ferme" */
    public function getPlageHoraire(): string
    {
        if ($this->ferme || !$this->heureOuverture || !$this->heureFermeture) {
            return 'Ferme';
        }

        return substr($this->heureOuverture, 0, 5) . ' - ' . substr($this->heureFermeture, 0, 5);
    }
}
