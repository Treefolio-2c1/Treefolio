<?php

require_once __DIR__ . "/../auth/auth.php";
require_once __DIR__ . "/../config/conexao.php";

$sql = "SELECT * from usuario WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['id_user']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$nome = $row['nome'];
$foto = $row['foto'];
$ocu  = $row['ocupacao'];

$sql = "SELECT * from perfil WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['id_user']]);
$row2 = $stmt->fetch(PDO::FETCH_ASSOC);

$bio = $row2['bio'];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil — Treefolio</title>
  <?php include "../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../index.php">
    <img src="../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <a class="btn btn--ghost" href="editar.php">Editar perfil</a>
    <a class="btn btn--primary" href="../auth/logout.php">Sair</a>
  </div>
</nav>

<div class="auth-page">
  <div class="card auth-card card--elevated">

    <div class="auth-header">
      <img src="../uploads/perfil/<?= htmlspecialchars($foto) ?>" alt="Foto de perfil" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin:0 auto 1rem;">
      <h1 class="heading-lg"><?= htmlspecialchars($nome) ?></h1>
      <p class="text-muted mt-1"><?= htmlspecialchars($ocu) ?></p>
    </div>

    <?php if (!empty($bio)): ?>
      <p style="text-align:center;margin-bottom:1.5rem;"><?= htmlspecialchars($bio) ?></p>
    <?php endif; ?>

    <div style="display:flex;gap:.75rem;">
      <a class="btn btn--ghost btn--full" href="curriculo/curriculo.php">Currículo</a>
      <a class="btn btn--primary btn--full" href="../projetos/criar.php">Criar projeto</a>
    </div>

  </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
