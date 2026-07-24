<?php
session_start();

require "../config/conexao.php";

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$id_projeto = $_GET['id'];

$sql = "SELECT p.*, u.nome
FROM projetos p
INNER JOIN usuario u ON p.id_user = u.id_user
WHERE p.id_projeto = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_projeto]);

$projeto = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$projeto){
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($projeto['titulo']) ?></title>

<?php include "../includes/header.php"; ?>

</head>

<body>

<h1><?= htmlspecialchars($projeto['titulo']) ?></h1>

<img src="../<?= $projeto['capa'] ?>" alt="Capa">

<p><?= nl2br(htmlspecialchars($projeto['descricao'])) ?></p>

<p>Criado por: <?= htmlspecialchars($projeto['nome']) ?></p>

<p>Categoria: <?= htmlspecialchars($projeto['categoria']) ?></p>

<!-- botao de criar post

<?php if(isset($_SESSION['id_user']) && $projeto['id_user'] == $_SESSION['id_user']): ?>

<a href="../posts/criar.php?id=<?= $projeto['id_projeto'] ?>" class="btn btn--primary">
Novo Post
</a>

<?php endif; ?>

-->

<?php include "../includes/footer.php"; ?>

</body>
</html>