<?php

require_once __DIR__ . "/../../config/conexao.php";
session_start();

$id_user = $_SESSION['id_user'];

$sql = "SELECT * FROM usuario WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM curriculo WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);

$curriculo = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM projetos WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);

$projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículo</title>
</head>

<body>

    <h1><?= htmlspecialchars($usuario['nome']) ?></h1>
    <p><?= htmlspecialchars($usuario['ocupacao']) ?></p>
    <p>Email: <?= htmlspecialchars($usuario['email']) ?></p>
    <p>Telefone: <?= htmlspecialchars($usuario['fone']) ?></p>

    <h2>Formação</h2>
    <p><?= !empty($curriculo['formacao']) ? htmlspecialchars($curriculo['formacao']) : "Não informado." ?></p>

    <h2>Experiência</h2>
    <p><?= !empty($curriculo['experiencia']) ? htmlspecialchars($curriculo['experiencia']) : "Não informado." ?></p>

    <h2>Habilidades</h2>
    <p><?= !empty($curriculo['habilidades']) ? htmlspecialchars($curriculo['habilidades']) : "Não informado." ?></p>

    <h2>Cursos</h2>
    <p><?= !empty($curriculo['cursos']) ? htmlspecialchars($curriculo['cursos']) : "Não informado." ?></p>

    <h2>Idiomas</h2>
    <p><?= !empty($curriculo['idiomas']) ? htmlspecialchars($curriculo['idiomas']) : "Não informado." ?></p>

    <h2>Projetos</h2>

    <?php if (count($projetos) > 0): ?>

        <?php foreach ($projetos as $projeto): ?>

            <div>
                <h3><?= htmlspecialchars($projeto['titulo']) ?></h3>
                <p><?= htmlspecialchars($projeto['descricao']) ?></p>
                <p>Categoria: <?= htmlspecialchars($projeto['categoria']) ?></p>
            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p>Nenhum projeto cadastrado.</p>

    <?php endif; ?>

    <br>

    <a href="editar.php"><button type="button">Editar currículo</button></a>

    <a href="editar.php"><button type="button">Editar currículo</button></a>


</body>

</html>