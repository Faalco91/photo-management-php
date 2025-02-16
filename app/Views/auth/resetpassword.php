<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/main.css">
</head>
<body>
    <h2>Réinitialisation du mot de passe</h2>
    <?php if (isset($data['error'])): ?>
        <p style="color: red;"><?php echo $data['error']; ?></p>
    <?php endif; ?>
    <form action="<?php echo BASE_URL; ?>/auth/resetpassword" method="POST">
        <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <div>
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
        </div>
        <div>
            <button type="submit">Réinitialiser le mot de passe</button>
        </div>
    </form>
</body>
</html>