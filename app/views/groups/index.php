

<div class="container mt-5">
    <div class="header-actions">
        <h2>Mes Groupes</h2>
        <a href="<?php echo BASE_URL; ?>/groups/create" class="btn btn-primary">Créer un groupe</a>
    </div>

    <?php if(isset($_SESSION['success_msg'])) : ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success_msg']; 
                unset($_SESSION['success_msg']);
            ?>
        </div>
    <?php endif; ?>

    <?php if(empty($data['groups'])) : ?>
        <div class="alert alert-info">
            Vous n'avez encore aucun groupe. Créez-en un pour commencer !
        </div>
    <?php else : ?>
        <div class="groups-grid">
            <?php foreach($data['groups'] as $group) : ?>
                <div class="group-card">
                    <h3><?php echo htmlspecialchars($group->name); ?></h3>
                    <p class="description"><?php echo htmlspecialchars($group->description); ?></p>
                    <div class="group-footer">
                        <span class="role"><?php echo ucfirst($group->role); ?></span>
                        <a href="<?php echo BASE_URL; ?>/groups/show/<?php echo $group->id; ?>" 
                           class="btn btn-secondary">Voir le groupe</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>