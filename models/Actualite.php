<?php
/**
 * Entite Actualite - un article publie sur le site.
 * Fichier : models/Actualite.php
 */
class Actualite extends Entity
{
    private ?int    $id              = null;
    private string  $titre           = '';
    private string  $contenu         = '';
    private ?string $image           = null;
    private ?string $datePublication = null;
    private ?int    $utilisateurId   = null;

    // Renseignes par la jointure avec la table utilisateurs
    private ?string $auteurNom    = null;
    private ?string $auteurPrenom = null;

    public function getId(): ?int              { return $this->id; }
    public function getTitre(): string         { return $this->titre; }
    public function getContenu(): string       { return $this->contenu; }
    public function getImage(): ?string        { return $this->image; }
    public function getDatePublication(): ?string { return $this->datePublication; }
    public function getUtilisateurId(): ?int   { return $this->utilisateurId; }

    public function setId(int|string $id): void          { $this->id = (int) $id; }
    public function setTitre(string $titre): void        { $this->titre = trim($titre); }
    public function setContenu(string $contenu): void    { $this->contenu = $contenu; }
    public function setImage(?string $image): void       { $this->image = $image ?: null; }
    public function setDatePublication(?string $d): void { $this->datePublication = $d; }
    public function setAuteurNom(?string $n): void       { $this->auteurNom = $n; }
    public function setAuteurPrenom(?string $p): void    { $this->auteurPrenom = $p; }

    public function setUtilisateurId(int|string|null $id): void
    {
        $this->utilisateurId = ($id === null) ? null : (int) $id;
    }

    // ---------------- METHODES METIER ----------------
    public function getDateFormatee(): string
    {
        return $this->datePublication
            ? date('d/m/Y', strtotime($this->datePublication))
            : '';
    }

    public function getAuteur(): ?string
    {
        if ($this->auteurNom === null) {
            return null;
        }

        return trim($this->auteurPrenom . ' ' . $this->auteurNom);
    }

    /** Debut du contenu, pour un affichage en liste */
    public function getExtrait(int $longueur = 160): string
    {
        if (mb_strlen($this->contenu) <= $longueur) {
            return $this->contenu;
        }

        return mb_substr($this->contenu, 0, $longueur) . '...';
    }
}
