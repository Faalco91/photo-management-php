<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : "RoadPic - Capturez l’Aventure, Partagez l’Instant" ?></title>
    <link rel="stylesheet" href="/css/main.css">
</head>

<body class="">
    <div class='banner-icon'>
        <a href="/"><img src="/images/RoadPic.svg" alt="RoadPic" class="logo" width="80"></a>
    </div>
    <main class="presentation login-main-container">
        <section class="login-section">
            <div class="login-description-container">

                <article>
                    <h1>Hello !</h1>
                    <p>Reconnectez-vous et retrouvez instantanément tous vos souvenirs de roadtrip. </p>
                </article>
            </div>
            <div class="login-form-container">
                <?php if(isset($_SESSION['success_msg'])) : ?>
                    <div class="alert alert-success">
                        <?php 
                            echo $_SESSION['success_msg']; 
                            unset($_SESSION['success_msg']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo BASE_URL; ?>/auth/login" method="post">
                    <div class="login-form-group form-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="jonsnow@gmail.com"
                               value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                        <span class="error"><?php echo isset($email_err) ? $email_err : ''; ?></span>
                    </div>
                    <div class="login-form-group form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="*******"> 
                        <span class="error"><?php echo isset($password_err) ? $password_err : ''; ?></span>
                        <p><a href="/auth/forgetpassword">Mot de passe oublié ?</a></p>
                    </div>
                    <button type="submit" class="btn login-btn2">Se connecter</button>
                </form>

                <section class="or-register-section">
                    <div class="line-container">
                        <div class="line"></div>
                            <span class="or-text">ou</span>
                        <div class="line"></div>
                    </div>
                    <p class="create-account"><a href="/auth/register">Créer un compte</a></p>
                </section>
            </div>
        </section>

        <section class="login-illustration">
            <img src="/images/photo-managment-illu.png" alt="RoadPic" class="login-bg">
        </section>
    </main>
</body>