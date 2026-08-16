<?php require __DIR__ . '/../partials/menu_admin.php'; ?>

<h1>Modifier le rendez-vous</h1>

<?php if ($rdv === null): ?>
    <p>Rendez-vous introuvable.</p>
<?php else: ?>
    <p class="intro">Patient : <strong><?= htmlspecialchars($rdv->getPatientComplet()) ?></strong></p>

    <form class="formulaire" method="post"
          action="index.php?page=admin_rdv_modifier&id=<?= $rdv->getId() ?>">

        <div class="champ">
            <label for="date">Date</label>
            <input type="date" id="date" name="date"
                   value="<?= date('Y-m-d', strtotime($rdv->getDateHeure())) ?>" required>
        </div>

        <div class="champ">
            <label for="heure">Heure</label>
            <input type="time" id="heure" name="heure"
                   value="<?= date('H:i', strtotime($rdv->getDateHeure())) ?>" required>
        </div>

        <div class="champ champ-large">
            <label for="service_id">Soin</label>
            <select id="service_id" name="service_id" required>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service->getId() ?>"
                        <?= $service->getId() === $rdv->getServiceId() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($service->getNom()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="champ champ-large">
            <label for="commentaire">Commentaire</label>
            <textarea id="commentaire" name="commentaire" rows="3"><?= htmlspecialchars($rdv->getCommentaire() ?? '') ?></textarea>
        </div>

        <button type="submit" class="bouton-cta">Enregistrer</button>
        <a href="index.php?page=admin_rdv" class="bouton-secondaire">Annuler</a>
    </form>
<?php endif; ?>

<?php require __DIR__ . '/../partials/fin_admin.php'; ?>
