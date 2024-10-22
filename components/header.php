<?php
session_start();
include('bd.php');

$requestUri = trim($_SERVER['REQUEST_URI'], '/');
$parts = explode('/', $requestUri);

define('ROOT_URL', strtolower('/' . $parts[0] . '/' . $parts[1] . '/'));

$baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = strtolower($baseDir . '/');

$requestUri = trim($_SERVER['REQUEST_URI'], '/');
$articleIndex = array_search('article', $parts);

if ($articleIndex !== false) {
    $parts = array_slice($parts, $articleIndex);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>styles/style.css">
    <title>Document</title>
</head>
<body>
