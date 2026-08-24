<?php

require_once __DIR__ . "/../auth/auth.php";
require_once __DIR__ . "/../config/conexao.php";

$id_user = $_SESSION['id_user'];

$sql = "SELECT * FROM usuario WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM perfil WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);

$row2 = $stmt->fetch(PDO::FETCH_ASSOC);

$nome = $row['nome'];
$ocu = $row['ocupacao'];
$bio = $row2['bio'];
$foto = $row['foto'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $ocu = $_POST['ocupacao'];
    $bio = $_POST['bio'];

    $sql = "UPDATE usuario
            SET nome = ?, ocupacao = ?
            WHERE id_user = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $nome,
        $ocu,
        $id_user
    ]);


    $sql = "UPDATE perfil
            SET bio = ?
            WHERE id_user = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $bio,
        $id_user
    ]);


    if (!empty($_FILES['foto']['name'])) {

        $nome_foto = uniqid() . "_" . basename($_FILES['foto']['name']);

        $pasta = "../uploads/perfil/";

        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            $pasta . $nome_foto
        );

        $sql = "UPDATE usuario
                SET foto = ?
                WHERE id_user = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $nome_foto,
            $id_user
        ]);
    }


    header("Location: perfil.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar perfil</title>
</head>

<body>

    <h1>Editar perfil</h1>

    <form method="POST" enctype="multipart/form-data">
        <div>
            <label>Nome</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" required>
        </div>
        <div>
            <label>Ocupação</label>
            <input type="text" name="ocupacao" value="<?= htmlspecialchars($ocu) ?>" required>
        </div>
        <div>
            <label>Biografia</label>
            <textarea name="bio"><?= htmlspecialchars($bio ?? '') ?></textarea>
        </div>
        <div>
            <label>Foto de perfil</label>
            <input type="file" name="foto" accept="image/*">
        </div>
        <button type="submit">Salvar alterações</button>
    </form>

</body>

</html>
