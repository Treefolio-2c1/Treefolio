<?php
session_start();

require "../config/conexao.php";

if(!isset($_SESSION['id_user'])){
    header("Location: ../auth/login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: ../index.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_post = $_GET['id'];

$sql = "SELECT * FROM post
WHERE id_post = ?
AND id_user = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post,$id_user]);

$post = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$post){
    header("Location: ../index.php");
    exit;
}

$id_projeto = $post["id_projeto"];

if(file_exists("../".$post["arquivo"])){
    unlink("../".$post["arquivo"]);
}

$pasta = dirname("../".$post["arquivo"]);

if(is_dir($pasta)){
    rmdir($pasta);
}

$sql = "DELETE FROM post
WHERE id_post = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id_post]);

header("Location: ../projetos/visualizar.php?id=".$id_projeto);
exit;
?>