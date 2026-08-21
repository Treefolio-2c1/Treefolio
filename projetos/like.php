<?php

session_start();
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_projeto = $_POST['id_projeto'];
    $id_user = $_SESSION['id_user'];

    $sql = "SELECT id_like FROM likes
            WHERE id_user = ?
            AND id_projeto = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id_user,
        $id_projeto
    ]);

    $like = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($like) {

        $sql = "DELETE FROM likes
                WHERE id_user = ?
                AND id_projeto = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $id_user,
            $id_projeto
        ]);

    } else {

        $sql = "INSERT INTO likes (id_user, id_projeto)
                VALUES (?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $id_user,
            $id_projeto
        ]);
    }

    header("Location: visualizar.php?id_projeto=" . $id_projeto);
    exit;
}

?>