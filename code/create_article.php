<?php
require_once('./components/header.php');
include("./components/navbar.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['btn-creerArticle'])) {
        $title_article = $_POST['titreArticle']; 
        $content_article = $_POST['contentArticle']; 
        $picture_article = $_FILES['imageArticle']['name']; 
        $chem_temp_image = $_FILES['imageArticle']['tmp_name']; 
        $destination = './assets/article/' . $picture_article; 
        move_uploaded_file($chem_temp_image, $destination); 
        $id_user = getIdWithPseudo($_SESSION['pseudo']);
        $date = date("Y-m-d"); 
        $id_categorys = $_POST['categoryArticle']; 

        insertArticle($title_article, $content_article, $picture_article, $id_user, $date, $id_categorys);
        
        header("Location:index.php");
        exit();
    }
}
?>

<div class="form-container">
    <h2 class="form-title">Créer un article</h2>
    <p class="form-description">Remplissez les champs ci-dessous pour créer et publier votre article !</p>
    <form method="POST" enctype="multipart/form-data" class="article-form">
        <div class="form-group">
            <input type="text" name="titreArticle" class="form-input" placeholder="Titre" required>
        </div>
        <div class="form-group">
            <input type="file" id="imageArticle" name="imageArticle" class="form-input-file" accept="image/*" required>
        </div>
        <div class="form-group">
            <textarea id="contentArticle" name="contentArticle" class="form-textarea" rows="5" maxlength="800" placeholder="Votre article" required></textarea>
        </div>
        <div class="form-group">
            <label for="categoryArticle" class="form-label">Catégories</label>
            <select name="categoryArticle[]" id="categoryArticle" class="form-select" multiple required> 
                <?php
                $connexion = getConnexion();
                $categories = getCategory($connexion); 
                foreach ($categories as $row) { ?>
                    <option value="<?= htmlspecialchars($row['id_cat']) ?>"> 
                        <?= htmlspecialchars($row['name_cat']) ?> 
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" id="btn-creerArticle" name="btn-creerArticle" class="form-button">Créer mon article</button>
        </div>
    </form>
</div>

<script>
// JavaScript pour permettre la sélection multiple sans avoir besoin de Ctrl ou Cmd
document.getElementById('categoryArticle').addEventListener('mousedown', function(e) {
    e.preventDefault(); 
    const option = e.target; 
    
    option.selected = !option.selected;
    
    return false; 
});
</script>
<?php
include("./components/footer.php"); 
?>
