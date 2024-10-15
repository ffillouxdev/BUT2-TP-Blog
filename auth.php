<?php 
    include("./components/header.php");

    $connexion = getConnexion();
?>
    <div class="auth-container">
        <h2>Connexion</h2>
        <form method='POST'>
            <input type="email" placeholder='Email' name='email'>
            <input type="text" placeholder='Mot de passe' name ='mdp'>
            <button type='submit'>Se connecter</button>
        </form>
    </div>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email']) && !empty($_POST['mdp'])) {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['mdp'] = password_hash($_POST['mdp']);
        
        // Vérifie si l'utilisateur existe déjà
        $sql = "SELECT id FROM user WHERE email = :email";
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            // Afficher le formulaire pour demander le pseudo
            echo "<div class='form'>
                    <h3>Insérer votre pseudo</h3>
                    <form method='POST'>
                        <input type='text' placeholder='Pseudo' name='pseudo' required>
                        <button type='submit'>Confirmer</button>
                    </form>
                </div>";
        } else {
            $sql = "SELECT id FROM user WHERE email = :email and mdp = :mdp";
            $stmt = $connexion->prepare($sql);
            $stmt->bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);
            $stmt->bindValue(':mdp', password_hash($_POST['mdp']), PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() == 1){
                $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère la ligne sous forme de tableau associatif
                $_SESSION['pseudo'] = $user['pseudo']; // Stocke le pseudo dans la session
                header('Location: index.php');
                exit();
            } else {
                echo "<p class='errorPassword'>Le mot de passe rentré n'est pas le bon !</p>";
            }
        }
    }

    // Si le formulaire pour le pseudo a été soumis
    if (!empty($_POST['pseudo'])) {
        $pseudo = $_POST['pseudo'];
        
        // Insère le nouvel utilisateur dans la base de données
        $sql = "INSERT INTO user (email, mdp, pseudo, admin) VALUES (?, ?, ?, ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$_SESSION['email'], $_SESSION['mdp'], $pseudo, 0]);
        $_SESSION['pseudo'] = $pseudo;

        header('Location: index.php');
        exit();
    }

    include("./components/footer.php");
?>
