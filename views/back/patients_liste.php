<?php require __DIR__ . '/../partials/menu_admin.php'; ?>

<div class="entete-section">
    <h1>Gestion des patients</h1>
    <a href="index.php?page=admin_patient_form" class="bouton-cta">+ Ajouter un patient</a>
</div>

<?php if (empty($patients)): ?>
    <p>Aucun patient enregistre.</p>
<?php else: ?>
    <table class="tableau-admin">
        <thead>
            <tr><th>Nom</th><th>Email</th><th>Telephone</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($patients as $patient): ?>
            <tr>
                <td><?= htmlspecialchars($patient->getNomComplet()) ?></td>
                <td><?= htmlspecialchars($patient->getEmail()) ?></td>
                <td><?= htmlspecialchars($patient->getTelephone() ?? '-') ?></td>
                <td class="actions">
                    <a href="index.php?page=admin_patient_form&id=<?= $patient->getId() ?>"
                       class="mini-bouton bleu">Modifier</a>
                    <a href="index.php?page=admin_patient_supprimer&id=<?= $patient->getId() ?>"
                       class="mini-bouton rouge"
                       onclick="return confirm('Supprimer ce patient et ses rendez-vous ?')">Suppr.</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../partials/fin_admin.php'; ?>
