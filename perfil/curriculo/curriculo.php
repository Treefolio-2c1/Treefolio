<?php

require_once __DIR__ . "/../../auth/auth.php";
require_once __DIR__ . "/../../config/conexao.php";

$id_user = $_SESSION['id_user'];

$sql = "SELECT * FROM usuario WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM curriculo WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);
$curriculo = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM projetos WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);
$projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$css_path = '../../';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Currículo — Treefolio</title>
  <?php include "../../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../../index.php">
    <img src="../../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <a class="btn btn--ghost" href="../perfil.php">Voltar ao perfil</a>
    <a class="btn btn--primary" href="editar.php">Editar currículo</a>
  </div>
</nav>

<div class="auth-page" style="align-items:flex-start;">
  <div class="card card--elevated" style="width:100%;max-width:640px;padding:2rem;">

    <div class="auth-header">
      <h1 class="heading-lg"><?= htmlspecialchars($usuario['nome']) ?></h1>
      <p class="text-muted mt-1"><?= htmlspecialchars($usuario['ocupacao']) ?></p>
      <p class="text-muted"> <?= htmlspecialchars($usuario['email']) ?> &nbsp;|&nbsp; <?= htmlspecialchars($usuario['fone']) ?></p>
    </div>

    <?php
    $secoes = [
      'formacao'    => 'Formação',
      'experiencia' => 'Experiência',
      'habilidades' => 'Habilidades',
      'cursos'      => 'Cursos',
      'idiomas'     => 'Idiomas',
    ];
    foreach ($secoes as $campo => $label):
    ?>
      <div style="margin-bottom:1.25rem;">
        <h2 style="font-family:var(--font-display);font-size:1rem;font-weight:800;color:var(--color-accent-dk);margin-bottom:.35rem;"><?= $label ?></h2>
        <p><?= !empty($curriculo[$campo]) ? htmlspecialchars($curriculo[$campo]) : '<span style="color:var(--color-text-muted)">Não informado.</span>' ?></p>
      </div>
    <?php endforeach; ?>

    <div style="margin-top:1.25rem;">
      <h2 style="font-family:var(--font-display);font-size:1rem;font-weight:800;color:var(--color-accent-dk);margin-bottom:.75rem;">Projetos</h2>
      <?php if (count($projetos) > 0): ?>
        <?php foreach ($projetos as $projeto): ?>
          <div class="card" style="margin-bottom:.75rem;padding:1rem;">
            <strong><?= htmlspecialchars($projeto['titulo']) ?></strong>
            <p class="text-muted"><?= htmlspecialchars($projeto['categoria']) ?></p>
            <p style="margin-top:.25rem;"><?= htmlspecialchars($projeto['descricao']) ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-muted">Nenhum projeto cadastrado.</p>
      <?php endif; ?>
    </div>

  </div>
</div>

<?php include "../../includes/footer.php"; ?>
</body>
</html>
