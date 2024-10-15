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

    function getComment($pdo) {

        $sql = 'SELECT * FROM comment';
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $comment = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $comment;
    }
?>
