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

    <?php if(empty($groups)) : ?>
        <div class="alert alert-info">
            Vous n'avez encore aucun groupe. Créez-en un pour commencer !
        </div>
    <?php else : ?>
        <div class="groups-grid">
            <?php foreach($groups as $group) : ?>
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

<style>
.header-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.groups-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px 0;
}

.group-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.group-card h3 {
    margin: 0 0 10px 0;
    color: #333;
}

.description {
    color: #666;
    margin-bottom: 15px;
    min-height: 60px;
}

.group-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
}

.role {
    display: inline-block;
    padding: 4px 8px;
    background: #e9ecef;
    border-radius: 4px;
    font-size: 0.875em;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-info {
    color: #0c5460;
    background-color: #d1ecf1;
    border-color: #bee5eb;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}
</style>