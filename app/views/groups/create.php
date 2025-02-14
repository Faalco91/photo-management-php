<div class="container mt-5">
    <div class="form-container">
        <h2>Créer un nouveau groupe</h2>
        
        <form action="<?php echo BASE_URL; ?>/groups/create" method="post">
            <div class="form-group">
                <label for="name">Nom du groupe</label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                <span class="error"><?php echo isset($name_err) ? $name_err : ''; ?></span>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4"
                          ><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Créer le groupe</button>
            <a href="<?php echo BASE_URL; ?>/groups" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>

<style>
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.error {
    color: #dc3545;
    font-size: 0.875em;
    margin-top: 5px;
    display: block;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    margin-right: 10px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    text-decoration: none;
}
</style>