<?php
 require_once('./components/header.php');
 include("./components/navbar.php"); 

 if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        
    $connexion = getConnexion();

    if (isset($_POST['btn-creerArticle'])){
        $title_article = $_POST['titreArticle']; //récupère le titre de l'article
        $content_article = $_POST['contentArticle']; //récupère le contenu de l'article
        $picture_article = $_FILES['imageArticle']['name']; //récupère le nom avec l'extention de l'image
        $chem_temp_image = $_FILES['imageArticle']['tmp_name']; //récupère le chemin temporaire de l'image
        $destination = './assets/article/' . $picture_article;
        move_uploaded_file($chem_temp_image, $destination);
        $id_user = 21; //en attente de modif
        $date = date("y-m-d"); //date actuelle au foramt AAAA-MM-DD
        $id_category = $_POST['categoryArticle']; //récupère l'id de la categorie

        //requête sql pour ajouter un article
        $sql = "INSERT INTO ARTICLE (title_article, content_article, picture_article, id, date_article) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$title_article, $content_article, $picture_article, $id_user, $date]);

        $id_article = $connexion->lastInsertId();
        //requête sql pour ajouter lier l'article créé à la catégorie
        $sql2 = "INSERT INTO ARTICLE_CATEGORY_LINK (id_article, id_cat) VALUES (?, ?)";
        $stmt = $connexion->prepare($sql2);
        $stmt->execute([$id_article, $id_category]);
        header("Location:index.php");
    }
 }
 ?>

<h2>Créer un article</h2>
<p>Remplissez les champs ci-dessous pour créer et publier votre article !</p>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="titreArticle" value="" placeholder="Titre" required>
    <input type="file" id="imageArticle" name="imageArticle" accept="image/png, image/jpeg" required>
    <textarea id="contentArticle" name="contentArticle" rows="5" maxlength="800" required></textarea>
    <select name="categoryArticle" id="categoryArticle" required> 
        <option value="" disabled selected hidden>Catégorie</option>
        <?php
        $connexion= getConnexion();
        $categories = getCategory($connexion); // Récupérer la liste des catégories

        // Parcourir chaque catégorie et créer une option pour la liste déroulante
        foreach ($categories as $row) { ?>
            <option value="<?= $row['id_cat'] ?>"> 
                <?= htmlspecialchars($row['name_cat']) ?> 
            </option>
        <?php } ?>
</select>
    <button type="submit" id ="btn-creerArticle" name="btn-creerArticle">Créer mon article</button>
</form>
