<?php
/**
 * Classe Entity (classe PARENTE de toutes les entites)
 * Fournit l'HYDRATATION : remplir un objet a partir d'un tableau.
 * Fichier : models/Entity.php
 */
abstract class Entity
{
    /**
     * Le constructeur hydrate directement l'objet si on lui
     * passe un tableau de donnees.
     * Exemple : new Patient(['nom' => 'Martin', 'prenom' => 'Julie'])
     */
    public function __construct(array $donnees = [])
    {
        if (!empty($donnees)) {
            $this->hydrater($donnees);
        }
    }

    /**
     * HYDRATER : pour chaque cle du tableau, on cherche le setter
     * correspondant et on l'appelle.
     *
     * 'date_naissance'  ->  setDateNaissance()
     * 'nom'             ->  setNom()
     *
     * Une cle sans setter est simplement ignoree : l'objet reste sain.
     */
    public function hydrater(array $donnees): void
    {
        foreach ($donnees as $cle => $valeur) {

            // date_naissance -> date naissance -> Date Naissance -> DateNaissance
            $nomMethode = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $cle)));

            if (method_exists($this, $nomMethode)) {
                $this->$nomMethode($valeur);
            }
        }
    }
}
