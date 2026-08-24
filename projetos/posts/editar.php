<?php

require_once __DIR__ . "/../../auth/auth.php";
require_once __DIR__ . "/../../config/conexao.php";

$id_post = $_GET['id_post'];
$id_user = $_SESSION['id_user'];

$sql = "SELECT * FROM post
        WHERE id_post = ?
        AND id_user = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $id_post,
    $id_user
]);

$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("Post não encontrado.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $legenda = $_POST['legenda'];
    $tipo = $_POST['tipo'];

    $sql = "UPDATE post
            SET legenda = ?,
                tipo = ?
            WHERE id_post = ?
            AND id_user = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $legenda,
        $tipo,
        $id_post,
        $id_user
    ]);

    header("Location: visualizar.php?id_post=" . $id_post);
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar post</title>
</head>

<body>

    <h1>Editar post</h1>

    <form method="POST">

        <div class="form-group">
            <label>Legenda</label>
            <input type="text" name="legenda" value="<?= htmlspecialchars($post['legenda']) ?>" required>
        </div>

        <div class="form-group">
            <label>Tipo de Post</label>
            <input type="text" name="tipo" value="<?= htmlspecialchars($post['tipo']) ?>" required>
        </div>

        <button type="submit">Salvar alterações</button>

    </form>

</body>

</html>