<!-- Vue : tableau de bord admin (page protegee) -->

<h1>Tableau de bord</h1>
<p class="intro">Bienvenue, <?= htmlspecialchars($nomAdmin) ?>.</p>

<div class="grille">
    <article class="carte">
        <h2><?= (int) $nbPatients ?></h2>
        <p>Patients enregistres</p>
    </article>
    <article class="carte">
        <h2><?= (int) $nbServices ?></h2>
        <p>Services proposes</p>
    </article>
</div>

<p class="note" style="margin-top:24px;">
    <a href="index.php?page=deconnexion" class="bouton-secondaire">Se deconnecter</a>
</p>
