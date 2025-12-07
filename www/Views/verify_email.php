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
<?php endif; ?>