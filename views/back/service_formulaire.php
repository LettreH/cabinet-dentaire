<?php require __DIR__ . '/../partials/menu_admin.php'; ?>

<h1><?= htmlspecialchars($titrePage) ?></h1>

<form class="formulaire" method="post"
      action="index.php?page=admin_service_form<?= $service ? '&id=' . $service->getId() : '' ?>">

    <div class="champ champ-large">
        <label for="nom">Nom du service *</label>
        <input type="text" id="nom" name="nom" required
               value="<?= htmlspecialchars($service?->getNom() ?? '') ?>">
    </div>

    <div class="champ champ-large">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3"><?= htmlspecialchars($service?->getDescription() ?? '') ?></textarea>
    </div>

    <div class="champ">
        <label for="duree">Duree (minutes) *</label>
        <input type="number" id="duree" name="duree" min="5" step="5" required
               value="<?= (int) ($service?->getDuree() ?? 30) ?>">
    </div>

    <div class="champ">
        <label for="prix">Prix (euros) *</label>
        <input type="number" id="prix" name="prix" min="0" step="0.01" required
               value="<?= htmlspecialchars((string) ($service?->getPrix() ?? 0)) ?>">
    </div>

    <button type="submit" class="bouton-cta">Enregistrer</button>
    <a href="index.php?page=admin_services" class="bouton-secondaire">Annuler</a>
</form>

<?php require __DIR__ . '/../partials/fin_admin.php'; ?>
