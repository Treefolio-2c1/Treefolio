<?php

require_once __DIR__ . "/auth.php";
require_once __DIR__ . "/../config/conexao.php";

if ((int)($_SESSION["adm"] ?? 0) !== 1) {
    header("Location: ../index.php");
    exit;
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $acao = $_POST["acao"];

    if ($acao == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_user = ?");
        $stmt->execute([$id]);

        $mensagem = "Usuário excluído!";
    }
    if ($acao == 'ativar') {
        $stmt = $pdo->prepare(
            "UPDATE usuario
            SET status = 'ativo'
            WHERE id_user = ?"
        );
        $stmt->execute([$id]);

        $mensagem = "Usuário ativado!";
    }
    if ($acao == 'desativar') {
        $stmt = $pdo->prepare(
            "UPDATE usuario
            SET status = 'inativo'
            WHERE id_user = ?"
        );
        $stmt->execute([$id]);

        $mensagem = "Usuário desativado!";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Administrador</title>
</head>
<body>

    <?php if (!empty($mensagem)): ?>
        <p><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="number" name="id" placeholder="ID do usuario">
        <button type="submit" name="acao" value="delete">DELETE</button>
        <button type="submit" name="acao" value="ativar">ATIVAR</button>
        <button type="submit" name="acao" value="desativar">DESATIVAR</button>
    </form>

</body>
</html>
