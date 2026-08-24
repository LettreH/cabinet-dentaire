<?php
/**
 * Tests unitaires de l'entite RendezVous.
 * Fichier : tests/RendezVousTest.php
 */

use PHPUnit\Framework\TestCase;

class RendezVousTest extends TestCase
{
    public function testHydratationRemplitLesProprietes(): void
    {
        $rdv = new RendezVous([
            'id'          => 7,
            'date_heure'  => '2026-08-05 09:30:00',
            'statut'      => 'confirme',
            'patient_id'  => 1,
            'service_id'  => 2
        ]);

        $this->assertSame(7, $rdv->getId());
        $this->assertSame('confirme', $rdv->getStatut());
        $this->assertSame(1, $rdv->getPatientId());
        $this->assertSame(2, $rdv->getServiceId());
    }

    // ------------------------------------------------------------
    // AFFICHAGE DE LA DATE
    // ------------------------------------------------------------
    public function testDateAfficheeAuFormatFrancais(): void
    {
        $rdv = new RendezVous(['date_heure' => '2026-08-05 09:30:00']);

        $this->assertSame('05/08/2026 a 09:30', $rdv->getDateAffichee());
    }

    public function testDateAfficheeEstVideSansDate(): void
    {
        $rdv = new RendezVous();

        $this->assertSame('', $rdv->getDateAffichee());
    }

    // ------------------------------------------------------------
    // CLASSE CSS SELON LE STATUT
    // ------------------------------------------------------------
    public function testClasseCssPourUnRendezVousConfirme(): void
    {
        $rdv = new RendezVous(['statut' => 'confirme']);

        $this->assertSame('statut-confirme', $rdv->getClasseStatut());
    }

    public function testClasseCssPourUnRendezVousAnnule(): void
    {
        $rdv = new RendezVous(['statut' => 'annule']);

        $this->assertSame('statut-annule', $rdv->getClasseStatut());
    }

    /** Tout autre statut retombe sur "en attente" */
    public function testClasseCssParDefautEstEnAttente(): void
    {
        $rdv = new RendezVous(['statut' => 'en attente']);

        $this->assertSame('statut-attente', $rdv->getClasseStatut());
    }

    // ------------------------------------------------------------
    // DONNEES VENANT DE LA JOINTURE
    // ------------------------------------------------------------
    public function testPatientCompletAssemblePrenomEtNom(): void
    {
        $rdv = new RendezVous([
            'patient_nom'    => 'Dubois',
            'patient_prenom' => 'Thomas'
        ]);

        $this->assertSame('Thomas Dubois', $rdv->getPatientComplet());
    }

    /** Un commentaire vide doit devenir null */
    public function testCommentaireVideDevientNull(): void
    {
        $rdv = new RendezVous(['commentaire' => '']);

        $this->assertNull($rdv->getCommentaire());
    }
}
