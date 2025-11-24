<?php
$host = "localhost";
$port = "5432";
$dbname = "precodeplus";
$user = "postgres";
$password = "1040";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;", $user, $password);

    // Habilita erros do PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Faz com que os fetch() venham como array associativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // echo "Conectado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao conectar: " . $e->getMessage();
}

