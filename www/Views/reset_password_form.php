<?php
if ($error): ?>
    <div style="color: red; padding: 10px; margin-bottom: 20px;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php
if ($success): ?>
    <div style="color: green; padding: 10px; margin-bottom: 20px;">
        <?php echo htmlspecialchars($success); ?>
    </div>
    <p><a href="/phptest/login">Aller à la connexion</a></p>
<?php else: ?>
    <form method="POST">
        <div>
            <label for="password">Nouveau mot de passe:</label>
            <input type="password" id="password" name="password" required minlength="6">
        </div>
        <div>
            <label for="confirm_password">Confirmer le mot de passe:</label>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
        </div>
        <button type="submit">Réinitialiser le mot de passe</button>
    </form>
<?php endif; ?>