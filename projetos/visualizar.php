<?php

session_start();
require_once "conexao.php";

$id_projeto = $_GET['id_projeto'];

$sql = "SELECT * FROM projetos WHERE id_projeto = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_projeto]);

$projeto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$projeto) {
    die("Projeto não encontrado.");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($projeto['titulo']) ?></title>
</head>

<body>

    <h1><?= htmlspecialchars($projeto['titulo']) ?></h1>
    <p><?= htmlspecialchars($projeto['descricao']) ?></p>
    <p>Categoria: <?= htmlspecialchars($projeto['categoria']) ?></p>


    <form action="like.php" method="POST">
    <input type="hidden" name="id_projeto" value="<?= $projeto['id_projeto'] ?>">
    <button type="submit">❤️ Curtir</button>
    </form>

    <?php if (!empty($projeto['capa'])): ?>
        <img src="uploads/projetos/<?= htmlspecialchars($projeto['capa']) ?>" alt="Capa do projeto" width="500">
    <?php endif; ?>

    <?php if ($projeto['id_user'] == $_SESSION['id_user']): ?>

        <form action="excluir.php" method="POST">
            <input type="hidden" name="id_projeto" value="<?= $projeto['id_projeto'] ?>">
            <button type="submit">Excluir projeto</button>
        </form>

    <?php endif; ?>

</body>

</html>