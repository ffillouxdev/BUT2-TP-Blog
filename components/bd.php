<?php
    function getConnexion() {
        //récupération des données
        try {
            $connexion = new PDO('mysql:host=localhost;dbname=blog_s2', 'root', '');

            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connexion;
        }
        catch (PDOException $e){
            die('Erreur PDO : ' . $e->getMessage());
        }
        catch (Exception $e){
            die('Erreur Générale : ' . $e->getMessage());
        }
    }

    function getConnected($email){
        $connexion = getConnexion();
        $sql = "SELECT id, mdp FROM user WHERE email = :email";
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    function verifyPseudo($pseudo){
        $connexion = getConnexion();
        $unique = true;
        $sql = "SELECT id FROM user WHERE pseudo = :pseudo";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            echo "<p class='error'>Ce pseudo est déjà utilisé !</p>";
            $unique = false;
        }
        return $unique;
    }

    function insertUser($email, $mdp, $pseudo){
        $connexion = getConnexion();
        $sql = "INSERT INTO user (email, mdp, pseudo, admin) VALUES (?, ?, ?, ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$email, $mdp, $pseudo, 0]);
    }

    function getArticle($id_article){
        $connexion = getConnexion();
        $sql = "SELECT * FROM article WHERE id_article = $id_article";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    function getPseudoWithArticle($id_article){
        $connexion = getConnexion();
        $sql = "SELECT U.pseudo FROM user U join article A on U.id = A.id where id_article = 4";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    function getCategoryWithArticle($id_article){
        $connexion = getConnexion();
        $sql = "SELECT id_cat FROM article_category_link where id_article = $id_article";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    function getCategoryWithIdCategory($idCategory){
        $connexion = getConnexion();
        $sql = "SELECT name_cat FROM category where id_cat = $idCategory";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    function getPseudoWithIdComment($idComment){
        $connexion = getConnexion();
        $sql = "SELECT U.pseudo FROM user U join comment C on U.id = C.id where id_comment = $idComment";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    function insertComment($pseudo, $comment, $id_article){
        $connexion = getConnexion();
        $sql = "SELECT U.id FROM user U WHERE U.pseudo = :pseudo";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([':pseudo' => $pseudo]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $user['id'];
        $sql = "INSERT into comment (content_comment, id_article, id, date_comment) values (?, ?, ?, ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$comment,$id_article,$id, date("Y-m-d")]);
    }

    function getCommentByArticle($id_article) {
        $connexion = getConnexion();
        $sql = "SELECT * FROM comment WHERE id_article = $id_article";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $user;
    }

    function getCategory($pdo) {
        $sql = 'SELECT id_cat, name_cat FROM CATEGORY';
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $categories;
    }

    function getComment($pdo) {

        $sql = 'SELECT * FROM comment';
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $comment = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $comment;
    }

    function getArticles($pdo) {
        $sql = 'SELECT id_article, title_article, content_article, picture_article,	id, date_article FROM ARTICLE';	
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $articles;
    }

?>
