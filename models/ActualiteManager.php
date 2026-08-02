<?php
/**
 * ActualiteManager - requetes sur la table "actualites".
 * Fichier : models/ActualiteManager.php
 */
class ActualiteManager extends Manager
{
    /** @return Actualite[] */
    public function lister(): array
    {
        $sql = "SELECT a.*,
                       u.nom    AS auteur_nom,
                       u.prenom AS auteur_prenom
                FROM actualites a
                LEFT JOIN utilisateurs u ON a.utilisateur_id = u.id
                ORDER BY a.date_publication DESC";

        $lignes = $this->pdo->query($sql)->fetchAll();

        $actualites = [];
        foreach ($lignes as $ligne) {
            $actualites[] = new Actualite($ligne);
        }

        return $actualites;
    }

    public function trouverParId(int $id): ?Actualite
    {
        $sql = "SELECT a.*, u.nom AS auteur_nom, u.prenom AS auteur_prenom
                FROM actualites a
                LEFT JOIN utilisateurs u ON a.utilisateur_id = u.id
                WHERE a.id = :id";

        $requete = $this->pdo->prepare($sql);
        $requete->execute([':id' => $id]);

        $ligne = $requete->fetch();

        return $ligne ? new Actualite($ligne) : null;
    }

    public function ajouter(Actualite $actualite): bool
    {
        $sql = "INSERT INTO actualites (titre, contenu, image, date_publication, utilisateur_id)
                VALUES (:titre, :contenu, :image, :date_publication, :utilisateur_id)";

        $requete = $this->pdo->prepare($sql);

        $ok = $requete->execute([
            ':titre'            => $actualite->getTitre(),
            ':contenu'          => $actualite->getContenu(),
            ':image'            => $actualite->getImage(),
            ':date_publication' => $actualite->getDatePublication() ?? date('Y-m-d'),
            ':utilisateur_id'   => $actualite->getUtilisateurId()
        ]);

        if ($ok) {
            $actualite->setId((int) $this->pdo->lastInsertId());
        }

        return $ok;
    }

    public function modifier(Actualite $actualite): bool
    {
        $sql = "UPDATE actualites
                SET titre = :titre, contenu = :contenu, image = :image,
                    date_publication = :date_publication
                WHERE id = :id";

        $requete = $this->pdo->prepare($sql);

        return $requete->execute([
            ':titre'            => $actualite->getTitre(),
            ':contenu'          => $actualite->getContenu(),
            ':image'            => $actualite->getImage(),
            ':date_publication' => $actualite->getDatePublication(),
            ':id'               => $actualite->getId()
        ]);
    }

    public function supprimer(int $id): bool
    {
        $requete = $this->pdo->prepare("DELETE FROM actualites WHERE id = :id");
        return $requete->execute([':id' => $id]);
    }
}
