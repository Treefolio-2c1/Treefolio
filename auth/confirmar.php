<?php

require_once __DIR__ . "/../config/conexao.php";

if (!isset($_GET["token"])) {
    die("Token inválido.");
}

$token = $_GET["token"];

$sql = "SELECT id_user, status_email
        FROM usuario
        WHERE token = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$token]);

$usuario = $stmt->fetch();

if (!$usuario) {
    die("Link inválido ou expirado.");
}

$sql = "UPDATE usuario
        SET status_email = 'ativo',
            token = NULL
        WHERE id_user = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario["id_user"]]);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conta confirmada — Treefolio</title>
  <?php include "../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../index.php">
    <img src="../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
</nav>

<div class="info-page">
  <div class="card info-card card--elevated">
    <h1 class="info-card__title">Conta confirmada!</h1>
    <p class="info-card__body">conta ativada com sucesso.</p>
    <a class="btn btn--primary btn--lg" href="login.php">Ir para o login</a>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
