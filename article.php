<?php 
    include("./components/header.php");
    include("./components/navbar.php");
    $connexion = getConnexion();
    /*if ($_SESSION['pseudo'] == null){
        header("Location: auth.php");
        exit();
    }*/
    $sql = "SELECT * FROM article WHERE id_article = 3";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = $user['title_article'];
    echo"<div class='article'>
            <h2>$title</h2>
        </div>";
?>