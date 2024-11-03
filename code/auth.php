<?php 
include_once("./components/header.php");
$connexion = getConnexion();
if (!isset($_SESSION['sansPseudo'])) {
    $_SESSION['sansPseudo'] = false;
}

if (!isset($_SESSION['isAdmin'])) {
    $_SESSION['isAdmin'] = false;
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
                <span id='show-password'>👁️</span>
            </div>
            <button type='submit' class="form-button">Se connecter</button>
        </form>
    </div>
    <?php } ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email']) && !empty($_POST['mdp'])) {
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    $stmt = getConnected($_SESSION['email']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)){
        if ($stmt->rowCount() == 0) { 
            $_SESSION['sansPseudo'] = true;
            header('Location: ' . $_SERVER['PHP_SELF']); 
            exit();
        } else {
            if (password_verify($_POST['mdp'], $user['mdp'])){        
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['isAdmin'] = $user['admin'] == 1 ? true : false;
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
            unset($_SESSION['sansPseudo']);
    }

// Si le formulaire pour le pseudo a été soumis
if (!empty($_POST['pseudo'])) {
    $pseudo = $_POST['pseudo'];
    $mdp = $_SESSION['mdp'];
    
    if (verifyPseudo($pseudo)){
        insertUser($_SESSION['email'], $mdp, $pseudo);
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['isConnected'] = true;  
        unset($_SESSION['sansPseudo'],$_SESSION['mdp'], $_SESSION['email']);
        $_SESSION['pseudo'] = $pseudo;
        header('Location: index.php');
        exit();
    }
}
?>
</main>
<?php
include("./components/footer.php");
?>
