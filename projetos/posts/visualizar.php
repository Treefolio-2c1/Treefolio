<?php
session_start();
require_once __DIR__ . "/../../config/conexao.php";

$id_post = $_GET['id_post'];

$sql = "SELECT * FROM post WHERE id_post = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) { die("Post não encontrado."); }

$sql = "SELECT comentarios.*, usuario.nome
        FROM comentarios
        INNER JOIN usuario ON comentarios.id_user = usuario.id_user
        WHERE comentarios.id_post = ?
        ORDER BY comentarios.datacomentario DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post]);
$comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$css_path = '../../';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($post['legenda']) ?> — Treefolio</title>
  <?php include "../../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../../index.php">
    <img src="../../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <?php if (isset($_SESSION['id_user']) && $post['id_user'] == $_SESSION['id_user']): ?>
      <a class="btn btn--ghost" href="editar.php?id_post=<?= $post['id_post'] ?>">Editar</a>
    <?php endif; ?>
  </div>
</nav>

<div class="auth-page" style="align-items:flex-start;">
  <div class="card card--elevated" style="width:100%;max-width:640px;padding:2rem;">

    <h1 class="heading-lg"><?= htmlspecialchars($post['tipo']) ?></h1>
    <p class="text-muted mt-1"><?= htmlspecialchars($post['legenda']) ?></p>
    <p class="text-muted">📅 <?= htmlspecialchars($post['datapost']) ?></p>

    <div style="margin:1rem 0;">
      <a class="btn btn--ghost" href="../../uploads/posts/<?= htmlspecialchars($post['arquivo']) ?>" target="_blank">📎 Abrir arquivo</a>
    </div>

    <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
      <form action="like.php" method="POST">
        <input type="hidden" name="id_post" value="<?= $post['id_post'] ?>">
        <button class="btn btn--ghost" type="submit">❤️ Curtir</button>
      </form>

      <?php if (isset($_SESSION['id_user']) && $post['id_user'] == $_SESSION['id_user']): ?>
        <form action="excluir.php" method="POST" onsubmit="return confirm('Tem certeza?')">
          <input type="hidden" name="id_post" value="<?= $post['id_post'] ?>">
          <button class="btn btn--ghost" type="submit">🗑 Excluir post</button>
        </form>
      <?php endif; ?>
    </div>

    <hr style="border:none;border-top:1px solid var(--color-border);margin-bottom:1.5rem;">

    <h2 style="font-family:var(--font-display);font-size:1.1rem;font-weight:800;margin-bottom:1rem;">Comentários</h2>

    <form action="comentarios/comentar.php" method="POST" style="margin-bottom:1.5rem;">
      <input type="hidden" name="id_post" value="<?= $post['id_post'] ?>">
      <div class="form-group">
        <textarea class="form-input" name="comentario" placeholder="Escreva um comentário..." rows="3" required></textarea>
      </div>
      <button class="btn btn--primary btn--full" type="submit">Comentar</button>
    </form>

    <?php foreach ($comentarios as $comentario): ?>
      <div class="card" style="margin-bottom:.75rem;padding:1rem;">
        <strong><?= htmlspecialchars($comentario['nome']) ?></strong>
        <p style="margin:.25rem 0;"><?= htmlspecialchars($comentario['comentario']) ?></p>
        <small class="text-muted"><?= htmlspecialchars($comentario['datacomentario']) ?></small>
        <?php if (isset($_SESSION['id_user']) && $comentario['id_user'] == $_SESSION['id_user']): ?>
          <form action="comentarios/excluir.php" method="POST" style="margin-top:.5rem;">
            <input type="hidden" name="id_comentario" value="<?= $comentario['id_comentario'] ?>">
            <input type="hidden" name="id_post" value="<?= $post['id_post'] ?>">
            <button class="btn btn--ghost" type="submit" style="font-size:.8rem;padding:.3rem .75rem;">Excluir</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>

  </div>
</div>

<?php include "../../includes/footer.php"; ?>
</body>
</html>
