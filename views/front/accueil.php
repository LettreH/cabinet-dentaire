<!-- Vue : page d'accueil -->
<!-- $services et $horaires sont des tableaux d'OBJETS -->

<section class="banniere">
    <div class="banniere-texte">
        <h1>Votre sourire, notre priorite</h1>
        <p>
            Le cabinet du Dr. Dupont vous accueille a Toulouse dans un espace moderne
            et chaleureux. Soins courants, orthodontie et implantologie : notre equipe
            vous accompagne a chaque etape.
        </p>
        <a href="index.php?page=rendezvous" class="bouton-cta">Prendre rendez-vous</a>
    </div>
    <div class="banniere-image" role="img" aria-label="Photo du cabinet dentaire">
        <span>Photo du cabinet</span>
    </div>
</section>

<section class="section">
    <h2>Nos services</h2>
    <div class="grille">
        <?php foreach ($services as $service): ?>
            <article class="carte">
                <h3><?= htmlspecialchars($service->getNom()) ?></h3>
                <p><?= htmlspecialchars($service->getDescription()) ?></p>
                <p class="meta">
                    <?= $service->getDureeFormatee() ?> &middot;
                    <?= $service->getPrixFormate() ?>
                </p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section">
    <h2>Horaires d'ouverture</h2>
    <table class="tableau">
        <caption class="sr-only">Horaires d'ouverture du cabinet</caption>
        <tbody>
        <?php foreach ($horaires as $horaire): ?>
            <tr>
                <th scope="row"><?= htmlspecialchars($horaire->getJourAffiche()) ?></th>
                <td>
                    <?php if ($horaire->estFerme()): ?>
                        <span class="ferme">Ferme</span>
                    <?php else: ?>
                        <?= htmlspecialchars($horaire->getPlageHoraire()) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
