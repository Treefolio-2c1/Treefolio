<?php

session_start();
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_user = $_SESSION["id_user"];
    $titulo = $_POST["nome"];
    $descricao = $_POST["descr"];
    $categoria = $_POST["tipo"];

    $capa = $_FILES["capa"]["name"];
    $tmp = $_FILES["capa"]["tmp_name"];

    $pasta = "../uploads/projetos/";
    $destino = $pasta . $capa;

    move_uploaded_file($tmp, $destino);

    $sql = "INSERT INTO projetos 
        (id_user, titulo, descricao, categoria, capa)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $id_user,
    $titulo,
    $descricao,
    $categoria,
    $capa
]);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Projeto</title>
</head>
<body>
    
<form method="POST" action="">
    <div class="form-group">
        <label class="form-label">Nome do Projeto</label>
        <input class="form-input" type="text" id="nome" name="nome" placeholder="Projeto Treefolio" required>
    </div>
    <div class="form-group">
        <label class="form-label">Descrição do Projeto</label>
        <input class="form-input" type="text" id="descr" name="descr" placeholder="Esse projeto é sobre projetos..." required>
    </div>
    <div class="form-group">
        <label class="form-label">Tipo de Projeto</label>
        <input class="form-input" type="text" id="tipo" name="tipo" placeholder="Arquitetura" required>
    </div>
    <div class="form-group">
        <label class="form-label">Capa do Projeto</label>
        <input class="form-input" type="file" id="capa" name="capa" accept="image/*" required>
    </div>
</form>


</body>
</html>