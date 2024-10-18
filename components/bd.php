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

    function getCategory($pdo) {
        $sql = 'SELECT id_cat, name_cat FROM CATEGORY';
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $categories;
    }

    function getArticles($pdo) {
        $sql = 'SELECT id_article, title_article, content_article, picture_article,	id, date_article FROM ARTICLE';	
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $articles;
    }

?>
