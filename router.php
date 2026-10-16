<?php
// Router del servidor embebido de PHP: agrega headers de caché / offline.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;
if ($path === '/' ) { $file = __DIR__ . '/index.html'; }
if (!is_file($file)) { http_response_code(404); exit; }

$types = [
  'html' => 'text/html; charset=utf-8',
  'js' => 'text/javascript; charset=utf-8',
  'webmanifest' => 'application/manifest+json',
  'svg' => 'image/svg+xml',
];
$ext = pathinfo($file, PATHINFO_EXTENSION);
header('Content-Type: ' . ($types[$ext] ?? 'application/octet-stream'));
header('X-Content-Type-Options: nosniff');

if (basename($file) === 'sw.js') {
  // El SW y el shell se revalidan siempre; el SW se encarga del offline.
  header('Cache-Control: no-cache');
  header('Service-Worker-Allowed: /');
} elseif ($ext === 'html') {
  header('Cache-Control: no-cache');
} else {
  header('Cache-Control: public, max-age=86400');
}
readfile($file);
