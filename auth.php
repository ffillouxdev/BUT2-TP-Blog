<?php 
    include("./components/header.php");

    $connexion = getConnexion();
    if (!isset($_SESSION['sansPseudo'])) {
        $_SESSION['sansPseudo'] = false;
    }
?>
<main class='main-auth'>
    <?php if ($_SESSION['sansPseudo'] === false) { ?>
    <div class="auth-container">
        <h2>Connexion</h2>
        <form method='POST'>
            <input type="email" placeholder='Email' name='email'>
            <div class="show-hide-password">
                <input type="password" placeholder='Mot de passe' name ='mdp'>
                <span>👁️</span>
            </div>
            <button type='submit'>Se connecter</button>
        </form>
    </div>
    <?php } ?>
<?php
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email']) && !empty($_POST['mdp'])) {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['mdp'] = $_POST['mdp'];

        $stmt = getConnected($_SESSION['email']);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)){
            if ($stmt->rowCount() == 0) { 
                $_SESSION['sansPseudo'] = true;
                header('Location: ' . $_SERVER['PHP_SELF']); // Rediriger pour actualiser la page et afficher le formulaire de pseudo
                exit();
            } else {
                if (password_verify($_SESSION['mdp'], $user['mdp'])){        
                    $_SESSION['pseudo'] = $user['pseudo'];
                    header('Location: index.php');
                    exit();
                } else { ?>
                    <p class='error'>Le mot de passe rentré n'est pas le bon !</p>
                <?php
                }
            }
        } else { ?>
            <p class='error'>Vous n'avez pas rentré l'email dans le format désiré !</p>
        <?php    
        }
        
    }

    if ($_SESSION['sansPseudo'] === true) { ?>
        <div class='auth-container'>
            <h2>Insérer votre pseudo</h2>
            <form method='POST'>
                <input type='text' placeholder='Pseudo' name='pseudo' required>
                <button type='submit'>Confirmer</button>
            </form>
        </div>
    <?php
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
            unset($_SESSION['sansPseudo'],$_SESSION['mdp'], $_SESSION['email']);
            header('Location: index.php');
            exit();
        }
    }
?>
</main>
<?php
    include("./components/footer.php");
?>
