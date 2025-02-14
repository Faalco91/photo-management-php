<div class="container">
    <h1>Bienvenue sur Photo Management</h1>
    
    <?php if(isset($_SESSION['user_id'])) : ?>
        <div class="dashboard">
            <div class="quick-actions">
                <h2>Actions rapides</h2>
                <div class="action-buttons">
                    <a href="<?php echo BASE_URL; ?>/groups/create" class="btn">Cr�er un groupe</a>
                    <a href="<?php echo BASE_URL; ?>/groups" class="btn">Mes groupes</a>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="welcome-section">
            <h2>Partagez vos photos de voyage avec vos amis</h2>
            <p>Cr�ez des groupes, partagez vos photos et gardez vos souvenirs de voyage organis�s.</p>
            <div class="cta-buttons">
                <a href="<?php echo BASE_URL; ?>/auth/register" class="btn btn-primary">S'inscrire</a>
                <a href="<?php echo BASE_URL; ?>/auth/login" class="btn">Se connecter</a>
            </div>
        </div>
    <?php endif; ?>
</div>