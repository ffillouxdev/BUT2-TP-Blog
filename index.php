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
            <div class="article-content">
                <form action="" class="create-article-form">
                    <a class='a-action' href="create_article">
                        Créer un article
                    </a>
                </form>
                <div class="filter-checkbox">
                    <h3>Liste des filtres</h3>
                    <div>
                        <ul>
                            <li>
                                <div class="li-flex">
                                    <label for="filter">Username</label>
                                    <input type="checkbox" id="filter" name="filter">
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
                    echo "<li><a class='a-category' href='category.php?name={$categorie['name_cat']}'>{$categorie['name_cat']}</a></li>"; // Correction de l'URL du lien
                }
                ?>
            </ul>

        </div>

        <div class="container-2">
            <?php
            foreach ($articles as $article) {
                echo "
                <div class='article article-{$article['id_article']}'>
                    <div class='image-article'>
                        <img src='./images/{$article['picture_article']}' alt='image-article'>
                    </div>
                    <div class='content-article'>
                        <h3>{$article['title_article']}</h3>
                        <div class='content-article-bottom'>
                            <p>Posté le : {$article['date_article']}</p>
                            <div class='content-article-author'>
                                <p><strong>Auteur : </strong> {$article['id']}</p>
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
    </div>
</main>

<?php
include("./components/footer.php");
?>