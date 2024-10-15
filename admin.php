<?php 
    require_once('./components/header.php'); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $connexion = getConnexion();

        if (isset($_POST['btn-modifier'])){
            $id_cat = $_POST['id_cat']; //récupère l'id de la catégorie
            $new_name = $_POST['name_cat'];
            //requête sql pour modifier la catégorie
            $sql = "UPDATE CATEGORY SET name_cat = ? WHERE id_cat = ?";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$new_name, $id_cat]);
            header("Location:admin.php");
        }
        elseif (isset($_POST['btn-supprimer'])){
            $id_cat = $_POST['id_cat']; //récupère l'id de la catégorie
            //requête sql pour supprimer la catégorie
            $sql = "DELETE FROM CATEGORY WHERE id_cat = ?";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$id_cat]);
            header("Location:admin.php");
        }
        elseif (isset($_POST['btn-creer'])){
            $name = $_POST['categorie']; //récupère le nom de la nouvelle catégorie
            //requête sql pour ajouter une catégorie
            $sql = "INSERT INTO CATEGORY (name_cat) VALUES (?)";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$name]);
            header("Location:admin.php");
        }
    }
?>


<h2>Administration</h2>
<p>Vous pouvez ajoutez, modifier, supprimer les catégories.</p>
<form method="post" id="ajoutCategorie">
    <input type="text" id="categorie" name="categorie" value="" placeholder="Catégorie">
    <button type="submit" name="btn-creer">Créer</button>   
</form>
<p>Catégorie(s) acuelle(s) :</p>

<?php
    $connexion= getConnexion();
    $categories = getCategory($connexion); // Récupérer la liste des catégories
    // Parcourir chaque catégorie et créer une option pour la liste déroulante
    foreach ($categories as $row) { ?>
        <div>
            <form method="post">
                <input type="text" name="name_cat" id="<?= $row['id_cat'] ?>" value="<?= htmlspecialchars($row['name_cat']) ?>" required>
                <input type="hidden" name="id_cat" value="<?= $row['id_cat'] ?>">
                <button type="submit" name="btn-modifier">Modifier</button>
                <button type="submit" name="btn-supprimer">Supprimer</button>
            </form>
        </div>
    <?php } ?>