<?php require __DIR__ . '/../partials/menu_admin.php'; ?>

<div class="entete-section">
    <h1>Gestion des services</h1>
    <a href="index.php?page=admin_service_form" class="bouton-cta">+ Ajouter un service</a>
</div>

<?php if (empty($services)): ?>
    <p>Aucun service.</p>
<?php else: ?>
    <table class="tableau-admin">
        <thead>
            <tr><th>Nom</th><th>Duree</th><th>Prix</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><?= htmlspecialchars($service->getNom()) ?></td>
                <td><?= htmlspecialchars($service->getDureeFormatee()) ?></td>
                <td><?= $service->getPrixFormate() ?></td>
                <td class="actions">
                    <a href="index.php?page=admin_service_form&id=<?= $service->getId() ?>"
                       class="mini-bouton bleu">Modifier</a>
                    <a href="index.php?page=admin_service_supprimer&id=<?= $service->getId() ?>"
                       class="mini-bouton rouge"
                       onclick="return confirm('Supprimer ce service ?')">Suppr.</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../partials/fin_admin.php'; ?>
