<?php
declare(strict_types=1);

// Backward-compat shim: older pages include `conexao.php`.
// The real connection lives in `database.php` and exposes `$pdo`.
require __DIR__ . '/database.php';

