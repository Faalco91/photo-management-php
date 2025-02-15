<div class="presentation container mt-5">
    <div class="form-container">
        <h2>Connexion</h2>
        
        <?php if(isset($_SESSION['success_msg'])) : ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success_msg']; 
                    unset($_SESSION['success_msg']);
                ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/auth/login" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                <span class="error"><?php echo isset($email_err) ? $email_err : ''; ?></span>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control">
                <span class="error"><?php echo isset($password_err) ? $password_err : ''; ?></span>
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
        <p class="mt-3">Pas encore de compte? <a href="<?php echo BASE_URL; ?>/auth/register">S'inscrire</a></p>
    </div>
</div>

<style>
.form-container {
    max-width: 500px;
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
</style>