<?php
include_once('bd.php');

if (!defined('ROOT_URL')) {
    $requestUri = trim($_SERVER['REQUEST_URI'], '/');
    $parts = explode('/', $requestUri);
    define('ROOT_URL', strtolower('/' . $parts[0] . '/' . $parts[1] . '/'));
}

$baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = strtolower($baseDir . '/');
$_SESSION['baseUrl'] = 'http://localhost' . $baseUrl;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'disconnect') {
    session_destroy();
    header('Location: ' . ROOT_URL . 'code/auth');
    exit();
}

if (empty($_SESSION['pseudo'])) {
    header("Location: http://localhost/but2-tp-blog/auth.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>styles/style.css">
    <title>BUT2-TP-Blog</title>
</head>
<body>
<header>
    <nav>
        <form action="" method="POST">
            <input type="hidden" name="action" value="disconnect">
            <button class="disconnect-btn">Se déconnecter</button>
        </form>
        <a href="http://localhost/but2-tp-blog/code/index.php"><h1>BUT2-TP-Blog</h1></a>
    </nav>
</header>
