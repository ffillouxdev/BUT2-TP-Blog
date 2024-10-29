<?php
session_start();

if (!isset($_SESSION['isAdmin'])) {
    $_SESSION['isAdmin'] = false;
}

require_once('./components/header.php');
include("./components/navbar.php");

if ($_SESSION['isAdmin'] !== true) {
    echo "Vous n'êtes pas autorisé à accéder à cette page.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['btn-modifier'])) {
        $id_cat = $_POST['id_cat'];
        $new_name = $_POST['name_cat'];
        updateCategory($id_cat, $new_name);
        header("Location:admin.php");
    } elseif (isset($_POST['btn-supprimer'])) {
        $id_cat = $_POST['id_cat'];
        deleteCategory($id_cat);
        header("Location:admin.php");
    } elseif (isset($_POST['btn-creer'])) {
        $name = $_POST['categorie'];
        if (!empty($name)) { // Vérification côté serveur
            insertCategory($name);
            header("Location:admin.php");
        } else {
            echo "<p style='color:red;'>Le champ catégorie ne peut pas être vide.</p>";
        }
    }
}
?>

<main class="main-admin">
    <h2>Administration</h2>
    <p>Vous pouvez ajouter, modifier, supprimer les catégories.</p>
    <form method="post" class="ajoutCategorie" onsubmit="return validateCategoryForm()">
        <input type="text" class="input-category-admin" id="categorie" name="categorie" placeholder="Catégorie" required>
        <button type="submit" class="form-button" name="btn-creer">Créer</button>
    </form>
    <div class="actual-categories">
        <p>Catégorie(s) actuelle(s) :</p>
        <?php
        $connexion = getConnexion();
        $categories = getCategory($connexion);
        foreach ($categories as $row) { ?>
            <div>
                <form method="post" class="category-element">
                    <input type="text" name="name_cat" class="input-form-admin" id="<?= $row['id_cat'] ?>" value="<?= htmlspecialchars($row['name_cat']) ?>" required>
                    <input type="hidden" name="id_cat" value="<?= $row['id_cat'] ?>">
                    <div class="category-btn">
                        <button type="submit" name="btn-modifier">Modifier</button>
                        <button type="submit" name="btn-supprimer">Supprimer</button>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</main>

<?php
require_once("./components/footer.php");
?>
<script>
function validateCategoryForm() {
    const categoryInput = document.getElementById('categorie');
    if (categoryInput.value.trim() === '') {
        alert("Le champ catégorie ne peut pas être vide.");
        return false;
    }
    return true;
}
</script>
