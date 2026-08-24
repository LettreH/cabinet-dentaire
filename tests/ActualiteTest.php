<?php
/**
 * Tests unitaires de l'entite Actualite.
 * Fichier : tests/ActualiteTest.php
 */

use PHPUnit\Framework\TestCase;

class ActualiteTest extends TestCase
{
    public function testDateFormateeAuFormatFrancais(): void
    {
        $actualite = new Actualite(['date_publication' => '2026-06-10']);

        $this->assertSame('10/06/2026', $actualite->getDateFormatee());
    }

    // ------------------------------------------------------------
    // AUTEUR (issu de la jointure avec utilisateurs)
    // ------------------------------------------------------------
    public function testAuteurAssemblePrenomEtNom(): void
    {
        $actualite = new Actualite([
            'auteur_nom'    => 'Dupont',
            'auteur_prenom' => 'Jean'
        ]);

        $this->assertSame('Jean Dupont', $actualite->getAuteur());
    }

    /** Un article dont l'auteur a quitte le cabinet (ON DELETE SET NULL) */
    public function testAuteurEstNullQuandIlNyEnAPas(): void
    {
        $actualite = new Actualite(['titre' => 'Un article sans auteur']);

        $this->assertNull($actualite->getAuteur());
    }

    // ------------------------------------------------------------
    // EXTRAIT
    // ------------------------------------------------------------
    public function testExtraitLaisseUnTexteCourtIntact(): void
    {
        $texte     = 'Un texte court.';
        $actualite = new Actualite(['contenu' => $texte]);

        $this->assertSame($texte, $actualite->getExtrait());
    }

    public function testExtraitCoupeUnTexteLongEtAjouteDesPoints(): void
    {
        $texte     = str_repeat('a', 300);
        $actualite = new Actualite(['contenu' => $texte]);

        $extrait = $actualite->getExtrait(160);

        $this->assertSame(163, strlen($extrait));       // 160 + '...'
        $this->assertStringEndsWith('...', $extrait);
    }

    public function testExtraitAccepteUneLongueurPersonnalisee(): void
    {
        $actualite = new Actualite(['contenu' => str_repeat('b', 100)]);

        $this->assertSame(53, strlen($actualite->getExtrait(50)));
    }
}
