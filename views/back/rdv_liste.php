<?php require __DIR__ . '/../partials/menu_admin.php'; ?>

<h1>Gestion des rendez-vous</h1>

<?php if (empty($rdvs)): ?>
    <p>Aucun rendez-vous pour le moment.</p>
<?php else: ?>
    <table class="tableau-admin">
        <thead>
            <tr>
                <th>Date</th><th>Patient</th><th>Soin</th>
                <th>Statut</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rdvs as $rdv): ?>
            <tr>
                <td><?= htmlspecialchars($rdv->getDateAffichee()) ?></td>
                <td><?= htmlspecialchars($rdv->getPatientComplet()) ?></td>
                <td><?= htmlspecialchars($rdv->getServiceNom()) ?></td>
                <td>
                    <span class="badge-statut <?= $rdv->getClasseStatut() ?>">
                        <?= htmlspecialchars($rdv->getStatut()) ?>
                    </span>
                </td>
                <td class="actions">
                    <a href="index.php?page=admin_rdv_confirmer&id=<?= $rdv->getId() ?>"
                       class="mini-bouton vert">Confirmer</a>
                    <a href="index.php?page=admin_rdv_modifier&id=<?= $rdv->getId() ?>"
                       class="mini-bouton bleu">Modifier</a>
                    <a href="index.php?page=admin_rdv_annuler&id=<?= $rdv->getId() ?>"
                       class="mini-bouton orange">Annuler</a>
                    <a href="index.php?page=admin_rdv_supprimer&id=<?= $rdv->getId() ?>"
                       class="mini-bouton rouge"
                       onclick="return confirm('Supprimer ce rendez-vous ?')">Suppr.</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../partials/fin_admin.php'; ?>
