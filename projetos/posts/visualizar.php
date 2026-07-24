<?php
session_start();

require "../config/conexao.php";

if(!isset($_GET["id"])){
    header("Location: ../index.php");
    exit;
}

$id_post = $_GET["id"];

$sql = "SELECT p.*, u.nome, c.categoria
FROM post p
INNER JOIN usuario u ON p.id_user = u.id_user
INNER JOIN categorias c ON p.id_categoria = c.id_categoria
WHERE p.id_post = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post]);

$post = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$post){
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($post["nome"]) ?> - Post</title>
<?php include "../includes/header.php"; ?>
</head>

<body>

<h1><?= htmlspecialchars($post["nome"]) ?></h1>

<?php if($post["tipo"] == "imagem"): ?>

<img src="../<?= $post["arquivo"] ?>" alt="Post">

<?php elseif($post["tipo"] == "video"): ?>

<video controls>
    <source src="../<?= $post["arquivo"] ?>">
</video>

<?php elseif($post["tipo"] == "audio"): ?>

<audio controls>
    <source src="../<?= $post["arquivo"] ?>">
</audio>

<?php elseif($post["tipo"] == "pdf"): ?>

<iframe src="../<?= $post["arquivo"] ?>" width="100%" height="700"></iframe>

<?php else: ?>

<a href="../<?= $post["arquivo"] ?>">Abrir arquivo</a>

<?php endif; ?>

<h2>Legenda</h2>

<p>
<?= nl2br(htmlspecialchars($post["legenda"])) ?>
</p>

<p>
Categoria: <?= htmlspecialchars($post["categoria"]) ?>
</p>

<p>
Publicado em: <?= $post["datapost"] ?>
</p>

<?php if(isset($_SESSION["id_user"]) && $_SESSION["id_user"] == $post["id_user"]): ?>

<form action="excluir.php" method="POST">
<input type="hidden" name="id_post" value="<?= $post["id_post"] ?>">
<button type="submit" onclick="return confirm('Tem certeza que deseja excluir este post?')">
Excluir
</button>
</form>

<?php endif; ?>

<h2>Comentários</h2>

<?php if(isset($_SESSION["id_user"])): ?>

<form action="comentar.php" method="POST">

<input type="hidden" name="id_post" value="<?= $post["id_post"] ?>">

<textarea name="comentario" placeholder="Escreva um comentário..." required></textarea>

<button type="submit">
Comentar
</button>

</form>

<?php else: ?>

<p>Faça login para comentar.</p>

<?php endif; ?>


<?php

$sql = "SELECT c.*, u.nome
FROM comentarios c
INNER JOIN usuario u ON c.id_user = u.id_user
WHERE c.id_post = ?
ORDER BY datacomentario DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post]);

while($comentario = $stmt->fetch(PDO::FETCH_ASSOC)){
?>

<div class="comentario">

<strong>
<?= htmlspecialchars($comentario["nome"]) ?>
</strong>

<p>
<?= nl2br(htmlspecialchars($comentario["comentario"])) ?>
</p>

<small>
<?= $comentario["datacomentario"] ?>
</small>

</div>

<?php } ?>

<?php include "../includes/footer.php"; ?>

</body>
</html>