<div class="container mt-5">
    <!-- Header avec titre et actions -->
    <div class="header-actions">
        <div class="title-section">
            <h2><?php echo htmlspecialchars($data['group']->name); ?></h2>
            <p class="description"><?php echo htmlspecialchars($data['group']->description); ?></p>
        </div>
        <div class="action-buttons">
            <a href="<?php echo BASE_URL; ?>/photos/upload?group=<?php echo $data['group']->id; ?>" 
               class="btn btn-primary">Ajouter une photo</a>
            <a href="<?php echo BASE_URL; ?>/dashboard" 
               class="btn btn-secondary">Retour au dashboard</a>
        </div>
    </div>

    <!-- Messages de succès et d'erreur -->
    <?php if(isset($_SESSION['success_msg'])) : ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success_msg']; 
                unset($_SESSION['success_msg']);
            ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['error_msg'])) : ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error_msg']; 
                unset($_SESSION['error_msg']);
            ?>
        </div>
    <?php endif; ?>

    <!-- Layout principal -->
    <div class="group-sections">
        <!-- Section des membres -->
        <div class="members-section">
            <div class="section-header">
                <h3>Membres du groupe</h3>
                <?php if($data['isOwner']): ?>
                    <button class="btn btn-primary" onclick="toggleAddMemberForm()">
                        <i class="fas fa-user-plus"></i> Ajouter un membre
                    </button>
                <?php endif; ?>
            </div>

            <!-- Formulaire d'ajout de membre -->
            <div id="addMemberForm" style="display: none;" class="add-member-form">
                <form action="<?php echo BASE_URL; ?>/groups/addMember/<?php echo $data['group']->id; ?>" method="post">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" 
                               placeholder="Email du nouveau membre" required>
                        <small class="form-text text-muted">
                            Entrez l'email de l'utilisateur que vous souhaitez ajouter au groupe
                        </small>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleAddMemberForm()">Annuler</button>
                    </div>
                </form>
            </div>

            <!-- Liste des membres -->
            <div class="members-list">
                <?php foreach($data['members'] as $member): ?>
                    <div class="member-card">
                        <div class="member-info">
                            <div class="member-details">
                                <span class="member-name"><?php echo htmlspecialchars($member->username); ?></span>
                                <?php if($member->email === $_SESSION['user_email']): ?>
                                    <span class="member-you">(Vous)</span>
                                <?php endif; ?>
                            </div>
                            <span class="member-role <?php echo strtolower($member->role); ?>">
                                <?php echo ucfirst($member->role); ?>
                            </span>
                        </div>
                        <?php if($data['isOwner'] && $member->id != $_SESSION['user_id']): ?>
                            <form action="<?php echo BASE_URL; ?>/groups/removeMember/<?php echo $data['group']->id; ?>/<?php echo $member->id; ?>" 
                                  method="post" class="remove-member-form" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer ce membre ?');">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-user-minus"></i> Retirer
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Bouton de suppression du groupe (uniquement pour le propriétaire) -->
            <?php if($data['isOwner']): ?>
                <div class="group-actions">
                    <form action="<?php echo BASE_URL; ?>/groups/delete/<?php echo $data['group']->id; ?>" 
                          method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce groupe ? Cette action est irréversible.');">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Supprimer le groupe
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <!-- Section des photos -->
        <div class="photos-section">
            <h3>Photos du groupe</h3>
            <?php if(empty($data['photos'])) : ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Aucune photo n'a encore été partagée dans ce groupe.
                </div>
            <?php else : ?>
                <div class="photos-grid">
                    <?php foreach($data['photos'] as $photo) : ?>
                        <div class="photo-card">
                            <div class="photo-image">
                                <img src="<?php echo BASE_URL; ?>/uploads/photos/<?php echo $photo->filename; ?>" 
                                     alt="<?php echo htmlspecialchars($photo->title); ?>">
                            </div>
                            <div class="photo-info">
                                <h4><?php echo htmlspecialchars($photo->title); ?></h4>
                                <?php if(!empty($photo->description)): ?>
                                    <p class="photo-description"><?php echo htmlspecialchars($photo->description); ?></p>
                                <?php endif; ?>
                                <div class="photo-meta">
                                    <span class="photo-author">
                                        <i class="fas fa-user"></i> 
                                        <?php echo htmlspecialchars($photo->username); ?>
                                    </span>
                                    <span class="photo-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?php echo date('d/m/Y', strtotime($photo->created_at)); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.header-actions {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
    padding-top: 100px;
}

.title-section {
    flex: 1;
}

.title-section h2 {
    margin: 0 0 10px 0;
    color: #333;
}

.description {
    color: #666;
    margin: 0;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

.group-sections {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 30px;
    margin-top: 30px;
}

.members-section {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.add-member-form {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.members-list {
    margin-top: 15px;
}

.member-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.member-card:last-child {
    border-bottom: none;
}

.member-details {
    display: flex;
    align-items: center;
    gap: 8px;
}

.member-you {
    color: #666;
    font-size: 0.9em;
}

.member-role {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.875em;
    background: #e9ecef;
    color: #666;
}

.member-role.owner {
    background: #cce5ff;
    color: #004085;
}

.photos-section {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.photos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.photo-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.photo-card:hover {
    transform: translateY(-5px);
}

.photo-image {
    position: relative;
    padding-top: 75%; /* Ratio 4:3 */
}

.photo-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-info {
    padding: 15px;
}

.photo-info h4 {
    margin: 0 0 10px 0;
    color: #333;
}

.photo-description {
    color: #666;
    font-size: 0.9em;
    margin-bottom: 10px;
}

.photo-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.8em;
    color: #888;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-sm {
    padding: 4px 8px;
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

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert-info {
    color: #0c5460;
    background-color: #d1ecf1;
    border-color: #bee5eb;
}

@media (max-width: 768px) {
    .group-sections {
        grid-template-columns: 1fr;
    }
    
    .header-actions {
        flex-direction: column;
        gap: 15px;
    }
    
    .action-buttons {
        width: 100%;
    }
    
    .btn {
        flex: 1;
        text-align: center;
        justify-content: center;
    }
}
</style>

<script>
function toggleAddMemberForm() {
    const form = document.getElementById('addMemberForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>