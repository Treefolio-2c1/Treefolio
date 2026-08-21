<?php

session_start();
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_post = $_POST['id_post'];
    $id_user = $_SESSION['id_user'];

    $sql = "SELECT id_like FROM likes
            WHERE id_user = ?
            AND id_post = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id_user,
        $id_post
    ]);

    $like = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($like) {

        $sql = "DELETE FROM likes
                WHERE id_user = ?
                AND id_post = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $id_user,
            $id_post
        ]);

    } else {

        $sql = "INSERT INTO likes (id_user, id_post)
                VALUES (?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $id_user,
            $id_post
        ]);
    }

    header("Location: visualizar_post.php?id_post=" . $id_post);
    exit;
}

?>