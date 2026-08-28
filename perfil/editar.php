<?php

require_once __DIR__ . "/../auth/auth.php";
require_once __DIR__ . "/../config/conexao.php";

$id_user = $_SESSION['id_user'];

$sql = "SELECT * FROM usuario WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM perfil WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);
$row2 = $stmt->fetch(PDO::FETCH_ASSOC);

$nome = $row['nome'];
$ocu  = $row['ocupacao'];
$bio  = $row2['bio'];
$foto = $row['foto'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $ocu  = $_POST['ocupacao'];
    $bio  = $_POST['bio'];

    $sql = "UPDATE usuario SET nome = ?, ocupacao = ? WHERE id_user = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $ocu, $id_user]);

    $sql = "UPDATE perfil SET bio = ? WHERE id_user = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bio, $id_user]);

    if (!empty($_FILES['foto']['name'])) {
        $nome_foto = uniqid() . "_" . basename($_FILES['foto']['name']);
        $pasta = "../uploads/perfil/";
        if (!is_dir($pasta)) { mkdir($pasta, 0777, true); }
        move_uploaded_file($_FILES['foto']['tmp_name'], $pasta . $nome_foto);
        $sql = "UPDATE usuario SET foto = ? WHERE id_user = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome_foto, $id_user]);
    }

    header("Location: perfil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar perfil — Treefolio</title>
  <?php include "../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../index.php">
    <img src="../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <a class="btn btn--ghost" href="perfil.php">Voltar</a>
  </div>
</nav>

<div class="auth-page">
  <div class="card auth-card card--elevated">

    <div class="auth-header">
      <h1 class="heading-lg">Editar perfil</h1>
    </div>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label class="form-label">Nome</label>
        <input class="form-input" type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" required>
      </div>
      <div class="form-group">
        <label class="form-label">Ocupação</label>
        <input class="form-input" type="text" name="ocupacao" value="<?= htmlspecialchars($ocu) ?>" required>
      </div>
      <div class="form-group">
        <label class="form-label">Biografia</label>
        <textarea class="form-input" name="bio" rows="4"><?= htmlspecialchars($bio ?? '') ?></textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Foto de perfil</label>
        <input class="form-input" type="file" name="foto" accept="image/*">
      </div>
      <button class="btn btn--primary btn--full btn--lg mt-2" type="submit">Salvar alterações</button>
    </form>

  </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
