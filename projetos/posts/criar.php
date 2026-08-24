<?php

require_once __DIR__ . "/../../auth/auth.php";
require_once __DIR__ . "/../../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_user = $_SESSION['id_user'];
    $legenda = $_POST['legenda'];
    $tipo = $_POST['tipo'];

    $tmp_capa = $_FILES['capa']['tmp_name'];
    $nome_capa = uniqid() . "_" . basename($_FILES['capa']['name']);

    $tmp_arquivo = $_FILES['arquivo']['tmp_name'];
    $nome_arquivo = uniqid() . "_" . basename($_FILES['arquivo']['name']);

    $pasta = "../../uploads/posts/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    move_uploaded_file($tmp_capa, $pasta . $nome_capa);
    move_uploaded_file($tmp_arquivo, $pasta . $nome_arquivo);

    $sql = "INSERT INTO post
            (id_user, arquivo, capa, legenda, tipo)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id_user,
        $nome_arquivo,
        $nome_capa,
        $legenda,
        $tipo
    ]);

    header("Location: visualizar.php?id_post=" . $pdo->lastInsertId());
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar post</title>
</head>

<body>

<form method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label class="form-label">Legenda</label>
        <input class="form-input" type="text" id="legenda" name="legenda" placeholder="Esse post é sobre..." required>
    </div>

    <div class="form-group">
        <label class="form-label">Tipo de Post</label>
        <input class="form-input" type="text" id="tipo" name="tipo" placeholder="Arquitetura" required>
    </div>

    <div class="form-group">
        <label class="form-label">Capa do Post</label>
        <input class="form-input" type="file" id="capa" name="capa" accept="image/*" required>
    </div>

    <div class="form-group">
        <label class="form-label">Arquivo do post</label>
        <input class="form-input" type="file" id="arquivo" name="arquivo" required>
    </div>

    <button type="submit">Criar post</button>

</form>

</body>
</html>