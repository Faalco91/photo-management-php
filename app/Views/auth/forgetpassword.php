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
                    <h1>Mot de passe oublié ?</h1>
                    <p>Entrez votre e-mail et recevez un lien pour réinitialiser votre mot de passe en quelques instants. 🚀 </p>
                </article>
            </div>
            <div class="login-form-container">
                <?php if (isset($_SESSION['success_msg'])): ?>
                    <p style="color: green;"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></p>
                <?php endif; ?>
                <?php if (isset($data['error'])): ?>
                    <p style="color: red;"><?php echo $data['error']; ?></p>
                <?php endif; ?>
                <form action="<?php echo BASE_URL; ?>/auth/forgetpassword" method="POST">
                    <div class="login-form-group form-group">
                        <input type="email" name="email" id="email" placeholder="jonsnow@gmail.com" required>
                    </div>
                    <button class="btn login-btn2 forget-submit" type="submit">Envoyer</button>
                </form>
            </div>

        </section>

        <section class="login-illustration illu2">
            <img src="/images/photo-managment-illu2.png" alt="RoadPic" class="login-bg">
        </section>

    </main>
</body>