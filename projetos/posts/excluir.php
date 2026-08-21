<?php

session_start();
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_post = $_POST['id_post'];
    $id_user = $_SESSION['id_user'];

    $sql = "DELETE FROM post
            WHERE id_post = ?
            AND id_user = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id_post,
        $id_user
    ]);

    header("Location: visualizar.php");
    exit;
}

?>

