<?php

require_once __DIR__ . "/../../auth/auth.php";
require_once __DIR__ . "/../../config/conexao.php";

$id_user = $_SESSION['id_user'];

$sql = "SELECT * FROM curriculo WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);
$curriculo = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $formacao    = $_POST['formacao'];
    $experiencia = $_POST['experiencia'];
    $habilidades = $_POST['habilidades'];
    $cursos      = $_POST['cursos'];
    $idiomas     = $_POST['idiomas'];

    if ($curriculo) {
        $sql = "UPDATE curriculo SET formacao = ?, experiencia = ?, habilidades = ?, cursos = ?, idiomas = ? WHERE id_user = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$formacao, $experiencia, $habilidades, $cursos, $idiomas, $id_user]);
    } else {
        $sql = "INSERT INTO curriculo (id_user, formacao, experiencia, habilidades, cursos, idiomas) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_user, $formacao, $experiencia, $habilidades, $cursos, $idiomas]);
    }

    header("Location: curriculo.php");
    exit;
}

$css_path = '../../';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar currículo — Treefolio</title>
  <?php include "../../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../../index.php">
    <img src="../../Static/img/newlogo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <a class="btn btn--ghost" href="curriculo.php">Voltar</a>
  </div>
</nav>

<div class="auth-page">
  <div class="card auth-card card--elevated">

    <div class="auth-header">
      <h1 class="heading-lg">Editar currículo</h1>
    </div>

    <form method="POST">
      <?php
      $campos = [
        'formacao'    => ['Formação', 'Ex: Técnico em Desenvolvimento de Sistemas'],
        'experiencia' => ['Experiência', 'Descreva suas experiências'],
        'habilidades' => ['Habilidades', 'Ex: HTML, CSS, PHP, MySQL'],
        'cursos'      => ['Cursos', 'Cursos realizados'],
        'idiomas'     => ['Idiomas', 'Ex: Português, Inglês'],
      ];
      foreach ($campos as $name => [$label, $placeholder]):
      ?>
        <div class="form-group">
          <label class="form-label"><?= $label ?></label>
          <textarea class="form-input" name="<?= $name ?>" placeholder="<?= $placeholder ?>" rows="3"><?= htmlspecialchars($curriculo[$name] ?? '') ?></textarea>
        </div>
      <?php endforeach; ?>
      <button class="btn btn--primary btn--full btn--lg mt-2" type="submit">Salvar currículo</button>
    </form>

  </div>
</div>

<?php include "../../includes/footer.php"; ?>
</body>
</html>
