<?php

require_once __DIR__ . "/../../auth/auth.php";
require_once __DIR__ . "/../../config/conexao.php";

$id_post = $_GET['id_post'];
$id_user = $_SESSION['id_user'];

$sql = "SELECT * FROM post WHERE id_post = ? AND id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post, $id_user]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) { die("Post não encontrado."); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $legenda = $_POST['legenda'];
    $tipo    = $_POST['tipo'];

    $sql = "UPDATE post SET legenda = ?, tipo = ? WHERE id_post = ? AND id_user = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$legenda, $tipo, $id_post, $id_user]);

    header("Location: visualizar.php?id_post=" . $id_post);
    exit;
}

$css_path = '../../';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar post — Treefolio</title>
  <?php include "../../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../../index.php">
    <img src="../../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <a class="btn btn--ghost" href="visualizar.php?id_post=<?= $id_post ?>">Voltar</a>
  </div>
</nav>

<div class="auth-page">
  <div class="card auth-card card--elevated">

    <div class="auth-header">
      <h1 class="heading-lg">Editar post</h1>
    </div>

    <form method="POST">
      <div class="form-group">
        <label class="form-label">Legenda</label>
        <input class="form-input" type="text" name="legenda" value="<?= htmlspecialchars($post['legenda']) ?>" required>
      </div>
      <div class="form-group">
        <label class="form-label">Tipo de Post</label>
        <input class="form-input" type="text" name="tipo" value="<?= htmlspecialchars($post['tipo']) ?>" required>
      </div>
      <button class="btn btn--primary btn--full btn--lg mt-2" type="submit">Salvar alterações</button>
    </form>

  </div>
</div>

<?php include "../../includes/footer.php"; ?>
</body>
</html>
