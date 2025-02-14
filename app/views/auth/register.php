<div class="container mt-5">
    <div class="form-container">
        <h2>Inscription</h2>

        <?php if(isset($register_err)) : ?>
            <div class="alert alert-danger">
                <?php echo $register_err; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/auth/register" method="post">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" class="form-control" 
                       value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                <span class="error"><?php echo isset($username_err) ? $username_err : ''; ?></span>
            </div>

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

            <div class="form-group">
                <label for="confirm_password">Confirmez le mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                <span class="error"><?php echo isset($confirm_password_err) ? $confirm_password_err : ''; ?></span>
            </div>

            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
        <p class="mt-3">Déjà un compte? <a href="<?php echo BASE_URL; ?>/auth/login">Se connecter</a></p>
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

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}
</style>