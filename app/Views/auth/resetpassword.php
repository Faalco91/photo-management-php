<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/main.css">
</head>

<body>
    <div class='banner-icon'>   
        <a href="/"><img src="/images/RoadPic.svg" alt="RoadPic" class="logo" width="80"></a>
    </div>
    <main class="presentation login-main-container">

        <section class="forgetpassword-form login-section">

            <div class="login-description-container">
                <article>
                    <h1>Choisissez un nouveau mot de passe !</h1>
                    <p>Saisissez un nouveau mot de passe sécurisé et retrouvez l’accès à votre compte en quelques secondes. 🔒</p>
                </article>
            </div>

            <div class="login-form-container">
                <?php if (isset($data['error'])): ?>
                    <p style="color: red;"><?php echo $data['error']; ?></p>
                <?php endif; ?>
                <form action="<?php echo BASE_URL; ?>/auth/resetpassword" method="POST">
                    <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                    <div class="reset-form-group form-group">
                        <label for="password">Nouveau mot de passe :</label>
                        <input type="password" name="password" id="password" placeholder="jonsnow@gmail.com" required>
                    </div>
                    <div class="reset-form-group form-group">
                        <label for="confirm_password">Confirmer le mot de passe :</label>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="jonsnow@gmail.com" required>
                    </div>
                    <button class="btn login-btn2 forget-submit" type="submit">Réinitialiser le mot de passe</button>
                </form>
            </div>

        </section>

        <section class="login-illustration illu3">
            <img src="/images/photo-managment-illu3.png" alt="RoadPic" class="login-bg">
        </section>
        
    </main>
</body>
