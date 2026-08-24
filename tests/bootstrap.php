<?php
/**
 * Bootstrap des tests.
 * Charge automatiquement les classes du projet, comme le fait
 * public/index.php pour le site.
 * Fichier : tests/bootstrap.php
 */
spl_autoload_register(function (string $nomClasse): void {
    $dossiers = [
        __DIR__ . '/../config/',
        __DIR__ . '/../core/',
        __DIR__ . '/../models/',
        __DIR__ . '/../controllers/',
    ];
    foreach ($dossiers as $dossier) {
        $fichier = $dossier . $nomClasse . '.php';
        if (file_exists($fichier)) {
            require_once $fichier;
            return;
        }
    }
});
