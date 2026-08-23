<?php

session_start();
require_once __DIR__ . "/../../../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_comentario = $_POST['id_comentario'];
    $id_user = $_SESSION['id_user'];

    $sql = "DELETE FROM comentarios
            WHERE id_comentario = ?
            AND id_user = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id_comentario,
        $id_user
    ]);

    $id_post = $_POST['id_post'];

    header("Location: ../visualizar.php?id_post=" . $id_post);
    exit;
}

?>