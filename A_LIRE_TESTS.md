# Tests unitaires - installation et lancement

## 1. Extraire l'archive

    unzip -o tests_phpunit.zip -d ~/cabinet-dentaire

Contenu :
  phpunit.xml            configuration de PHPUnit
  tests/bootstrap.php    chargement automatique des classes
  tests/PatientTest.php      10 tests
  tests/ServiceTest.php       7 tests
  tests/HoraireTest.php       5 tests
  tests/RendezVousTest.php    8 tests
  tests/ActualiteTest.php     6 tests
  README.md              documentation du projet (livrable final)

Total : 36 tests unitaires.

## 2. Installer PHPUnit

Le plus simple : telecharger le fichier unique (PHAR).

    cd ~/cabinet-dentaire
    wget -O phpunit.phar https://phar.phpunit.de/phpunit-11.phar
    chmod +x phpunit.phar
    php phpunit.phar --version

Si wget n'est pas disponible :

    curl -L -o phpunit.phar https://phar.phpunit.de/phpunit-11.phar

## 3. Exclure phpunit.phar du depot Git

Ajouter cette ligne au fichier .gitignore :

    phpunit.phar

## 4. Lancer les tests

    cd ~/cabinet-dentaire
    php phpunit.phar

Resultat attendu : "OK (36 tests, ... assertions)" en vert.

Pour voir le detail de chaque test :

    php phpunit.phar --testdox

Pour ne lancer qu'un fichier :

    php phpunit.phar tests/PatientTest.php

## Ce que testent ces tests

Ils portent sur les ENTITES, qui sont testables sans base de donnees :

  - Hydratation : un tableau SQL remplit-il correctement l'objet ?
    (y compris la conversion date_naissance -> setDateNaissance)
  - Validation : un email invalide declenche-t-il bien une exception ?
  - Conversion : MySQL renvoie des chaines, deviennent-elles des int / float ?
  - Formatage : 1200.00 devient-il "1 200,00 &euro;" ? 90 minutes -> "1 h 30" ?
  - Cas limites : champ vide devenant null, article sans auteur, texte long coupe

Les managers ne sont pas testes ici : ils dependent d'une vraie base de donnees,
ce qui releve des tests d'integration, plus lourds a mettre en place.

## Si un test echoue

PHPUnit indique le fichier, la ligne, la valeur attendue et la valeur obtenue.
C'est exactement le but : un test qui echoue signale qu'une modification
a casse un comportement existant.

## Le README

Le fichier README.md est un livrable demande par la sequence finale.
Relis-le et adapte si besoin (nom, adresse du depot, identifiants).
Il se place a la RACINE du projet, a cote des dossiers config, models, etc.
