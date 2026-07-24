<?php
session_start();

require "../config/conexao.php";

if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$id_projeto = $_GET['id'];
$erro = "";

$sql = "SELECT * FROM projetos WHERE id_projeto = ? AND id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_projeto, $id_user]);

$projeto = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$projeto){
    header("Location: index.php");
    exit;
}

if(isset($_POST['editar'])){

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];

    try{

        $sql = "UPDATE projetos 
        SET titulo = ?, descricao = ?, categoria = ?
        WHERE id_projeto = ? AND id_user = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $titulo,
            $descricao,
            $categoria,
            $id_projeto,
            $id_user
        ]);

        header("Location: visualizar.php?id=".$id_projeto);
        exit;

    }catch(PDOException $e){

        $erro = "Erro ao editar projeto: ".$e->getMessage();

    }
}
?>