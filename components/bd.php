<?php
    function getConnexion() {
        //récupération des données
        try {
            $connexion = new PDO('mysql:host=localhost;dbname=blog_s2', 'root', 'azerty');

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
        // Prepare the SQL query
        $sql = 'SELECT id_cat, name_cat FROM CATEGORY';
    
        // Prepare and execute the query
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    
        // Fetch all results as an associative array
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $categories; // Returns the list of categories
    }
?>
