<div class="auth-container">
    <h1><?= htmlspecialchars($routes['mot_de_passe_oublie']['title']) ?></h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Votre email" required>
        <button type="submit">Envoyer le lien de réinitialisation</button>
    </form>
</div>
