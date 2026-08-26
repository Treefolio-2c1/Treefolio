<?php
session_start();

require __DIR__ . "/config/conexao.php";

$sql = "SELECT * FROM projetos ORDER BY dataproj DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$css_path = '';
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treefolio</title>

    <?php include "includes/header.php"; ?>
</head>

<body>

<nav class="navbar">

    <a class="navbar__logo" href="index.php">

        <img class="hero__logo" src="Static/img/newlogo.svg">

        <span class="navbar__logo-text">
            tree<span>folio</span>
        </span>

    </a>

    <div class="navbar__actions">

        <?php if (!isset($_SESSION['id_user'])): ?>

            <a class="btn btn--ghost" href="auth/login.php">
                Entrar
            </a>

            <a class="btn btn--primary" href="auth/cadastro.php">
                Cadastrar
            </a>

        <?php else: ?>

            <a class="btn btn--ghost" href="perfil/perfil.php">
                Meu perfil
            </a>

            <a class="btn btn--primary" href="auth/logout.php">
                Sair
            </a>

        <?php endif; ?>

    </div>

</nav>

<main class="hero">

    <img class="hero__logo" src="Static/img/newlogo.svg">

    <h1 class="hero__title">
        slogan,<br>
        <span>slogan</span>
    </h1>

    <p class="hero__subtitle">
        elaborar paragrafo
    </p>

    <?php if (!isset($_SESSION['id_user'])): ?>

        <div class="hero__actions">

            <a class="btn btn--primary btn--lg" href="auth/cadastro.php">
                Criar conta
            </a>

            <a class="btn btn--ghost btn--lg" href="auth/login.php">
                Login
            </a>

        </div>

    <?php endif; ?>

</main>

<?php include "includes/footer.php"; ?>

</body>
</html>