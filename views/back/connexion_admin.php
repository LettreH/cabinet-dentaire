<!-- Vue : connexion equipe (back office) -->

<h1>Espace professionnel</h1>
<p class="intro">Reserve au Dr. Dupont et a son equipe.</p>

<?php if (!empty($erreurs)): ?>
    <div class="message message-erreur">
        <?php foreach ($erreurs as $erreur): ?>
            <p><?= htmlspecialchars($erreur) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form class="formulaire" method="post" action="index.php?page=admin_connexion">

    <div class="champ champ-large">
        <label for="email">Email professionnel</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div class="champ champ-large">
        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
    </div>

    <button type="submit" class="bouton-cta">Acceder au back office</button>
</form>
