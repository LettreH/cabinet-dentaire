<!-- Vue : formulaire de prise de rendez-vous -->

<h1>Prendre rendez-vous</h1>

<?php if ($succes): ?>

    <div class="message message-succes">
        <p><strong>Votre demande a bien ete enregistree.</strong></p>
        <p>Le cabinet vous confirmera votre creneau sous 24 heures.</p>
    </div>
    <a href="index.php?page=accueil" class="bouton-cta">Retour a l'accueil</a>

<?php else: ?>

    <p class="intro">
        Remplissez ce formulaire, nous confirmons votre creneau sous 24 heures.
    </p>

    <?php if (!empty($erreurs)): ?>
        <div class="message message-erreur">
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="formulaire" method="post" action="index.php?page=rendezvous">

        <div class="champ">
            <label for="prenom">Prenom *</label>
            <input type="text" id="prenom" name="prenom" required
                   value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
        </div>

        <div class="champ">
            <label for="nom">Nom *</label>
            <input type="text" id="nom" name="nom" required
                   value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
        </div>

        <div class="champ">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <small class="note">Si vous etes deja patient, utilisez le meme email.</small>
        </div>

        <div class="champ">
            <label for="telephone">Telephone</label>
            <input type="tel" id="telephone" name="telephone"
                   value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
        </div>

        <div class="champ champ-large">
            <label for="service_id">Type de consultation *</label>
            <select id="service_id" name="service_id" required>
                <option value="">-- Choisissez un soin --</option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= (int) $service->getId() ?>"
                        <?= (($_POST['service_id'] ?? '') == $service->getId()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($service->getNom()) ?>
                        (<?= $service->getDureeFormatee() ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="champ">
            <label for="date_rdv">Date souhaitee *</label>
            <input type="date" id="date_rdv" name="date_rdv" required
                   min="<?= date('Y-m-d') ?>"
                   value="<?= htmlspecialchars($_POST['date_rdv'] ?? '') ?>">
        </div>

        <div class="champ">
            <label for="heure_rdv">Heure souhaitee *</label>
            <input type="time" id="heure_rdv" name="heure_rdv" required
                   value="<?= htmlspecialchars($_POST['heure_rdv'] ?? '') ?>">
        </div>

        <div class="champ champ-large">
            <label for="commentaire">Commentaire</label>
            <textarea id="commentaire" name="commentaire" rows="4"><?= htmlspecialchars($_POST['commentaire'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="bouton-cta">Envoyer ma demande</button>
    </form>

<?php endif; ?>
