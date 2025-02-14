<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Photo Management</title>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
        }
        .btn-primary {
            background-color: #0056b3;
        }
        .welcome-section {
            text-align: center;
            padding: 40px 0;
        }
        .action-buttons {
            margin-top: 20px;
        }
        nav {
            background: #333;
            padding: 15px 0;
        }
        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <div>
                <a href="<?php echo BASE_URL; ?>">Photo Management</a>
            </div>
            <div>
                <?php if(isset($_SESSION['user_id'])) : ?>
                    <a href="<?php echo BASE_URL; ?>/groups">Mes Groupes</a>
                    <span style="color: white;">Bonjour, <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?></span>
                    <a href="<?php echo BASE_URL; ?>/auth/logout">Déconnexion</a>
                <?php else : ?>
                    <a href="<?php echo BASE_URL; ?>/auth/login">Connexion</a>
                    <a href="<?php echo BASE_URL; ?>/auth/register">Inscription</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <?php if(isset($_SESSION['flash_message'])): ?>
        <div class="container">
            <div class="alert alert-<?php echo $_SESSION['flash_type'] ?? 'info'; ?>">
                <?php 
                echo $_SESSION['flash_message'];
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
                ?>
            </div>
        </div>
    <?php endif; ?>