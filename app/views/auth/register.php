<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : "RoadPic - Capturez l’Aventure, Partagez l’Instant" ?></title>
    <link rel="stylesheet" href="/css/main.css">
</head>

<body class="custom-register-bg">
    <div class='banner-icon'>
        <a href="/"><img src="/images/RoadPic2.svg" alt="RoadPic" class="logo" width="90"></a>
    </div>

    <section class="presentation register-section"> 
        <div class="register-description-container">
            <div class="logo-container">
                <img src="/images/RoadPic2.svg" alt="RoadPic" class="logo" width="200">
            </div>
            <article>
                <h1>Rejoignez la communauté des aventuriers !</h1>
                <p>Créez un compte en quelques secondes et commencez à capturer, organiser et revivre chaque instant mémorable </p>
                <div class="benefits_container">
                    <ul class="benefits_list">
                        <li class="benefits_item">
                            <span class="benefits_icon">📍</span>
                            <p class="benefits_text">Cartographie des souvenirs</p>
                        </li>
                        <li class="benefits_item">
                            <span class="benefits_icon">🔒</span>
                            <p class="benefits_text">Stockage sécurisé</p>
                        </li>
                        <li class="benefits_item">
                            <span class="benefits_icon">📸</span>
                            <p class="benefits_text">Qualité HD préservée</p>
                        </li>
                        <li class="benefits_item">
                            <span class="benefits_icon">🚀</span>
                            <p class="benefits_text">Ultra rapide & intuitif</p>
                        </li>
                    </ul>
                </div>
            </article>
        </div>
        <div class="register-form-container">
            <h2>S'inscrire</h2>
            <div class="login-link">
                <p>Vous avez déjà un compte ?</p>
                <a href="/auth/login">Se connecter</a>
            </div>
            <form action="auth/register" method="post">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username" placeholder="JonSnow" class="form-control" 
                           value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                    <span class="error"><?php echo isset($username_err) ? $username_err : ''; ?></span>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="jonsnow@gmail.com" class="form-control"
                           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                    <span class="error"><?php echo isset($email_err) ? $email_err : ''; ?></span>
                </div>

                <div class="form-password-container">
                    <div class="form-group password1">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" placeholder="*******" class="form-control">
                    <span class="error"><?php echo isset($password_err) ? $password_err : ''; ?></span>
                    </div>
                    <div class="form-group password2">
                    <label for="confirm_password">Confirmez le mot de passe</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="*******" class="form-control">
                    <span class="error"><?php echo isset($confirm_password_err) ? $confirm_password_err : ''; ?></span>
                    </div>
                </div>

                <button type="submit" class="btn register-btn2">Créer un compte</button>
            </form>
        </div>
    </section>
</body>