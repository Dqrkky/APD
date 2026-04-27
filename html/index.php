<?php
require_once "components.php";

$route = $_GET['route'] ?? '/';

function nav() {
    return '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="?route=/">MiniReact PHP</a>
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="?route=/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?route=/about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?route=/video">Video</a>
          </li>
        </ul>
      </div>
    </nav>';
};

function jsonc_decode_safe($jsonc, $assoc = true) {
    $in_string = false;
    $in_single_comment = false;
    $in_multi_comment = false;
    $result = '';
    $len = strlen($jsonc);

    for ($i = 0; $i < $len; $i++) {
        $char = $jsonc[$i];
        $next = $i + 1 < $len ? $jsonc[$i + 1] : '';

        if ($in_single_comment) {
            if ($char === "\n") {
                $in_single_comment = false;
                $result .= $char;
            }
            continue;
        }

        if ($in_multi_comment) {
            if ($char === '*' && $next === '/') {
                $in_multi_comment = false;
                $i++;
            }
            continue;
        }

        if (!$in_string) {
            if ($char === '/' && $next === '/') {
                $in_single_comment = true;
                $i++;
                continue;
            }

            if ($char === '/' && $next === '*') {
                $in_multi_comment = true;
                $i++;
                continue;
            }
        }

        if ($char === '"' && ($i === 0 || $jsonc[$i - 1] !== '\\')) {
            $in_string = !$in_string;
        }

        $result .= $char;
    }

    return json_decode($result, $assoc);
}

function renderRoute($route) {
    switch ($route) {
        case '/':
            return Home();
        case '/about':
            return About();
        case '/video':
            return VideoPage();
        case '/person/alice': // Example of application/ld+json for a Person schema
            return application_ld_json(jsonc_decode_safe(file_get_contents('alice.jsonc'), true));
        default:
            return application_ld_json([
                'error' => 'Route not found',
                'errorType' => 'RouteNotFoundError',
                'status' => 404,
                'route' => $route,
                'timestamp' => time(),
                'suggestions' => [
                  'Check the URL for typos',
                  'Refer to the documentation for valid routes'
                ]
            ]);
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>MiniReact PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?= nav(); ?>
    <div class="container mt-4">
      <?= renderRoute($route); ?>
    </div>
  </body>
</html>