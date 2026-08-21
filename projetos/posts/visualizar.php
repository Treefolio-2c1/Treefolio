<?php

session_start();
require_once "conexao.php";

$id_post = $_GET['id_post'];

$sql = "SELECT * FROM post WHERE id_post = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post]);

$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("Post não encontrado.");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['legenda']) ?></title>
</head>

<body>

    <h1><?= htmlspecialchars($post['tipo']) ?></h1>
    <p><?= htmlspecialchars($post['legenda']) ?></p>
    <p>Data:<?= htmlspecialchars($post['datapost']) ?></p>
    <p>Arquivo:<a href="uploads/posts/<?= htmlspecialchars($post['arquivo']) ?>" target="_blank">Abrir arquivo</a>
    </p>

    <form action="like.php" method="POST">
    <input type="hidden" name="id_post" value="<?= $post['id_post'] ?>">
    <button type="submit">Curtir</button>
</form>

    <?php if ($post['id_user'] == $_SESSION['id_user']): ?>

        <a href="editar_post.php?id_post=<?= $post['id_post'] ?>">
            Editar post
        </a>

        <form action="excluir_post.php" method="POST">
            <input type="hidden" name="id_post" value="<?= $post['id_post'] ?>">
            <button type="submit">Excluir post</button>
        </form>

    <?php endif; ?>

</body>

</html>