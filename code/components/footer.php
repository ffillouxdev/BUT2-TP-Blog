<?php

if (!defined('ROOT_URL')) {
    $requestUri = trim($_SERVER['REQUEST_URI'], '/');
    $parts = explode('/', $requestUri);
    define('ROOT_URL', strtolower('/' . $parts[0] . '/' . $parts[1] . '/'));
}

$baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = strtolower($baseDir . '/');
?>

<footer>
    <img src="<?php echo $baseUrl; ?>assets/footer-icon.png" alt="">
    <div class="footer-sea">
        <p>© BUT2-TP-Blog- All rights reserved</p>
    </div>
</footer>
</body>

</html>
