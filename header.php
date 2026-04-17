<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Mini E-commerce</title>
</head>
<body>
<?php
require_once __DIR__ . '/app/bootstrap.php';

use App\Support\Auth;

Auth::start();
$isLoggedIn = Auth::check();
$current = basename($_SERVER['PHP_SELF'] ?? '');
$publicPages = ['index.php', 'login.php'];
if (!$isLoggedIn && !in_array($current, $publicPages, true)) {
    header('Location: index.php');
    exit;
}
?>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="<?= $isLoggedIn ? 'dashboard.php' : 'index.php' ?>">Mini E-commerce</a>
            <div class="header-actions">
                <?php if ($isLoggedIn) { ?>
                    <nav class="nav">
                        <a class="nav-link" href="product-form.php">Cadastrar produto</a>
                        <a class="nav-link" href="product-list.php">Produtos</a>
                        <a class="nav-link" href="order-list.php">Pedidos</a>
                        <a class="nav-link" href="logout.php">Sair</a>
                    </nav>
                <?php } ?>
                <button type="button" class="btn btn-secondary theme-toggle" data-theme-toggle aria-pressed="false">
                    Tema: claro
                </button>
            </div>
        </div>
    </header>