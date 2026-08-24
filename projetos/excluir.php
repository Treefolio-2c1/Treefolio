<?php

require_once __DIR__ . "/../auth/auth.php";
require_once __DIR__ . "/../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_projeto = $_POST['id_projeto'];
    $id_user = $_SESSION['id_user'];

    $sql = "DELETE FROM projetos
            WHERE id_projeto = ?
            AND id_user = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id_projeto,
        $id_user
    ]);

    header("Location: ../perfil/perfil.php");
    exit;
}

?>
