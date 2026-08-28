<?php

session_start();
require_once __DIR__ . "/../config/conexao.php";

$id_projeto = $_GET['id_projeto'];

$sql = "SELECT * FROM projetos WHERE id_projeto = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_projeto]);
$projeto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$projeto) { die("Projeto não encontrado."); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($projeto['titulo']) ?> — Treefolio</title>
  <?php include "../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../index.php">
    <img src="../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <?php if (isset($_SESSION['id_user']) && $projeto['id_user'] == $_SESSION['id_user']): ?>
      <a class="btn btn--ghost" href="editar.php?id_projeto=<?= $projeto['id_projeto'] ?>">Editar</a>
    <?php endif; ?>
    <a class="btn btn--primary" href="../perfil/perfil.php">Meu perfil</a>
  </div>
</nav>

<div class="auth-page" style="align-items:flex-start;">
  <div class="card card--elevated" style="width:100%;max-width:640px;padding:2rem;">

    <h1 class="heading-lg"><?= htmlspecialchars($projeto['titulo']) ?></h1>
    <p class="text-muted mt-1"><?= htmlspecialchars($projeto['categoria']) ?></p>

    <?php if (!empty($projeto['capa'])): ?>
      <img src="../uploads/projetos/<?= htmlspecialchars($projeto['capa']) ?>" alt="Capa do projeto" style="width:100%;border-radius:var(--radius-md);margin:1rem 0;">
    <?php endif; ?>

    <p style="margin-bottom:1.5rem;"><?= htmlspecialchars($projeto['descricao']) ?></p>

    <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
      <form action="like.php" method="POST">
        <input type="hidden" name="id_projeto" value="<?= $projeto['id_projeto'] ?>">
        <button class="btn btn--ghost" type="submit">❤️ Curtir</button>
      </form>

      <a class="btn btn--primary" href="posts/criar.php?id_projeto=<?= $projeto['id_projeto'] ?>">Criar post</a>

      <?php if (isset($_SESSION['id_user']) && $projeto['id_user'] == $_SESSION['id_user']): ?>
        <form action="excluir.php" method="POST" onsubmit="return confirm('Tem certeza?')">
          <input type="hidden" name="id_projeto" value="<?= $projeto['id_projeto'] ?>">
          <button class="btn btn--ghost" type="submit">🗑 Excluir</button>
        </form>
      <?php endif; ?>
    </div>

  </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
