<!-- Vue : connexion patient -->

<h1>Connexion</h1>

<?php if (!empty($erreurs)): ?>
    <div class="message message-erreur">
        <?php foreach ($erreurs as $erreur): ?>
            <p><?= htmlspecialchars($erreur) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form class="formulaire" method="post" action="index.php?page=connexion">

    <div class="champ champ-large">
        <label for="email">Email</label>
        <input type="email" id="email" name="email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
    </div>

    <div class="champ champ-large">
        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
    </div>

    <button type="submit" class="bouton-cta">Se connecter</button>
</form>

<p class="note">
    Pas encore de compte ? <a href="index.php?page=inscription">Inscrivez-vous</a>.
</p>
