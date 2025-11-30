<div class="auth-container">
    <h1><?= htmlspecialchars($routes['connexion']['title']) ?></h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <p class="success"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username_or_email" placeholder="Nom d'utilisateur ou email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="connexion">Se connecter</button>
    </form>

    <p>
        <a href="index.php?page=inscription">S'inscrire</a> |
        <a href="index.php?page=mot_de_passe_oublie">Mot de passe oublié ?</a>
    </p>
</div>
