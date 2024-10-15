<?php
include("./components/header.php");
include("./components/navbar.php");

$connexion = getConnexion();
$categories = getCategory($connexion);
$articles = getArticles($connexion);
?>

<main class="main-index">
    <div class="index-flex-container">
        <div class="container-1">
            <h2>Articles</h2>
            <form action="" class="create-article-form">
                <a class='a-action' href="create_article">
                    Créer un article
                </a>
            </form>
            <div class="filter-checkbox">
                <h3 for="filter"> Liste des filtre</h3>
                <div>
                    <ul>
                        <li>
                            <div class="li-flex">
                                <label>username</label>
                                <input type="checkbox" id="filter" name="filter">
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
            <ul class="category-list">
                <h3 class='category-title'>Catégories : </h3>
                <?php
                foreach ($categories as $categorie) {
                    echo "<li><a class='a-category' href='#'>{$categorie['name_cat']}</a></li>";
                }
                ?>
            </ul>

        </div>
        <div class="container-2">
            <?php
            foreach ($articles as $article) {
                echo "
                <div class='article article-$i'>
                    <div class='image-article'>
                        <img src='./images/{$article['image']}' alt='image-article'>
                    </div>
                    <div class='content-article'>
                        <h3>{$article['title']}</h3>
                        <div class='content-article-bottom'>
                            <p>Posté le : {$article['date']}</p>
                            <div class='content-article-author'>
                                <p><strong>auteur : </strong> {$article['author']}</p>
                                <a class='a-redirection' href='#'>En savoir +</a>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
            <button type="button" class="button-show-more">
                Voir plus
            </button>
        </div>
</main>

<?php
include("./components/footer.php");
?>