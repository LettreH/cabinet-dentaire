<!-- Vue : liste detaillee des services -->

<h1>Nos services</h1>
<p class="intro">
    Le cabinet propose une prise en charge complete, du controle annuel
    aux traitements les plus techniques.
</p>

<div class="grille">
    <?php foreach ($services as $service): ?>
        <article class="carte">
            <h2><?= htmlspecialchars($service->getNom()) ?></h2>
            <p><?= htmlspecialchars($service->getDescription()) ?></p>
            <p class="meta">
                Duree : <?= $service->getDureeFormatee() ?><br>
                Tarif : <?= $service->getPrixFormate() ?>
            </p>
            <a href="index.php?page=rendezvous" class="bouton-secondaire">Reserver ce soin</a>
        </article>
    <?php endforeach; ?>
</div>
