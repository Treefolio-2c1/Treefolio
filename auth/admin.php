<?php

require_once("../auth/admin.php");


if(!isset($_SESSION["id_user"])){
    header("Location: login.php");
    exit;
}



if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST["id"];
    $acao = $_POST["acao"];


if ($acao == 'delete'){
    $stmt = $pdo->prepare("delete from usuario where id_user = ?");
    $stmt->execute([$id]);

    echo "Usuário Excluido!";
}
if ($acao == 'ativar'){
    $stmt = $pdo->prepare
    ("update usuario
    set status = ativo 
    where id_user = ?");
    $stmt->execute([$id]);
}
if ($acao == 'desativar'){
    $stmt = $pdo->prepare
    ("update usuario
    set status = inativo 
    where id_user = ?");
    $stmt->execute([$id]);
}
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Administrador</title>
</head>
<body>
    
    <form action="POST">
        <input type="id" name="id" placeholder="ID do usuario">
        <button type="submit" name="acao" value="delete">DELETE</button>
        <button type="submit" name="acao" value="ativar">ATIVAR</button>
        <button type="submit" name="acao" value="desativar">DESATIVAR</button>
    </form>




</body>
</html>