<?php

include("./components/header.php");
include("./components/navbar.php");
$connexion = getConnexion();
$categories = getCategory($connexion);
$userId = getIdWithPseudo($_SESSION['pseudo']);

if (empty($_SESSION['sort'])) {
    $_SESSION['sort'] = false;
}

if ($_SESSION['sort'] === true) {
    $articles = getArticleSort($connexion);
} elseif ($_SESSION['sort'] === false) {
    $articles = getArticles($connexion);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['filter']) && $_POST['filter'] == 'checked') {
        $_SESSION['sort'] = true;
    } else {
        $_SESSION['sort'] = false;
    }
    header("Location: index.php");
}

if (isset($_GET['delete'])) {
    $articleId = $_GET['delete'];
    deleteArticle($connexion, $articleId);
    header("Location: index.php"); 
}
?>

<main class="main-index">
    <div class="index-flex-container">
        <div class="container-1">
            <h2>Articles</h2>
            <div class="article-content">
                <a class='a-action' href="create_article">Créer un article</a>
                <div class="filter-checkbox">
                    <h3>Liste des filtres</h3>
                    <div>
                        <ul>
                            <li>
                                <div class="li-flex">
                                    <label for="filter">Username</label>
                                    <form id="filterForm" method="POST" action="index.php">
                                        <input type="checkbox" id="filter" name="filter" value="checked" onchange="document.getElementById('filterForm').submit();"
                                            <?php if ($_SESSION['sort'] === true) {
                                                echo 'checked';
                                            } ?>>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <h3 class='category-title'>Catégories :</h3>
            <ul class="category-list">
                <?php
                foreach ($categories as $categorie) {
                    echo "<li><a class='a-category' href='article/{$categorie['name_cat']}'>{$categorie['name_cat']}</a></li>";
                }
                ?>
            </ul>
        </div>

        <div class="container-2">
            <?php
            foreach ($articles as $article) {
                $category_of_article_stmt = getCategoryWithArticle($article['id_article']);
                $category_of_article = $category_of_article_stmt->fetch(PDO::FETCH_ASSOC)['id_cat'];
                $category_name = getCategoryWithIdCategory($category_of_article)->fetch(PDO::FETCH_ASSOC)['name_cat'];
                $user_creator = getUserWhoCreateArticle($article['id'])->fetch(PDO::FETCH_ASSOC)['pseudo'];
                $category_slug = slugify($category_name);
                $article_slug = slugify($article['title_article']);
                $baseUrl = $_SESSION['baseUrl'];
                
                echo "
                <div class='article-index article-{$article['id_article']}'>
                    <div class='image-article'>
                        <img src='{$baseUrl}assets/article/{$article['picture_article']}' alt='image-article'>
                    </div>
                    <div class='content-article'>
                        <div class='title-content-article'>
                            <h3>{$article['title_article']}</h3>
                            <p>Posté le : {$article['date_article']}</p>
                        </div>
                        <div class='content-article-bottom'>
                            <div class='content-article-author'>
                                <p><strong>Auteur : </strong> {$user_creator}</p>
                            </div>
                            <a class='a-redirection' href='article/$category_slug/{$article_slug}'>En savoir +</a>
                ";

                // Vérifiez si l'utilisateur est l'auteur de l'article
                if ($userId === $article['id']) {
                    echo "
                            <form method='GET' action='index.php' style='display:inline;'>
                                <button type='submit' name='delete' value='{$article['id_article']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ?\");'>Supprimer</button>
                            </form>
                    ";
                }

                echo "
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
            <button type="button" class="button-show-more">Voir plus</button>
        </div>
    </div>
</main>

<?php
include("./components/footer.php");
?>
