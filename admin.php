<?php require_once('./components/header.php'); ?>

<h2>Administration</h2>
<p>Vous pouvez ajoutez, modifier, supprimer les catégories.</p>
<form action="POST" id="ajoutCategorie">
    <input type="text" name="categorie" value="" placeholder="Catégorie">
    <button type="submit" name="btn-creer">Créer</button>   
</form>
<p>Catégorie(s) acuelle(s) :</p>

<?php
    $connexion= getConnexion();
    $categories = getCategory($connexion); // Récupérer la liste des catégories
    // Parcourir chaque catégorie et créer une option pour la liste déroulante
    foreach ($categories as $row) { ?>
        <div>
            <form action="POST">
                <input type="text" name="name_cat" id="<?= $row['id_cat'] ?>" placeholder="<?= htmlspecialchars($row['name_cat']) ?>">
                <button type="submit" name="btn-modifier">Modifier</button>
                <button type="submit" name="btn-supprimer">Supprimer</button>
            </form>
        </div>
    <?php } ?>