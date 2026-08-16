<?php require __DIR__ . '/../partials/menu_admin.php'; ?>

<div class="entete-section">
    <h1>Gestion des actualites</h1>
    <a href="index.php?page=admin_actualite_form" class="bouton-cta">+ Ajouter une actualite</a>
</div>

<?php if (empty($actualites)): ?>
    <p>Aucune actualite.</p>
<?php else: ?>
    <table class="tableau-admin">
        <thead>
            <tr><th>Titre</th><th>Date</th><th>Auteur</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($actualites as $actualite): ?>
            <tr>
                <td><?= htmlspecialchars($actualite->getTitre()) ?></td>
                <td><?= htmlspecialchars($actualite->getDateFormatee()) ?></td>
                <td><?= htmlspecialchars($actualite->getAuteur() ?? '-') ?></td>
                <td class="actions">
                    <a href="index.php?page=admin_actualite_form&id=<?= $actualite->getId() ?>"
                       class="mini-bouton bleu">Modifier</a>
                    <a href="index.php?page=admin_actualite_supprimer&id=<?= $actualite->getId() ?>"
                       class="mini-bouton rouge"
                       onclick="return confirm('Supprimer cette actualite ?')">Suppr.</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../partials/fin_admin.php'; ?>
