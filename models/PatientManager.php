<?php
/**
 * PatientManager
 * Toutes les requetes SQL concernant la table "patients".
 * Retourne des OBJETS Patient, pas des tableaux.
 * Fichier : models/PatientManager.php
 */
class PatientManager extends Manager
{
    /** @return Patient[] */
    public function lister(): array
    {
        $lignes = $this->pdo
            ->query("SELECT * FROM patients ORDER BY nom, prenom")
            ->fetchAll();

        $patients = [];
        foreach ($lignes as $ligne) {
            // On HYDRATE un objet Patient avec chaque ligne
            $patients[] = new Patient($ligne);
        }

        return $patients;
    }

    public function trouverParId(int $id): ?Patient
    {
        $requete = $this->pdo->prepare("SELECT * FROM patients WHERE id = :id");
        $requete->execute([':id' => $id]);

        $ligne = $requete->fetch();

        return $ligne ? new Patient($ligne) : null;
    }

    public function trouverParEmail(string $email): ?Patient
    {
        $requete = $this->pdo->prepare("SELECT * FROM patients WHERE email = :email");
        $requete->execute([':email' => $email]);

        $ligne = $requete->fetch();

        return $ligne ? new Patient($ligne) : null;
    }

    /**
     * Enregistre un nouveau patient.
     * L'objet recoit son id une fois insere en base.
     */
    public function ajouter(Patient $patient): bool
    {
        $sql = "INSERT INTO patients (nom, prenom, email, telephone, date_naissance)
                VALUES (:nom, :prenom, :email, :telephone, :date_naissance)";

        $requete = $this->pdo->prepare($sql);

        $ok = $requete->execute([
            ':nom'            => $patient->getNom(),
            ':prenom'         => $patient->getPrenom(),
            ':email'          => $patient->getEmail(),
            ':telephone'      => $patient->getTelephone(),
            ':date_naissance' => $patient->getDateNaissance()
        ]);

        if ($ok) {
            $patient->setId((int) $this->pdo->lastInsertId());
        }

        return $ok;
    }

    public function modifier(Patient $patient): bool
    {
        $sql = "UPDATE patients
                SET nom = :nom, prenom = :prenom, email = :email,
                    telephone = :telephone, date_naissance = :date_naissance
                WHERE id = :id";

        $requete = $this->pdo->prepare($sql);

        return $requete->execute([
            ':nom'            => $patient->getNom(),
            ':prenom'         => $patient->getPrenom(),
            ':email'          => $patient->getEmail(),
            ':telephone'      => $patient->getTelephone(),
            ':date_naissance' => $patient->getDateNaissance(),
            ':id'             => $patient->getId()
        ]);
    }

    public function supprimer(int $id): bool
    {
        $requete = $this->pdo->prepare("DELETE FROM patients WHERE id = :id");
        return $requete->execute([':id' => $id]);
    }

    /**
     * TROUVER OU CREER : le coeur de la prise de rendez-vous en ligne.
     *
     * Si l'email existe deja  -> on renvoie le patient existant
     * Sinon                   -> on cree la fiche puis on la renvoie
     *
     * C'est ce qui evite les fiches en double quand un patient
     * reprend rendez-vous plusieurs fois.
     */
    public function trouverOuCreer(Patient $patient): Patient
    {
        $existant = $this->trouverParEmail($patient->getEmail());

        if ($existant !== null) {
            return $existant;
        }

        $this->ajouter($patient);

        return $patient;
    }
   /* ============================================================
      A COLLER dans models/PatientManager.php, AVANT la derniere
      accolade } qui ferme la classe.
      Ces deux methodes gerent l'inscription et la connexion patient.
      ============================================================ */

    /**
     * Inscrit un patient AVEC un mot de passe (compte en ligne).
     * Le mot de passe est hache avant d'etre stocke.
     */
    public function inscrire(Patient $patient, string $motDePasseEnClair): bool
    {
        $hash = password_hash($motDePasseEnClair, PASSWORD_DEFAULT);

        $sql = "INSERT INTO patients (nom, prenom, email, mot_de_passe, telephone, date_naissance)
                VALUES (:nom, :prenom, :email, :mot_de_passe, :telephone, :date_naissance)";

        $requete = $this->pdo->prepare($sql);

        $ok = $requete->execute([
            ':nom'            => $patient->getNom(),
            ':prenom'         => $patient->getPrenom(),
            ':email'          => $patient->getEmail(),
            ':mot_de_passe'   => $hash,
            ':telephone'      => $patient->getTelephone(),
            ':date_naissance' => $patient->getDateNaissance()
        ]);

        if ($ok) {
            $patient->setId((int) $this->pdo->lastInsertId());
        }

        return $ok;
    }

    /**
     * Recupere le hash du mot de passe d'un patient par email.
     * Retourne null si le patient n'existe pas ou n'a pas de compte.
     */
    public function getHashParEmail(string $email): ?string
    {
        $requete = $this->pdo->prepare(
            "SELECT mot_de_passe FROM patients WHERE email = :email"
        );
        $requete->execute([':email' => $email]);

        $ligne = $requete->fetch();

        return ($ligne && $ligne['mot_de_passe']) ? $ligne['mot_de_passe'] : null;
    }
    
}

