<?php
/**
 * Tests unitaires de l'entite Service.
 * Fichier : tests/ServiceTest.php
 */

use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public function testHydratationRemplitLesProprietes(): void
    {
        $service = new Service([
            'id'          => 3,
            'nom'         => 'Detartrage',
            'description' => 'Nettoyage professionnel.',
            'duree'       => 45,
            'prix'        => 60.00
        ]);

        $this->assertSame(3, $service->getId());
        $this->assertSame('Detartrage', $service->getNom());
        $this->assertSame(45, $service->getDuree());
        $this->assertSame(60.00, $service->getPrix());
    }

    /** MySQL renvoie les nombres sous forme de chaines : ils doivent etre convertis */
    public function testLesChainesSontConvertiesEnNombres(): void
    {
        $service = new Service(['duree' => '60', 'prix' => '1200.00']);

        $this->assertIsInt($service->getDuree());
        $this->assertIsFloat($service->getPrix());
    }

    // ------------------------------------------------------------
    // FORMATAGE DU PRIX
    // ------------------------------------------------------------
    public function testPrixFormateAvecSeparateurDeMilliers(): void
    {
        $service = new Service(['prix' => 1200.00]);

        $this->assertSame('1 200,00 &euro;', $service->getPrixFormate());
    }

    public function testPrixFormateAvecUneVirguleDecimale(): void
    {
        $service = new Service(['prix' => 60.5]);

        $this->assertSame('60,50 &euro;', $service->getPrixFormate());
    }

    // ------------------------------------------------------------
    // FORMATAGE DE LA DUREE
    // ------------------------------------------------------------
    public function testDureeInferieureAUneHeureResteEnMinutes(): void
    {
        $service = new Service(['duree' => 30]);

        $this->assertSame('30 min', $service->getDureeFormatee());
    }

    public function testDureeExacteEnHeures(): void
    {
        $service = new Service(['duree' => 120]);

        $this->assertSame('2 h', $service->getDureeFormatee());
    }

    public function testDureeAvecHeuresEtMinutes(): void
    {
        $service = new Service(['duree' => 90]);

        $this->assertSame('1 h 30', $service->getDureeFormatee());
    }
}
