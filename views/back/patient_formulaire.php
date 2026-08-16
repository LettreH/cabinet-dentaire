<?php require __DIR__ . '/../partials/menu_admin.php'; ?>

<h1><?= htmlspecialchars($titrePage) ?></h1>

<?php if (!empty($erreurs)): ?>
    <div class="message message-erreur">
        <?php foreach ($erreurs as $e): ?><p><?= htmlspecialchars($e) ?></p><?php endforeach; ?>
    </div>
<?php endif; ?>

<form class="formulaire" method="post"
      action="index.php?page=admin_patient_form<?= $patient ? '&id=' . $patient->getId() : '' ?>">

    <div class="champ">
        <label for="prenom">Prenom *</label>
        <input type="text" id="prenom" name="prenom" required
               value="<?= htmlspecialchars($patient?->getPrenom() ?? '') ?>">
    </div>

    <div class="champ">
        <label for="nom">Nom *</label>
        <input type="text" id="nom" name="nom" required
               value="<?= htmlspecialchars($patient?->getNom() ?? '') ?>">
    </div>

    <div class="champ">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" required
               value="<?= htmlspecialchars($patient?->getEmail() ?? '') ?>">
    </div>

    <div class="champ">
        <label for="telephone">Telephone</label>
        <input type="tel" id="telephone" name="telephone"
               value="<?= htmlspecialchars($patient?->getTelephone() ?? '') ?>">
    </div>

    <div class="champ">
        <label for="date_naissance">Date de naissance</label>
        <input type="date" id="date_naissance" name="date_naissance"
               value="<?= htmlspecialchars($patient?->getDateNaissance() ?? '') ?>">
    </div>

    <button type="submit" class="bouton-cta">Enregistrer</button>
    <a href="index.php?page=admin_patients" class="bouton-secondaire">Annuler</a>
</form>

<?php require __DIR__ . '/../partials/fin_admin.php'; ?>
