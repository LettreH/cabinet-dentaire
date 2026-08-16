<?php
/**
 * Entite RendezVous - un rendez-vous pris par un patient.
 * Fichier : models/RendezVous.php
 */
class RendezVous extends Entity
{
    private ?int    $id          = null;
    private string  $dateHeure   = '';
    private string  $statut      = 'en attente';
    private ?string $commentaire = null;
    private ?int    $patientId   = null;
    private ?int    $serviceId   = null;

    // Champs venant des jointures (lecture seule)
    private ?string $patientNom    = null;
    private ?string $patientPrenom = null;
    private ?string $serviceNom    = null;

    public function getId(): ?int            { return $this->id; }
    public function getDateHeure(): string   { return $this->dateHeure; }
    public function getStatut(): string      { return $this->statut; }
    public function getCommentaire(): ?string { return $this->commentaire; }
    public function getPatientId(): ?int     { return $this->patientId; }
    public function getServiceId(): ?int     { return $this->serviceId; }

    public function setId(int|string $id): void          { $this->id = (int) $id; }
    public function setDateHeure(string $dh): void       { $this->dateHeure = $dh; }
    public function setStatut(string $statut): void      { $this->statut = $statut; }
    public function setCommentaire(?string $c): void     { $this->commentaire = ($c === '' ? null : $c); }
    public function setPatientId(int|string|null $id): void { $this->patientId = ($id === null ? null : (int) $id); }
    public function setServiceId(int|string|null $id): void { $this->serviceId = ($id === null ? null : (int) $id); }

    public function setPatientNom(?string $n): void    { $this->patientNom = $n; }
    public function setPatientPrenom(?string $p): void { $this->patientPrenom = $p; }
    public function setServiceNom(?string $n): void    { $this->serviceNom = $n; }

    // ---------------- METHODES METIER ----------------
    public function getPatientComplet(): string
    {
        return trim($this->patientPrenom . ' ' . $this->patientNom);
    }

    public function getServiceNom(): ?string
    {
        return $this->serviceNom;
    }

    /** Date affichee au format francais : 05/08/2026 a 09:30 */
    public function getDateAffichee(): string
    {
        if ($this->dateHeure === '') {
            return '';
        }
        return date('d/m/Y \a H:i', strtotime($this->dateHeure));
    }

    /** Classe CSS selon le statut, pour colorer le badge */
    public function getClasseStatut(): string
    {
        return match ($this->statut) {
            'confirme'  => 'statut-confirme',
            'annule'    => 'statut-annule',
            default     => 'statut-attente',
        };
    }
}
