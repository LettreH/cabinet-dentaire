<?php
/**
 * HoraireManager - requetes sur la table "horaires".
 * Fichier : models/HoraireManager.php
 */
class HoraireManager extends Manager
{
    /** @return Horaire[] dans l'ordre des jours de la semaine */
    public function lister(): array
    {
        $lignes = $this->pdo->query("SELECT * FROM horaires ORDER BY jour")->fetchAll();

        $horaires = [];
        foreach ($lignes as $ligne) {
            $horaires[] = new Horaire($ligne);
        }

        return $horaires;
    }

    public function trouverParJour(string $jour): ?Horaire
    {
        $requete = $this->pdo->prepare("SELECT * FROM horaires WHERE jour = :jour");
        $requete->execute([':jour' => $jour]);

        $ligne = $requete->fetch();

        return $ligne ? new Horaire($ligne) : null;
    }

    public function modifier(Horaire $horaire): bool
    {
        $sql = "UPDATE horaires
                SET heure_ouverture = :ouverture,
                    heure_fermeture = :fermeture,
                    ferme = :ferme
                WHERE id = :id";

        $requete = $this->pdo->prepare($sql);

        return $requete->execute([
            ':ouverture' => $horaire->getHeureOuverture(),
            ':fermeture' => $horaire->getHeureFermeture(),
            ':ferme'     => $horaire->estFerme() ? 1 : 0,
            ':id'        => $horaire->getId()
        ]);
    }
}
