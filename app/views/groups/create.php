<div class="container mt-5">
    <div class="form-container">
        <h2>Créer un nouveau groupe</h2>
        
        <form action="<?php echo BASE_URL; ?>/groups/create" method="post">
            <div class="form-group">
                <label for="name">Nom du groupe</label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="<?php echo isset($data['name']) ? htmlspecialchars($data['name']) : ''; ?>">
                <span class="error"><?php echo isset($data['name_err']) ? $data['name_err'] : ''; ?></span>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4"
                          ><?php echo isset($data['description']) ? htmlspecialchars($data['description']) : ''; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Créer le groupe</button>
            <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>

