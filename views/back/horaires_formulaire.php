<?php require __DIR__ . '/../partials/menu_admin.php'; ?>

<h1>Gestion des horaires</h1>
<p class="intro">Cochez "Ferme" pour un jour sans ouverture.</p>

<form class="formulaire-horaires" method="post" action="index.php?page=admin_horaires">
    <table class="tableau-admin">
        <thead>
            <tr><th>Jour</th><th>Ouverture</th><th>Fermeture</th><th>Ferme</th></tr>
        </thead>
        <tbody>
        <?php foreach ($horaires as $horaire): ?>
            <?php $id = $horaire->getId(); ?>
            <tr>
                <td><strong><?= htmlspecialchars($horaire->getJourAffiche()) ?></strong></td>
                <td>
                    <input type="time" name="ouverture[<?= $id ?>]"
                           value="<?= $horaire->getHeureOuverture() ? substr($horaire->getHeureOuverture(),0,5) : '' ?>">
                </td>
                <td>
                    <input type="time" name="fermeture[<?= $id ?>]"
                           value="<?= $horaire->getHeureFermeture() ? substr($horaire->getHeureFermeture(),0,5) : '' ?>">
                </td>
                <td style="text-align:center;">
                    <input type="checkbox" name="ferme[<?= $id ?>]"
                           <?= $horaire->estFerme() ? 'checked' : '' ?>>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <button type="submit" class="bouton-cta" style="margin-top:20px;">Enregistrer les horaires</button>
</form>

<?php require __DIR__ . '/../partials/fin_admin.php'; ?>
