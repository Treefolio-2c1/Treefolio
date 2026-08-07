<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email enviado — Treefolio</title>
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
    <h1 class="info-card__title">Cadastro realizado!</h1>
    <p class="info-card__body">Enviamos um link de confirmação para seu e-mail.</p>
    <a class="btn btn--primary btn--lg" href="login.php">Login</a>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
