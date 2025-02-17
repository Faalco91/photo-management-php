<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Photo - RoadPic</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <div class='banner-icon'>
        <a href="/"><img src="/images/RoadPic.svg" alt="RoadPic" class="logo" width="80"></a>
    </div>
    <main class="presentation upload-main-container">
        <section class="upload-section">
            <div class="upload-description-container">
                <article>
                    <h1>Partagez vos souvenirs</h1>
                    <p>Uploadez vos photos et partagez-les avec votre groupe.</p>
                </article>
            </div>
            <div class="upload-form-container">
                <?php if(isset($_SESSION['success_msg'])) : ?>
                    <div class="alert alert-success">
                        <?php 
                            echo $_SESSION['success_msg']; 
                            unset($_SESSION['success_msg']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo BASE_URL; ?>/photos/upload" method="post" enctype="multipart/form-data">
                    <div class="upload-form-group form-group">
                        <select name="group_id" class="form-control <?php echo (!empty($data['group_id_err'])) ? 'is-invalid' : ''; ?>">
                            <option value="">Sélectionner un groupe</option>
                            <?php foreach($data['groups'] as $group) : ?>
                                <option value="<?php echo $group->id; ?>" 
                                    <?php echo ($data['group_id'] == $group->id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($group->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="error"><?php echo $data['group_id_err']; ?></span>
                    </div>

                    <div class="upload-form-group form-group">
                        <input type="text" name="title" class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" 
                               placeholder="Titre de la photo"
                               value="<?php echo $data['title']; ?>">
                        <span class="error"><?php echo $data['title_err']; ?></span>
                    </div>

                    <div class="upload-form-group form-group">
                        <textarea name="description" class="form-control" 
                                  placeholder="Description de la photo" rows="3"><?php echo $data['description']; ?></textarea>
                    </div>

                    <div class="upload-form-group form-group">
                        <input type="file" name="photo" accept="image/*" class="form-control <?php echo (!empty($data['photo_err'])) ? 'is-invalid' : ''; ?>">
                        <span class="error"><?php echo $data['photo_err']; ?></span>
                        <small class="text-muted">Formats acceptés : JPG, JPEG, PNG, GIF. Taille maximum : 5MB</small>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="is_public" 
                               name="is_public" value="1" <?php echo ($data['is_public']) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_public">Rendre la photo publique</label>
                    </div>

                    <button type="submit" class="btn upload-btn2">Uploader la photo</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>