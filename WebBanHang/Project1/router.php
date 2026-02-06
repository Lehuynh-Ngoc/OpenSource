<?php
// router.php for PHP built-in server

$uri = $_SERVER["REQUEST_URI"];
$path = parse_url($uri, PHP_URL_PATH);

// Handle the hardcoded /Project1/ prefix
if (strpos($path, '/Project1/') === 0) {
    $path = substr($path, strlen('/Project1')); // Strip '/Project1'
    // If path becomes empty or just slash, keep it as slash
    if ($path === '') $path = '/';
}

$ext = pathinfo($path, PATHINFO_EXTENSION);

// Serve static files directly if they exist
// We check __DIR__ . $path because we are running from Project1 root
if (file_exists(__DIR__ . $path) && $path !== '/' && $ext !== 'php') {
    // PHP built-in server handles static files if we return false, 
    // BUT we modified the path (stripped prefix), so we can't just return false 
    // because the browser requested /Project1/foo.jpg, but the file is at /foo.jpg.
    // The server thinks the file is at /Project1/foo.jpg which doesn't exist.
    
    // We must serve the file content manually for the stripped path
    $mime_types = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
    ];
    
    $mime = $mime_types[$ext] ?? 'application/octet-stream';
    header("Content-Type: $mime");
    readfile(__DIR__ . $path);
    return true; 
}

// Redirect everything else to index.php
// We set the 'url' parameter to the path (minus leading slash)
$_GET['url'] = ltrim($path, '/');

// Include index.php. It will use the $_GET['url'] we just set.
require 'index.php';