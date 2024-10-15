<?php require_once('./components/header.php'); ?>

<h2>Créer un article</h2>
<p>Remplissez les champs ci-dessous pour créer et publier votre article !</p>
<form action="POST">
    <input type="text" name="titreArticle" value="" placeholder="Titre" required>
    <input type="file" id="imageArticle" name="imageArticle" accept="image/png, image/jpeg">
    <textarea id="Message" name="Message" rows="5"></textarea>
    <select name="categorieArticle" id="categorieArticle" required> 
        <option value="" disabled selected hidden>Catégorie</option>
    <?php
        $connexion= getConnexion();
        $categories = getCategory($connexion); // Récupérer la liste des catégories

        // Parcourir chaque catégorie et créer une option pour la liste déroulante
        foreach ($categories as $row) { ?>
            <option value="<?= $row['id_cat'] ?>"> 
                <?= htmlspecialchars($row['name_cat']) ?> 
            </option>
        <?php } ?>
</select>
    <button type="submit" id ="btn-creerArticle" name="btn-creerArticle" maxlength="800" required>Créer mon article</button>
</form>
