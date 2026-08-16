<?php
/**
 * RendezVousManager - requetes sur la table "rendez_vous".
 * Fichier : models/RendezVousManager.php
 */
class RendezVousManager extends Manager
{
    /** @return RendezVous[] tous les RDV avec patient et service (jointures) */
    public function lister(): array
    {
        $sql = "SELECT rv.*,
                       p.nom    AS patient_nom,
                       p.prenom AS patient_prenom,
                       s.nom    AS service_nom
                FROM rendez_vous rv
                JOIN patients p ON rv.patient_id = p.id
                JOIN services s ON rv.service_id = s.id
                ORDER BY rv.date_heure DESC";

        $lignes = $this->pdo->query($sql)->fetchAll();

        $rdvs = [];
        foreach ($lignes as $ligne) {
            $rdvs[] = new RendezVous($ligne);
        }
        return $rdvs;
    }

    public function trouverParId(int $id): ?RendezVous
    {
        $sql = "SELECT rv.*, p.nom AS patient_nom, p.prenom AS patient_prenom,
                       s.nom AS service_nom
                FROM rendez_vous rv
                JOIN patients p ON rv.patient_id = p.id
                JOIN services s ON rv.service_id = s.id
                WHERE rv.id = :id";

        $requete = $this->pdo->prepare($sql);
        $requete->execute([':id' => $id]);

        $ligne = $requete->fetch();
        return $ligne ? new RendezVous($ligne) : null;
    }

    /** Cree un RDV (utilise par le formulaire public de prise de RDV) */
    public function ajouter(RendezVous $rdv): bool
    {
        $sql = "INSERT INTO rendez_vous (date_heure, statut, commentaire, patient_id, service_id)
                VALUES (:date_heure, :statut, :commentaire, :patient_id, :service_id)";

        $requete = $this->pdo->prepare($sql);
        $ok = $requete->execute([
            ':date_heure'  => $rdv->getDateHeure(),
            ':statut'      => $rdv->getStatut(),
            ':commentaire' => $rdv->getCommentaire(),
            ':patient_id'  => $rdv->getPatientId(),
            ':service_id'  => $rdv->getServiceId()
        ]);

        if ($ok) {
            $rdv->setId((int) $this->pdo->lastInsertId());
        }
        return $ok;
    }

    /** Change seulement le statut (confirmer / annuler) */
    public function changerStatut(int $id, string $statut): bool
    {
        $requete = $this->pdo->prepare(
            "UPDATE rendez_vous SET statut = :statut WHERE id = :id"
        );
        return $requete->execute([':statut' => $statut, ':id' => $id]);
    }

    /** Modifie la date, le service et le commentaire */
    public function modifier(RendezVous $rdv): bool
    {
        $sql = "UPDATE rendez_vous
                SET date_heure = :date_heure, service_id = :service_id,
                    commentaire = :commentaire
                WHERE id = :id";

        $requete = $this->pdo->prepare($sql);
        return $requete->execute([
            ':date_heure'  => $rdv->getDateHeure(),
            ':service_id'  => $rdv->getServiceId(),
            ':commentaire' => $rdv->getCommentaire(),
            ':id'          => $rdv->getId()
        ]);
    }

    public function supprimer(int $id): bool
    {
        $requete = $this->pdo->prepare("DELETE FROM rendez_vous WHERE id = :id");
        return $requete->execute([':id' => $id]);
    }

    /** Compte par statut, pour le tableau de bord */
    public function compterParStatut(): array
    {
        $sql = "SELECT statut, COUNT(*) AS total FROM rendez_vous GROUP BY statut";
        $lignes = $this->pdo->query($sql)->fetchAll();

        $resultat = ['en attente' => 0, 'confirme' => 0, 'annule' => 0];
        foreach ($lignes as $ligne) {
            $resultat[$ligne['statut']] = (int) $ligne['total'];
        }
        return $resultat;
    }
}
