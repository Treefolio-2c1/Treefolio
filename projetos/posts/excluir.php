<?php

require_once __DIR__ . "/../../auth/auth.php";
require_once __DIR__ . "/../../config/conexao.php";

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

    header("Location: ../../perfil/perfil.php");
    exit;
}

?>
