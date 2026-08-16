<?php require __DIR__ . '/../partials/menu_admin.php'; ?>

<h1>Tableau de bord</h1>
<p class="intro">Bienvenue, <?= htmlspecialchars($nomAdmin) ?>.</p>

<div class="grille-stats">
    <article class="carte-stat">
        <span class="chiffre"><?= (int) $statuts['en attente'] ?></span>
        <span class="libelle">RDV en attente</span>
    </article>
    <article class="carte-stat">
        <span class="chiffre"><?= (int) $statuts['confirme'] ?></span>
        <span class="libelle">RDV confirmes</span>
    </article>
    <article class="carte-stat">
        <span class="chiffre"><?= (int) $nbPatients ?></span>
        <span class="libelle">Patients</span>
    </article>
    <article class="carte-stat">
        <span class="chiffre"><?= (int) $nbServices ?></span>
        <span class="libelle">Services</span>
    </article>
</div>

<?php require __DIR__ . '/../partials/fin_admin.php'; ?>
