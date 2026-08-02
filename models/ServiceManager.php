<?php
/**
 * ServiceManager - requetes sur la table "services".
 * Fichier : models/ServiceManager.php
 */
class ServiceManager extends Manager
{
    /** @return Service[] */
    public function lister(): array
    {
        $lignes = $this->pdo->query("SELECT * FROM services ORDER BY nom")->fetchAll();

        $services = [];
        foreach ($lignes as $ligne) {
            $services[] = new Service($ligne);
        }

        return $services;
    }

    public function trouverParId(int $id): ?Service
    {
        $requete = $this->pdo->prepare("SELECT * FROM services WHERE id = :id");
        $requete->execute([':id' => $id]);

        $ligne = $requete->fetch();

        return $ligne ? new Service($ligne) : null;
    }

    public function ajouter(Service $service): bool
    {
        $sql = "INSERT INTO services (nom, description, duree, prix)
                VALUES (:nom, :description, :duree, :prix)";

        $requete = $this->pdo->prepare($sql);

        $ok = $requete->execute([
            ':nom'         => $service->getNom(),
            ':description' => $service->getDescription(),
            ':duree'       => $service->getDuree(),
            ':prix'        => $service->getPrix()
        ]);

        if ($ok) {
            $service->setId((int) $this->pdo->lastInsertId());
        }

        return $ok;
    }

    public function modifier(Service $service): bool
    {
        $sql = "UPDATE services
                SET nom = :nom, description = :description,
                    duree = :duree, prix = :prix
                WHERE id = :id";

        $requete = $this->pdo->prepare($sql);

        return $requete->execute([
            ':nom'         => $service->getNom(),
            ':description' => $service->getDescription(),
            ':duree'       => $service->getDuree(),
            ':prix'        => $service->getPrix(),
            ':id'          => $service->getId()
        ]);
    }

    public function supprimer(int $id): bool
    {
        $requete = $this->pdo->prepare("DELETE FROM services WHERE id = :id");
        return $requete->execute([':id' => $id]);
    }
}
