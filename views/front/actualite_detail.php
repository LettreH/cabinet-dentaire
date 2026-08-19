<!-- Vue : un article d'actualite en detail -->

<article class="article-detail">

    <h1><?= htmlspecialchars($actualite->getTitre()) ?></h1>

    <p class="meta">
        Publie le <?= $actualite->getDateFormatee() ?>
        <?php if ($actualite->getAuteur() !== null): ?>
            par <?= htmlspecialchars($actualite->getAuteur()) ?>
        <?php endif; ?>
    </p>

    <?php if ($actualite->getImage() !== null): ?>
        <img src="images/<?= htmlspecialchars($actualite->getImage()) ?>"
             alt="<?= htmlspecialchars($actualite->getTitre()) ?>"
             class="article-image">
    <?php endif; ?>

    <div class="article-contenu">
        <?= nl2br(htmlspecialchars($actualite->getContenu())) ?>
    </div>

    <a href="index.php?page=actualites" class="bouton-secondaire">
        Retour aux actualites
    </a>

</article>
