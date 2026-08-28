<?php

require_once __DIR__ . "/../../auth/auth.php";
require_once __DIR__ . "/../../config/conexao.php";

$id_user = $_SESSION['id_user'];

// Busca os projetos do usuário para o select
$sql = "SELECT id_projeto, titulo FROM projetos WHERE id_user = ? ORDER BY dataproj DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);
$meus_projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// id_projeto pode vir pela URL (botão "Criar post" do visualizar) ou pelo form
$id_projeto_url = $_GET['id_projeto'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $legenda    = $_POST['legenda'];
    $tipo       = $_POST['tipo'];
    $id_projeto = $_POST['id_projeto'] ?: null;

    $tmp_capa     = $_FILES['capa']['tmp_name'];
    $nome_capa    = uniqid() . "_" . basename($_FILES['capa']['name']);
    $tmp_arquivo  = $_FILES['arquivo']['tmp_name'];
    $nome_arquivo = uniqid() . "_" . basename($_FILES['arquivo']['name']);

    $pasta = "../../uploads/posts/";
    if (!is_dir($pasta)) { mkdir($pasta, 0777, true); }

    move_uploaded_file($tmp_capa, $pasta . $nome_capa);
    move_uploaded_file($tmp_arquivo, $pasta . $nome_arquivo);

    $sql = "INSERT INTO post (id_user, id_projeto, arquivo, capa, legenda, tipo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_user, $id_projeto, $nome_arquivo, $nome_capa, $legenda, $tipo]);

    $id_post = $pdo->lastInsertId();

    if ($id_projeto) {
        header("Location: ../../projetos/visualizar.php?id_projeto=" . $id_projeto);
    } else {
        header("Location: visualizar.php?id_post=" . $id_post);
    }
    exit;
}

$css_path = '../../';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar post — Treefolio</title>
  <?php include "../../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../../index.php">
    <img src="../../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <a class="btn btn--ghost" href="javascript:history.back()">Voltar</a>
  </div>
</nav>

<div class="auth-page">
  <div class="card auth-card card--elevated">

    <div class="auth-header">
      <h1 class="heading-lg">Criar post</h1>
    </div>

    <form method="POST" enctype="multipart/form-data">

      <div class="form-group">
        <label class="form-label">Projeto</label>
        <select class="form-input" name="id_projeto">
          <option value="">— Sem projeto —</option>
          <?php foreach ($meus_projetos as $proj): ?>
            <option value="<?= $proj['id_projeto'] ?>"
              <?= ($id_projeto_url == $proj['id_projeto']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($proj['titulo']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Legenda</label>
        <input class="form-input" type="text" name="legenda" placeholder="Esse post é sobre..." required>
      </div>

      <div class="form-group">
        <label class="form-label">Tipo de Post</label>
        <input class="form-input" type="text" name="tipo" placeholder="Ex: Arquitetura" required>
      </div>

      <div class="form-group">
        <label class="form-label">Capa do Post</label>
        <input class="form-input" type="file" name="capa" accept="image/*" required>
      </div>

      <div class="form-group">
        <label class="form-label">Arquivo do Post</label>
        <input class="form-input" type="file" name="arquivo" required>
      </div>

      <button class="btn btn--primary btn--full btn--lg mt-2" type="submit">Criar post</button>

    </form>

  </div>
</div>

<?php include "../../includes/footer.php"; ?>
</body>
</html>
