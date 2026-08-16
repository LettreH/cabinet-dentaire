<?php require __DIR__ . '/../partials/menu_admin.php'; ?>

<h1><?= htmlspecialchars($titrePage) ?></h1>

<form class="formulaire" method="post"
      action="index.php?page=admin_actualite_form<?= $actualite ? '&id=' . $actualite->getId() : '' ?>">

    <div class="champ champ-large">
        <label for="titre">Titre *</label>
        <input type="text" id="titre" name="titre" required
               value="<?= htmlspecialchars($actualite?->getTitre() ?? '') ?>">
    </div>

    <div class="champ champ-large">
        <label for="contenu">Contenu *</label>
        <textarea id="contenu" name="contenu" rows="6" required><?= htmlspecialchars($actualite?->getContenu() ?? '') ?></textarea>
    </div>

    <div class="champ">
        <label for="image">Image (nom du fichier)</label>
        <input type="text" id="image" name="image" placeholder="ex : brossage.jpg"
               value="<?= htmlspecialchars($actualite?->getImage() ?? '') ?>">
    </div>

    <div class="champ">
        <label for="date_publication">Date de publication</label>
        <input type="date" id="date_publication" name="date_publication"
               value="<?= htmlspecialchars($actualite?->getDatePublication() ?? date('Y-m-d')) ?>">
    </div>

    <button type="submit" class="bouton-cta">Enregistrer</button>
    <a href="index.php?page=admin_actualites" class="bouton-secondaire">Annuler</a>
</form>

<?php require __DIR__ . '/../partials/fin_admin.php'; ?>
