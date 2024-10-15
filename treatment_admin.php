<?php
    include('bd.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id_cat = $_POST['id_cat']; //récupère l'id de la catégorie

        if (isset($_POST['btn-modifier'])){
            $new_name = $_POST['name_cat'];
            //requête sql pour modifier la catégorie
            $sql = "UPDATE CATEGORY SET name_cat = ? WHERE id_cat = ?";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$new_name, $id_cat]);
            echo "Catégorie mise à jour";
        }
        elseif (isset($_POST['btn-supprimer'])){
            //requête sql pour supprimer la catégorie
            $sql = "DELETE FROM CATEGORY WHERE id_cat = ?";
            $stmt = $connexion->prepare($sql);
            $stmt->exute(['id_cat']);
            echo "Catégorie supprimée";
        }
    }
?>