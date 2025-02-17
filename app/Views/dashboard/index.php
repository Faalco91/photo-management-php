<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - RoadPic</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <nav class="dashboard-nav">
        <div class="nav-content">
            <div class="nav-left">
                <img src="/images/RoadPic.svg" alt="RoadPic" class="logo" width="80">
            </div>
            <div class="nav-right">
                <span class="username"><?php echo htmlspecialchars($data['username']); ?></span>
                <a href="<?php echo BASE_URL; ?>/auth/logout" class="btn btn-logout">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container dashboard-container">
        <div class="dashboard-header">
            <h1>Bienvenue sur RoadPic</h1>
            <p class="subtitle">Partagez vos souvenirs de voyage avec vos groupes</p>
        </div>

        <div class="dashboard-actions">
            <a href="<?php echo BASE_URL; ?>/groups/create" class="action-card">
                <div class="action-icon">➕</div>
                <h3>Créer un groupe</h3>
                <p>Créez un nouveau groupe pour partager vos photos</p>
            </a>
        </div>

        <?php if(empty($data['groups'])) : ?>
            <div class="alert alert-info">
                <p>Vous n'avez encore aucun groupe. Créez-en un pour commencer à partager vos photos !</p>
            </div>
        <?php else : ?>
            <section class="my-groups">
                <h2>Mes Groupes</h2>
                <div class="groups-grid">
                    <?php foreach($data['groups'] as $group) : ?>
                        <div class="group-card">
                            <h3><?php echo htmlspecialchars($group->name); ?></h3>
                            <p class="description"><?php echo htmlspecialchars($group->description); ?></p>
                            <div class="group-actions">
                                <span class="role"><?php echo ucfirst($group->role); ?></span>
                                <div class="action-buttons">
                                    <a href="<?php echo BASE_URL; ?>/photos/upload?group=<?php echo $group->id; ?>" 
                                       class="btn btn-primary">Ajouter une photo</a>
                                    <a href="<?php echo BASE_URL; ?>/groups/show/<?php echo $group->id; ?>" 
                                       class="btn btn-secondary">Voir le groupe</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>

    <style>
    .dashboard-nav {
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 1rem;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
    }

    .nav-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .username {
        font-weight: 500;
    }

    .btn-logout {
        background: #dc3545;
        color: white;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 80px auto 0;
        padding: 2rem;
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .subtitle {
        color: #666;
        font-size: 1.1rem;
    }

    .dashboard-actions {
        display: flex;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .action-card {
        background: white;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        text-decoration: none;
        color: inherit;
        flex: 1;
        max-width: 300px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .action-card:hover {
        transform: translateY(-5px);
    }

    .action-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .my-groups h2 {
        margin-bottom: 2rem;
    }

    .group-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    </style>
</body>
</html>