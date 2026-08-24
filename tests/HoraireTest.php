<?php
/**
 * Tests unitaires de l'entite Horaire.
 * Fichier : tests/HoraireTest.php
 */

use PHPUnit\Framework\TestCase;

class HoraireTest extends TestCase
{
    public function testJourAfficheCommenceParUneMajuscule(): void
    {
        $horaire = new Horaire(['jour' => 'lundi']);

        $this->assertSame('Lundi', $horaire->getJourAffiche());
    }

    // ------------------------------------------------------------
    // PLAGE HORAIRE
    // ------------------------------------------------------------
    public function testPlageHoraireAffichePeuLesSecondes(): void
    {
        $horaire = new Horaire([
            'jour'            => 'mardi',
            'heure_ouverture' => '09:00:00',
            'heure_fermeture' => '18:00:00',
            'ferme'           => 0
        ]);

        $this->assertSame('09:00 - 18:00', $horaire->getPlageHoraire());
    }

    public function testPlageHoraireAfficheFermeQuandLeJourEstFerme(): void
    {
        $horaire = new Horaire(['jour' => 'dimanche', 'ferme' => 1]);

        $this->assertSame('Ferme', $horaire->getPlageHoraire());
    }

    /** Sans horaires renseignes, on considere le cabinet ferme */
    public function testPlageHoraireAfficheFermeSansHeures(): void
    {
        $horaire = new Horaire(['jour' => 'dimanche', 'ferme' => 0]);

        $this->assertSame('Ferme', $horaire->getPlageHoraire());
    }

    /** MySQL renvoie 0 ou 1, pas true/false : la conversion doit se faire */
    public function testFermeConvertitLEntierEnBooleen(): void
    {
        $ferme  = new Horaire(['ferme' => 1]);
        $ouvert = new Horaire(['ferme' => 0]);

        $this->assertTrue($ferme->estFerme());
        $this->assertFalse($ouvert->estFerme());
    }
}
