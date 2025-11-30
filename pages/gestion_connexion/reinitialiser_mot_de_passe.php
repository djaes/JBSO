<div class="auth-container">
    <h1><?= htmlspecialchars($routes['reinitialiser_mot_de_passe']['title']) ?></h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
        <button type="submit">Réinitialiser</button>
    </form>
</div>
