<?php 
    include("./components/header.php");

    $connexion = getConnexion();
?>
<main>
    <div class="auth-container">
        <h2>Connexion</h2>
        <form method='POST'>
            <input type="email" placeholder='Email' name='email'>
            <input type="text" placeholder='Mot de passe' name ='mdp'>
            <button type='submit'>Se connecter</button>
        </form>
    </div>
</main>
<?php
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email']) && !empty($_POST['mdp'])) {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['mdp'] = $_POST['mdp'];

        $stmt = getConnected($_SESSION['email']);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 0) { ?>
            <div class='formPseudo'>
                    <h2>Insérer votre pseudo</h2>
                    <form method='POST'>
                        <input type='text' placeholder='Pseudo' name='pseudo' required>
                        <button type='submit'>Confirmer</button>
                    </form>
                </div>";
        <?php
        } else {

            if (password_verify($_SESSION['mdp'], $user['mdp'])){        
                $_SESSION['pseudo'] = $user['pseudo']; // Stocke le pseudo dans la session
                header('Location: index.php');
                exit();
            } else {?>
                <p class='error'>Le mot de passe rentré n'est pas le bon !</p>
            <?php
            }
        }

        
    }

    // Si le formulaire pour le pseudo a été soumis
    if (!empty($_POST['pseudo'])) {
        $pseudo = $_POST['pseudo'];
        $mdp = $_SESSION['mdp'];

        // Hachage du mot de passe avant l'insertion
        $mdp_hache = password_hash($mdp, PASSWORD_DEFAULT);
        
        if (verifyPseudo($pseudo)){
            insertUser($_SESSION['email'], $mdp_hache, $pseudo);
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['mdp'] = null;
            header('Location: index.php');
            exit();
        }
    }

    include("./components/footer.php");
?>
