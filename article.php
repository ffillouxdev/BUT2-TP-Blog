<?php 
    include("./components/header.php");
    include("./components/navbar.php");
    $connexion = getConnexion();
    /*if ($_SESSION['pseudo'] == null){
        header("Location: auth.php");
        exit();
    }*/
    $stmt = getArticle(4);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = $user['title_article'];
    $content = $user['content_article'];
    $image = $user['picture_article'];
    $date = $user['date_article'];

    $stmt = getPseudoWithArticle(4);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $pseudo = $user['pseudo'];

    $stmt = getCategoryWithArticle(4);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    $idCategory = $category['id_cat'];

    $stmt = getCategoryWithIdCategory($idCategory);
    $nameCategory = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $nameCategory['name_cat'];

    $commentaires = getComment($connexion);
?>
<main>
    <div class='main-article'>
        <h2><?php echo $title ;?></h2>

    <p class='rubrique-article'><a href="./index.php">Article</a>><?php echo "$name>$title";?></p>
    <div class='container-article'>
        <div class="content-article">
            <p><?php echo $content ?></p>
            <img src="http://localhost/but2-tp-blog/assets/<?php echo $image; ?>" alt="Article Image">
        </div>
        <div class='info-article'>
            <p><b>Auteur : </b><?php echo $pseudo?></p>
            <p><b>Publié le :</b><?php echo $date?></p>
        </div>
    </div>
    
    <?php

        $rowCount = count($commentaires);
        if ($rowCount > 0){
            echo "<p class='rubrique-article'>Toutes les réponses :</p>";
            for ($i = 0; $i < 10 && $i < $rowCount; $i++) {
                $contenuCommentaire = $commentaires[$i]['content_comment'];
                $auteurCommentaire = $commentaires[$i]['id_comment'];
                $dateCommentaire = $commentaires[$i]['date_comment']; 
                ?>
                <div class='comment'>
                    <p class='content-comment'><?php echo $contenuCommentaire;?></p>
                    <div class='info-article'>
                        <?php
                            
                            $stmt = getPseudoWithIdComment($auteurCommentaire);
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            $pseudoCommentaire = $user['pseudo'];
                            
                        ?>
                        <p><b>Auteur : </b><?php echo $pseudoCommentaire?></p>
                        <p><b>Publié le :</b><?php echo $dateCommentaire?></p>
                    </div>
                </div>
        <?php
            }
        } 
    ?>
    </div>
</main>
<?php
    include("components/footer.php");
    ?>