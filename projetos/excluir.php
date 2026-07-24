<?php
session_start();

require "../config/conexao.php";

if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

if(isset($_GET['id'])){

    $id_projeto = $_GET['id'];

    $sql = "DELETE FROM projetos 
    WHERE id_projeto = ? 
    AND id_user = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id_projeto,
        $id_user
    ]);

}

header("Location: index.php");
exit;
?>