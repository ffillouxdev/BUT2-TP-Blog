<?php
include_once("./components/header.php");
include("./components/navbar.php");
$connexion = getConnexion();
if ($_SESSION['pseudo'] == null){
    header("Location: auth.php");
    exit();
    }
$requestUri = trim($_SERVER['REQUEST_URI'], '/');
$parts = explode('/', $requestUri);

$articleIndex = array_search('article', $parts);

if ($articleIndex !== false) {
    $parts = array_slice($parts, $articleIndex);
}

if (count($parts) === 1) {
    header("Location: index.php");
    exit();
} elseif (count($parts) === 2) {
    $category_slug = $parts[1];
    $stmt = getArticlesByCategory($category_slug);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <main class="main-specific-category-articles">
        <h2>Articles dans la catégorie: <?php echo htmlspecialchars($category_slug); ?></h2>
        <div class="article-list">
            <?php foreach ($articles as $article) : ?>
                <?php
                $article_slug = slugify($article['title_article']);
                ?>
                <div class='article-filter-by-category'>
                    <h3><?php echo htmlspecialchars($article['title_article']); ?></h3>
                    <a class="a-redirection" href='<?php echo ($category_slug . '/' . $article_slug); ?>'>En savoir +</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <?php
} elseif (count($parts) === 3) {
    $category_slug = $parts[1];
    $article_slug = $parts[2];

    // Récupérer l'article par slug
    $stmt = getArticleBySlug($article_slug);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($article) {
        $title = $article['title_article'];
        $content = $article['content_article'];
        $image = $article['picture_article'];
        $date = $article['date_article'];

        $stmt = getPseudoWithArticle($article['id_article']);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $pseudoWriter = $user['pseudo'];

        $stmt = getCategoryWithArticle($article['id_article']);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        $idCategory = $category['id_cat'];

        $stmt = getCategoryWithIdCategory($idCategory);
        $nameCategory = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $nameCategory['name_cat'];

    $commentaires = getCommentByArticle($article['id_article']);
    $initialCount = 2;
?>
<main>
    <div class='main-article'>
        <h2><?php echo $title ;?></h2>

    <p class='rubrique-article'><a href="http://localhost/but2-tp-blog/index.php">Article</a>><?php echo "$name>$title";?></p>
    <div class='container-article'>
        <div class="content-article">
            <p><?php echo $content ?></p>
            <img src="http://localhost/but2-tp-blog/assets/article/<?php echo $image; ?>" alt="Article Image">
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
    } else {
        echo "<p>Article non trouvé.</p>";
    }
}

include("./components/footer.php");
?>