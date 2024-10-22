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
    $pseudoWriter = $user['pseudo'];

    $stmt = getCategoryWithArticle(4);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    $idCategory = $category['id_cat'];

    $stmt = getCategoryWithIdCategory($idCategory);
    $nameCategory = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $nameCategory['name_cat'];

    $commentaires = getCommentByArticle(4);
    $initialCount = 2;
?>
<main>
    <div class='main-article'>
        <h2><?php echo $title ;?></h2>

    <p class='rubrique-article'><a href="./index.php">Article</a>><?php echo "$name>$title";?></p>
    <div class='container-article'>
        <div class="content-article">
            <p><?php echo $content ?></p>
            <img src="./assets/article/<?php echo $image; ?>" alt="Article Image">
        </div>
        <div class='info-article'>
            <p><b>Auteur : </b><?php echo $pseudoWriter?></p>
            <p><b>Publié le :</b><?php echo $date?></p>
        </div>
    </div>
    
    <?php

        $rowCount = count($commentaires);
        if ($rowCount > 0){
            echo "<p class='rubrique-article'>Toutes les réponses :</p>";
            for ($i = 0; $i < $rowCount; $i++) {
                $contenuCommentaire = $commentaires[$i]['content_comment'];
                $auteurCommentaire = $commentaires[$i]['id_comment'];
                $dateCommentaire = $commentaires[$i]['date_comment']; 
                
                // Ajout d'une classe et d'un style pour les commentaires cachés
                $isHidden = $i >= $initialCount ? 'hidden' : '';
                ?>
                <div class='comment <?php echo $isHidden; ?>'>
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
            // Bouton "Voir plus"
            if ($rowCount > $initialCount) {
                echo "<button id='voir-plus'>Voir plus</button>";
            }
        }
    ?>
        
        <div class='post-comment'>
            <h2>Créer une réponse</h2>
            <p>Remplissez les champs ci-dessous pour créer et publier votre réponse!</p>
            <form action="" method='POST'>
                <textarea name="comment" placeholder='Votre réponse' maxlength="400"></textarea>
                <p id='caractere'>0 / 400 caractères</p>
                <button>Poster votre réponse</button>
            </form>
        </div>
        <?php 
            if(!empty($_POST['comment'])){
                insertComment("test", $_POST['comment'], 4);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        ?>
    </div>
</main>
<?php
    include("components/footer.php");
?>