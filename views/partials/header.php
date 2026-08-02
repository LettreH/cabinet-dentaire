<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cabinet dentaire du Dr. Dupont : soins dentaires, orthodontie et implantologie. Prenez rendez-vous en ligne.">
    <title><?= htmlspecialchars($titrePage ?? 'Cabinet dentaire') ?> - Cabinet Dr. Dupont</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="entete">
    <div class="conteneur entete-contenu">
        <a href="index.php?page=accueil" class="logo">Cabinet Dr. Dupont</a>

        <!-- Menu accessible sans JavaScript (case a cocher) -->
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="menu-bouton" aria-label="Ouvrir le menu">&#9776;</label>

        <nav class="navigation" aria-label="Navigation principale">
            <a href="index.php?page=accueil">Accueil</a>
            <a href="index.php?page=services">Services</a>
            <a href="index.php?page=actualites">Actualites</a>
            <a href="index.php?page=apropos">A propos</a>
            <a href="index.php?page=rendezvous" class="bouton-nav">Prendre rendez-vous</a>
        </nav>
    </div>
</header>

<main class="conteneur">
