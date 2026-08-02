<!-- Vue : formulaire d'inscription patient -->

<h1>Creer mon compte</h1>

<?php if ($succes): ?>
    <div class="message message-succes">
        Votre compte a bien ete cree ! Vous pouvez maintenant
        <a href="index.php?page=connexion">vous connecter</a>.
    </div>
<?php else: ?>

    <?php if (!empty($erreurs)): ?>
        <div class="message message-erreur">
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="formulaire" method="post" action="index.php?page=inscription">

        <div class="champ">
            <label for="prenom">Prenom *</label>
            <input type="text" id="prenom" name="prenom"
                   value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
        </div>

        <div class="champ">
            <label for="nom">Nom *</label>
            <input type="text" id="nom" name="nom"
                   value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
        </div>

        <div class="champ champ-large">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>

        <div class="champ champ-large">
            <label for="telephone">Telephone</label>
            <input type="tel" id="telephone" name="telephone"
                   value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
        </div>

        <div class="champ">
            <label for="mot_de_passe">Mot de passe *</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            <small class="note">Au moins 8 caracteres.</small>
        </div>

        <div class="champ">
            <label for="mot_de_passe_confirmation">Confirmer *</label>
            <input type="password" id="mot_de_passe_confirmation"
                   name="mot_de_passe_confirmation" required>
        </div>

        <button type="submit" class="bouton-cta">Creer mon compte</button>
    </form>

    <p class="note">
        Deja inscrit ? <a href="index.php?page=connexion">Connectez-vous</a>.
    </p>

<?php endif; ?>
