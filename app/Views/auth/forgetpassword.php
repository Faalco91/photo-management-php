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
    <?php if (isset($_SESSION['success_msg'])): ?>
        <p style="color: green;"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></p>
    <?php endif; ?>
    <?php if (isset($data['error'])): ?>
        <p style="color: red;"><?php echo $data['error']; ?></p>
    <?php endif; ?>
    <form action="<?php echo BASE_URL; ?>/auth/forgetpassword" method="POST">
        <div>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <button type="submit">Envoyer</button>
        </div>
    </form>
</body>
</html>