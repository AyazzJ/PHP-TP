<div class="auth-container">
    <h2>Réinitialiser le mot de passe</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" action="/phptest/password-reset">
        <div class="form-group">
            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email" required>
        </div>

        <button type="submit" class="btn btn-primary">Réinitialiser le mot de passe</button>
    </form>

    <p class="auth-links">
        <a href="/phptest/login">Retour à la connexion</a>
    </p>
</div>