<?php 
    include("./components/header.php");
    include("./components/navbar.php");
    $connexion = getConnexion();
    /*if ($_SESSION['pseudo'] == null){
        header("Location: auth.php");
        exit();
    }*/
    $sql = "SELECT * FROM article WHERE id_article = 4";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = $user['title_article'];
    $content = $user['content_article'];
    $image = $user['picture_article'];
    $date = $user['date_article'];

    $sql = "SELECT U.pseudo FROM user U join article A on U.id = A.id where id_article = 4";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $pseudo = $user['pseudo'];

    $sql = "SELECT id_cat FROM article_category_link where id_article = 4";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    $idCategory = $category['id_cat'];

    $sql = "SELECT name_cat FROM category where id_cat = $idCategory";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $nameCategory = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $nameCategory['name_cat'];

    $commentaires = getComment($connexion);

    echo"<div class='main-article'>
            <h2>$title</h2>";
?>

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
                            
                            $sql = "SELECT U.pseudo FROM user U join comment C on U.id = C.id where id_comment = $auteurCommentaire";
                            $stmt = $connexion->prepare($sql);
                            $stmt->execute();
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
<?php
    include("components/footer.php");
    ?>