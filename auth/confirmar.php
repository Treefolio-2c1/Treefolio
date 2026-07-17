<?php

require_once __DIR__ . "/../config/conexao.php";

if (!isset($_GET["token"])) {
    die("Token inválido.");
}

$token = $_GET["token"];


$sql = "SELECT id_user, ativo
        FROM usuario
        WHERE token = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$token]);

$usuario = $stmt->fetch();

if (!$usuario) {
    die("Link inválido ou expirado.");
}

// Ativa a conta e remove o token
$sql = "UPDATE usuario
        SET ativo = 1,
            token = NULL
        WHERE id_user = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario["id_user"]]);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Conta confirmada</title>
</head>
<body>

<h1>Conta confirmada!</h1>

<p>Sua conta foi ativada com sucesso.</p>

<a href="login.php">
    Ir para o login
</a>

</body>
</html>