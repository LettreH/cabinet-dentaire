<!-- Vue : actualites sante -->

<h1>Actualites</h1>
<p class="intro">Retrouvez les informations et conseils publies par notre equipe.</p>

<?php if (empty($actualites)): ?>
    <p>Aucune actualite pour le moment.</p>
<?php else: ?>
    <div class="grille">
        <?php foreach ($actualites as $actualite): ?>
            <article class="carte">
                <h2><?= htmlspecialchars($actualite->getTitre()) ?></h2>
                <p class="meta">
                    Publie le <?= $actualite->getDateFormatee() ?>
                    <?php if ($actualite->getAuteur() !== null): ?>
                        par <?= htmlspecialchars($actualite->getAuteur()) ?>
                    <?php endif; ?>
                </p>
                <p><?= nl2br(htmlspecialchars($actualite->getContenu())) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
