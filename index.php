<?php
session_start();

require "config/conexao.php";

$sql = "SELECT * FROM projetos ORDER BY dataproj DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$css_path = '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Treefolio</title>

<?php include "includes/header.php"; ?>

</head>

<body>

<nav class="navbar">

<a class="navbar__logo" href="index.php">

<img class="hero__logo" src="Static/img/newlogo.svg">

<span class="navbar__logo-text">
tree<span>folio</span>
</span>

</a>

<div class="navbar__actions">

<a class="btn btn--ghost" href="auth/login.php">
Entrar
</a>

<a class="btn btn--primary" href="auth/cadastro.php">
Cadastrar
</a>

</div>

</nav>

<main class="hero">

<img class="hero__logo" src="Static/img/newlogo.svg">

<h1 class="hero__title">
slogan,<br>
<span>slogan</span>
</h1>

<p class="hero__subtitle">
elaborar paragrafo
</p>

<div class="hero__actions">

<a class="btn btn--primary btn--lg" href="auth/cadastro.php">
Criar conta
</a>

<a class="btn btn--ghost btn--lg" href="auth/login.php">
Login
</a>

</div>

</main>


<!-- Exibir projetos

<?php foreach($projetos as $projeto): ?>

<div class="projeto-card">

<img src="<?= $projeto['capa'] ?>" alt="Capa">

<h2>
<?= htmlspecialchars($projeto['titulo']) ?>
</h2>

<p>
<?= htmlspecialchars($projeto['descricao']) ?>
</p>

<a href="projetos/visualizar.php?id=<?= $projeto['id_projeto'] ?>">
Ver projeto
</a>

<?php if(isset($_SESSION['id_user']) && $projeto['id_user'] == $_SESSION['id_user']): ?>

<a href="projetos/editar.php?id=<?= $projeto['id_projeto'] ?>">
Editar
</a>

<a href="projetos/excluir.php?id=<?= $projeto['id_projeto'] ?>"
onclick="return confirm('Tem certeza que deseja excluir?')">
Excluir
</a>

<?php endif; ?>

</div>

<?php endforeach; ?>

-->


<!-- Botão criar projeto

<?php if(isset($_SESSION['id_user'])): ?>

<a href="projetos/criar.php" class="btn btn--primary">
Criar projeto
</a>

<?php endif; ?>

-->


<?php include "includes/footer.php"; ?>

</body>
</html>