<?php
include("./components/header.php");

$connexion = getConnexion();
?>

<main class="main-index">
    <div class="index-flex-container">
        <div class="container-1">
            <h2>Articles</h2>
            <form action="" class="create-article-form">
                <button type="button" class='button-action'>
                    Créer un article
                </button>
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
                <h3 class='caterogy-title'>Catégories : </h3>
                <?php
                //foreach li>a
                $catergories = [
                    'categorie1',
                    'categorie2',
                    'categorie3',
                    'categorie4',
                    'categorie5',
                ];

                foreach ($catergories as $i => $categorie) {
                    echo "<li><a class='a-categority' href='#'>{$categorie}</a></li>";
                }
                ?>
            </ul>
        </div>
        <div class="container-2">
            <?php
            // Example articles array
            $articles = [
                [
                    'title' => 'Article 1',
                    'date' => '01/01/2021',
                    'author' => 'John Doe',
                    'image' => 'article1.jpg'
                ],
                [
                    'title' => 'Article 2',
                    'date' => '02/01/2021',
                    'author' => 'Jane Doe',
                    'image' => 'article2.jpg'
                ],
            ];

            foreach ($articles as $i => $article) {
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