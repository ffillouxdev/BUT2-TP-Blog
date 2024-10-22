<?php
include("./components/header.php");
include("./components/navbar.php");
$connexion = getConnexion();
/*if ($_SESSION['pseudo'] == null){
        header("Location: auth.php");
        exit();
    }*/
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
    <main>
        <h2>Articles dans la catégorie: <?php echo htmlspecialchars($category_slug); ?></h2>
        <div class="article-list">
            <?php foreach ($articles as $article) : ?>
                <div class='article'>
                    <h3><?php echo htmlspecialchars($article['title_article']); ?></h3>

                    <a href='<?php echo htmlspecialchars($category_slug); ?>/<?php echo htmlspecialchars(slugify($article['title_article'])); ?>'>En savoir +</a>
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

    ?>
        <main>
            <div class='main-article'>
                <h2><?php echo htmlspecialchars($title); ?></h2>
                <p class='rubrique-article'><a href="./index.php">Article</a> > <?php echo htmlspecialchars($title); ?></p>
                <div class='container-article'>
                    <div class="content-article">
                        <p><?php echo nl2br(htmlspecialchars($content)); ?></p>
                        <img src="./assets/article/<?php echo htmlspecialchars($image); ?>" alt="Article Image">
                    </div>
                    <div class='info-article'>
                        <p><b>Auteur : </b><?php echo htmlspecialchars($pseudoWriter); ?></p>
                        <p><b>Publié le :</b> <?php echo htmlspecialchars($date); ?></p>
                    </div>
                </div>
                <div class='post-comment'>
                    <h2>Créer une réponse</h2>
                    <p>Remplissez les champs ci-dessous pour créer et publier votre réponse!</p>
                    <form action="" method='POST'>
                        <textarea name="comment" placeholder='Votre réponse'></textarea>
                        <p>0 / 400 caractères</p>
                        <button>Poster votre réponse</button>
                    </form>
                </div>
                <?php
                if (!empty($_POST['comment'])) {
                    insertComment("test", $_POST['comment'], 4);
                }
                ?>
            </div>
            </div>
        </main>
<?php
    } else {
        echo "<p>Article non trouvé.</p>";
    }
}   

include("./components/footer.php");
?>