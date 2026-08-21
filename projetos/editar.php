<?php

session_start();
require_once "conexao.php";

$id_projeto = $_GET['id_projeto'];
$id_user = $_SESSION['id_user'];

$sql = "SELECT * FROM projetos
        WHERE id_projeto = ?
        AND id_user = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $id_projeto,
    $id_user
]);

$projeto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$projeto) {
    die("Projeto não encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = $_POST['nome'];
    $descricao = $_POST['descr'];
    $categoria = $_POST['tipo'];

    $sql = "UPDATE projetos
            SET titulo = ?,
                descricao = ?,
                categoria = ?
            WHERE id_projeto = ?
            AND id_user = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $titulo,
        $descricao,
        $categoria,
        $id_projeto,
        $id_user
    ]);

    header("Location: visualizar.php?id_projeto=" . $id_projeto);
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar projeto</title>
</head>

<body>

    <h1>Editar projeto</h1>

    <form method="POST">
        <label>Nome do Projeto</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($projeto['titulo']) ?>" required>
        <br><br>
        <label>Descrição do Projeto</label>
        <textarea name="descr" required><?= htmlspecialchars($projeto['descricao']) ?></textarea>
        <br><br>
        <label>Tipo de Projeto</label>
        <input type="text" name="tipo" value="<?= htmlspecialchars($projeto['categoria']) ?>" required>
        <br><br>
        <button type="submit">Salvar alterações</button>
    </form>

</body>

</html>