<!-- Vue : formulaire de prise de rendez-vous -->

<h1>Prendre rendez-vous</h1>
<p class="intro">
    Remplissez ce formulaire, nous confirmons votre creneau sous 24 heures.
</p>

<form class="formulaire" method="post" action="index.php?page=rendezvous">

    <div class="champ">
        <label for="prenom">Prenom *</label>
        <input type="text" id="prenom" name="prenom" required>
    </div>

    <div class="champ">
        <label for="nom">Nom *</label>
        <input type="text" id="nom" name="nom" required>
    </div>

    <div class="champ">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" required>
        <small class="note">Si vous etes deja patient, utilisez le meme email.</small>
    </div>

    <div class="champ">
        <label for="telephone">Telephone</label>
        <input type="tel" id="telephone" name="telephone">
    </div>

    <div class="champ">
        <label for="service_id">Type de consultation *</label>
        <select id="service_id" name="service_id" required>
            <option value="">-- Choisissez un soin --</option>
            <?php foreach ($services as $service): ?>
                <option value="<?= (int) $service->getId() ?>">
                    <?= htmlspecialchars($service->getNom()) ?>
                    (<?= $service->getDureeFormatee() ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="champ">
        <label for="date_rdv">Date souhaitee *</label>
        <input type="date" id="date_rdv" name="date_rdv" required>
    </div>

    <div class="champ">
        <label for="heure_rdv">Heure souhaitee *</label>
        <input type="time" id="heure_rdv" name="heure_rdv" required>
    </div>

    <div class="champ champ-large">
        <label for="commentaire">Commentaire</label>
        <textarea id="commentaire" name="commentaire" rows="4"></textarea>
    </div>

    <button type="submit" class="bouton-cta">Envoyer ma demande</button>
</form>

<p class="note">
    Le traitement du formulaire sera mis en place dans la sequence suivante.
</p>
