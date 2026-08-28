<?php

require_once __DIR__ . "/../auth/auth.php";
require_once __DIR__ . "/../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_user  = $_SESSION["id_user"];
    $titulo   = $_POST["nome"];
    $descricao = $_POST["descr"];
    $categoria = $_POST["tipo"];

    $capa_nome = $_FILES["capa"]["name"];
    $tmp       = $_FILES["capa"]["tmp_name"];
    $capa      = uniqid() . "_" . basename($capa_nome);
    $pasta     = "../uploads/projetos/";

    if (!is_dir($pasta)) { mkdir($pasta, 0777, true); }

    move_uploaded_file($tmp, $pasta . $capa);

    $sql = "INSERT INTO projetos (id_user, titulo, descricao, categoria, capa) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_user, $titulo, $descricao, $categoria, $capa]);

    header("Location: visualizar.php?id_projeto=" . $pdo->lastInsertId());
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar projeto — Treefolio</title>
  <?php include "../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../index.php">
    <img src="../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <a class="btn btn--ghost" href="../perfil/perfil.php">Voltar</a>
  </div>
</nav>

<div class="auth-page">
  <div class="card auth-card card--elevated">

    <div class="auth-header">
      <h1 class="heading-lg">Criar projeto</h1>
    </div>

    <form method="POST" action="" enctype="multipart/form-data">
      <div class="form-group">
        <label class="form-label">Nome do Projeto</label>
        <input class="form-input" type="text" name="nome" placeholder="Projeto Treefolio" required>
      </div>
      <div class="form-group">
        <label class="form-label">Descrição do Projeto</label>
        <textarea class="form-input" name="descr" placeholder="Esse projeto é sobre..." rows="4" required></textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Tipo de Projeto</label>
        <input class="form-input" type="text" name="tipo" placeholder="Arquitetura" required>
      </div>
      <div class="form-group">
        <label class="form-label">Capa do Projeto</label>
        <input class="form-input" type="file" name="capa" accept="image/*" required>
      </div>
      <button class="btn btn--primary btn--full btn--lg mt-2" type="submit">Criar projeto</button>
    </form>

  </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
