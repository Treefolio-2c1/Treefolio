<?php

require_once __DIR__ . "/../../../auth/auth.php";
require_once __DIR__ . "/../../../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_post = $_POST['id_post'];
    $id_user = $_SESSION['id_user'];
    $comentario = $_POST['comentario'];

    $sql = "INSERT INTO comentarios (id_post, id_user, comentario)
            VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id_post,
        $id_user,
        $comentario
    ]);

    header("Location: ../visualizar.php?id_post=" . $id_post);
    exit;
}

?>