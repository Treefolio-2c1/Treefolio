<?php

require_once __DIR__ . "/../auth/auth.php";
require_once __DIR__ . "/../config/conexao.php";

$sql = "SELECT * from usuario WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['id_user']]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

$nome = $row['nome'];
$foto = $row['foto'];
$ocu = $row['ocupacao'];


$sql = "SELECT * from perfil WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['id_user']]);

$row2 = $stmt->fetch(PDO::FETCH_ASSOC);

$bio = $row2['bio'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>

<div class="perfil">

    <img src="../uploads/perfil/<?= htmlspecialchars($foto) ?>" alt="Foto de perfil">

    <h1><?= htmlspecialchars($nome) ?></h1>

    <p><?= htmlspecialchars($ocu) ?></p>

    <p><?= htmlspecialchars($bio) ?></p>

    <a href="curriculo/curriculo.php">
    <button type="button">Currículo</button>
    </a>

</div>

</body>
</html>
