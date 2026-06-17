<?php
$dsn = "mysql:host=localhost;dbname=treefolio;charset=utf8";
$usuario = "root";
$senha = "";

//conexão
try {
    $pdo = new PDO($dsn, $usuario, $senha);
} catch (PDOException $e)  {
    die("Erro ao conectar: " . $e->getMessage());
}
?>