<?php
require_once "components.php";

$route = $_GET['route'] ?? '/';

function nav() {
    return '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="?route=/">MiniReact PHP</a>
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="?route=/">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="?route=/about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="?route=/video">Video</a></li>
        </ul>
      </div>
    </nav>';
}

function renderRoute($route) {
    switch ($route) {
        case '/':
            return Home();
        case '/about':
            return About();
        case '/video':
            return VideoPage();
        default:
            return "<h2>404</h2>";
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