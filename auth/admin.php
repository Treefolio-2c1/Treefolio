<?php

require_once __DIR__ . "/auth.php";
require_once __DIR__ . "/../config/conexao.php";

if ((int)($_SESSION["adm"] ?? 0) !== 1) {
    header("Location: ../index.php");
    exit;
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $acao = $_POST["acao"];

    if ($acao == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_user = ?");
        $stmt->execute([$id]);
        $mensagem = "Usuário excluído!";
    }
    if ($acao == 'ativar') {
        $stmt = $pdo->prepare("UPDATE usuario SET status = 'ativo' WHERE id_user = ?");
        $stmt->execute([$id]);
        $mensagem = "Usuário ativado!";
    }
    if ($acao == 'desativar') {
        $stmt = $pdo->prepare("UPDATE usuario SET status = 'inativo' WHERE id_user = ?");
        $stmt->execute([$id]);
        $mensagem = "Usuário desativado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — Treefolio</title>
  <?php include "../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../index.php">
    <img src="../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <a class="btn btn--ghost" href="../index.php">Voltar</a>
    <a class="btn btn--primary" href="logout.php">Sair</a>
  </div>
</nav>

<div class="auth-page">
  <div class="card auth-card card--elevated">

    <div class="auth-header">
      <h1 class="heading-lg">Painel Admin</h1>
    </div>

    <?php if (!empty($mensagem)): ?>
      <div class="alert alert--error mb-2">✅ <?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label class="form-label">ID do usuário</label>
        <input class="form-input" type="number" name="id" placeholder="ID do usuário" required>
      </div>
      <div style="display:flex;gap:.75rem;margin-top:1rem;">
        <button class="btn btn--ghost btn--full" type="submit" name="acao" value="ativar">Ativar</button>
        <button class="btn btn--ghost btn--full" type="submit" name="acao" value="desativar">Desativar</button>
        <button class="btn btn--primary btn--full" type="submit" name="acao" value="delete" onclick="return confirm('Tem certeza?')">Excluir</button>
      </div>
    </form>

  </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
