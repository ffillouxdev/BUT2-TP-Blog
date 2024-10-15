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
?>
