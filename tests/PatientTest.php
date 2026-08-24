<?php
/**
 * Tests unitaires de l'entite Patient.
 * Fichier : tests/PatientTest.php
 */

use PHPUnit\Framework\TestCase;

class PatientTest extends TestCase
{
    // ------------------------------------------------------------
    // HYDRATATION : un tableau doit remplir l'objet
    // ------------------------------------------------------------
    public function testHydratationRemplitLesProprietes(): void
    {
        $patient = new Patient([
            'id'             => 5,
            'nom'            => 'Martin',
            'prenom'         => 'Julie',
            'email'          => 'julie.martin@email.com',
            'telephone'      => '0612345678',
            'date_naissance' => '1990-04-12'
        ]);

        $this->assertSame(5, $patient->getId());
        $this->assertSame('Martin', $patient->getNom());
        $this->assertSame('Julie', $patient->getPrenom());
        $this->assertSame('julie.martin@email.com', $patient->getEmail());
        $this->assertSame('0612345678', $patient->getTelephone());
    }

    /** La cle date_naissance doit appeler setDateNaissance() */
    public function testHydratationConvertitLesNomsAvecUnderscore(): void
    {
        $patient = new Patient(['date_naissance' => '1985-11-03']);

        $this->assertSame('1985-11-03', $patient->getDateNaissance());
    }

    /** Une cle inconnue ne doit pas faire planter l'hydratation */
    public function testHydratationIgnoreLesClesInconnues(): void
    {
        $patient = new Patient(['nom' => 'Dubois', 'colonne_qui_nexiste_pas' => 'valeur']);

        $this->assertSame('Dubois', $patient->getNom());
    }

    // ------------------------------------------------------------
    // VALIDATION dans les setters
    // ------------------------------------------------------------
    public function testEmailInvalideDeclencheUneException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $patient = new Patient();
        $patient->setEmail('adresse-sans-arobase');
    }

    public function testNomVideDeclencheUneException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $patient = new Patient();
        $patient->setNom('   ');
    }

    public function testLesEspacesSontSupprimes(): void
    {
        $patient = new Patient();
        $patient->setNom('  Martin  ');

        $this->assertSame('Martin', $patient->getNom());
    }

    /** Un telephone vide doit devenir null, pas une chaine vide */
    public function testTelephoneVideDevientNull(): void
    {
        $patient = new Patient();
        $patient->setTelephone('');

        $this->assertNull($patient->getTelephone());
    }

    // ------------------------------------------------------------
    // METHODES METIER
    // ------------------------------------------------------------
    public function testNomCompletMetLeNomEnMajuscules(): void
    {
        $patient = new Patient(['nom' => 'Martin', 'prenom' => 'Julie']);

        $this->assertSame('Julie MARTIN', $patient->getNomComplet());
    }

    public function testAgeEstNullSansDateDeNaissance(): void
    {
        $patient = new Patient(['nom' => 'Petit', 'prenom' => 'Sophie']);

        $this->assertNull($patient->getAge());
    }

    public function testAgeEstCalculeDepuisLaDateDeNaissance(): void
    {
        // On construit une date pour un age connu : 30 ans
        $naissance = (new DateTime())->modify('-30 years')->format('Y-m-d');

        $patient = new Patient(['date_naissance' => $naissance]);

        $this->assertSame(30, $patient->getAge());
    }
}
