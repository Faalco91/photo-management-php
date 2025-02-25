<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : "RoadPic - Capturez l’Aventure, Partagez l’Instant" ?></title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-left">
                <a href="/" class="logo">
                    <img src="/images/RoadPic.svg" alt="Logo" width="80">
                </a>
            </div>
            <ul class="navbar-center">
                <li><a href="/">Accueil</a></li>
                <li><a href="#">À propos</a></li>
                <li><a href="#">Contacts</a></li>
            </ul>
            <div class="navbar-right">
                <a href="/auth/login" class="btn login-btn">Connexion</a>
                <a href="/auth/register" class="btn register-btn">Inscription</a>
            </div>
        </nav>
    </header>
</body>
</html>