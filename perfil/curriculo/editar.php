<?php

require_once __DIR__ . "/../../auth/auth.php";
require_once __DIR__ . "/../../config/conexao.php";

$id_user = $_SESSION['id_user'];

$sql = "SELECT * FROM curriculo WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);

$curriculo = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $formacao = $_POST['formacao'];
    $experiencia = $_POST['experiencia'];
    $habilidades = $_POST['habilidades'];
    $cursos = $_POST['cursos'];
    $idiomas = $_POST['idiomas'];

    if ($curriculo) {

        $sql = "UPDATE curriculo
                SET formacao = ?, experiencia = ?, habilidades = ?, cursos = ?, idiomas = ?
                WHERE id_user = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $formacao,
            $experiencia,
            $habilidades,
            $cursos,
            $idiomas,
            $id_user
        ]);

    } else {

        $sql = "INSERT INTO curriculo (id_user, formacao, experiencia, habilidades, cursos, idiomas)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $id_user,
            $formacao,
            $experiencia,
            $habilidades,
            $cursos,
            $idiomas
        ]);
    }

    header("Location: curriculo.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar currículo</title>
</head>

<body>

    <h1>Editar currículo</h1>

    <form method="POST">

        <div>
            <label>Formação</label>
            <textarea name="formacao" placeholder="Ex: Técnico em Desenvolvimento de Sistemas"><?= htmlspecialchars($curriculo['formacao'] ?? '') ?></textarea>
        </div>

        <div>
            <label>Experiência</label>
            <textarea name="experiencia" placeholder="Descreva suas experiências"><?= htmlspecialchars($curriculo['experiencia'] ?? '') ?></textarea>
        </div>

        <div>
            <label>Habilidades</label>
            <textarea name="habilidades" placeholder="Ex: HTML, CSS, PHP, MySQL"><?= htmlspecialchars($curriculo['habilidades'] ?? '') ?></textarea>
        </div>

        <div>
            <label>Cursos</label>
            <textarea name="cursos" placeholder="Cursos realizados"><?= htmlspecialchars($curriculo['cursos'] ?? '') ?></textarea>
        </div>

        <div>
            <label>Idiomas</label>
            <textarea name="idiomas" placeholder="Ex: Português, Inglês"><?= htmlspecialchars($curriculo['idiomas'] ?? '') ?></textarea>
        </div>

        <button type="submit">Salvar currículo</button>

    </form>

</body>

</html>