<?php
session_start();

require "../config/conexao.php";

if(!isset($_SESSION["id_user"])){
    header("Location: ../auth/login.php");
    exit;
}

$id_user = $_SESSION["id_user"];

$id_post = $_POST["id_post"];
$comentario = trim($_POST["comentario"]);

if(empty($comentario)){
    header("Location: visualizar.php?id=".$id_post);
    exit;
}

$sql = "INSERT INTO comentarios
(id_post,id_user,comentario)
VALUES(?,?,?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $id_post,
    $id_user,
    $comentario
]);

header("Location: visualizar.php?id=".$id_post);
exit;
?>