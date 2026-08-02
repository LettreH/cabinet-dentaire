<?php
/**
 * Entite Service - un soin propose par le cabinet.
 * Fichier : models/Service.php
 */
class Service extends Entity
{
    private ?int   $id          = null;
    private string $nom         = '';
    private string $description = '';
    private int    $duree       = 30;
    private float  $prix        = 0.0;

    public function getId(): ?int            { return $this->id; }
    public function getNom(): string         { return $this->nom; }
    public function getDescription(): string { return $this->description; }
    public function getDuree(): int          { return $this->duree; }
    public function getPrix(): float         { return $this->prix; }

    public function setId(int|string $id): void            { $this->id = (int) $id; }
    public function setNom(string $nom): void              { $this->nom = trim($nom); }
    public function setDescription(?string $d): void       { $this->description = (string) $d; }
    public function setDuree(int|string $duree): void      { $this->duree = (int) $duree; }
    public function setPrix(float|string $prix): void      { $this->prix = (float) $prix; }

    // ---------------- METHODES METIER ----------------
    public function getPrixFormate(): string
    {
        return number_format($this->prix, 2, ',', ' ') . ' &euro;';
    }

    public function getDureeFormatee(): string
    {
        if ($this->duree < 60) {
            return $this->duree . ' min';
        }

        $heures  = intdiv($this->duree, 60);
        $minutes = $this->duree % 60;

        return $minutes === 0 ? $heures . ' h' : $heures . ' h ' . $minutes;
    }
}
