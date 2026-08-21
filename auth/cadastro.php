<?php

require_once("../config/conexao.php");
require_once __DIR__ . "/../config/brevo.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmar'];
    $ocupacao = $_POST['ocupacao'];
    $data = $_POST['data'];

    if ($senha !== $confirmar) {
        echo "Senhas não coincidem";
        exit;
    }

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $token = bin2hex(random_bytes(32));

    $foto = $_FILES['foto'];

    $nome_foto = uniqid() . "_" . basename($foto['name']);

    $pasta = "../uploads/perfil/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    move_uploaded_file($foto['tmp_name'], $pasta . $nome_foto);

    $sql = "INSERT INTO usuario (nome, email, senha, status, token, datanasc, ocupacao)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $nome,
        $email,
        $senha,
        'ativo',
        $token,
        $data,
        $ocupacao
    ]);

    $id_user = $pdo->lastInsertId();

    $sql = "INSERT INTO perfil (id_user, foto)
            VALUES (?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id_user,
        $nome_foto
    ]);

    $link = "http://192.168.1.11/Treefolio/auth/confirmar.php?token=" . $token;

    $assunto = "Confirme sua conta";

    $mensagem = "
    <h2>Bem-vindo ao Treefolio!</h2>
    <p>Clique no botão abaixo para confirmar sua conta.</p>
    <p><a href='$link'>Confirmar conta</a></p>
    ";

    $resposta = enviar_email($email, $nome, $assunto, $mensagem);

    if (strpos($resposta, "Erro:") !== false) {
        die($resposta);
    }

    header("Location: email.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta — Treefolio</title>
    <?php include "../includes/header.php"; ?>
</head>

<body>

<nav class="navbar">
    <a class="navbar__logo" href="../index.php">
        <img class="navbar__logo" src="../Static/img/newlogo.svg" alt="Treefolio">
        <span class="navbar__logo-text">tree<span>folio</span></span>
    </a>
</nav>

<div class="auth-page">
    <div class="card auth-card card--elevated">

        <div class="auth-header">
            <img class="auth-header__logo" src="../Static/img/newlogo.svg" alt="Treefolio">
            <h1 class="heading-lg">Criar conta</h1>
            <p class="text-muted mt-1">slogan</p>
        </div>

        <?php if (!empty($erro)): ?>
            <div class="alert alert--error mb-2">⚠️ <?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">

            <div class="form-group">
                <label class="form-label" for="nome">Nome completo</label>
                <input class="form-input" type="text" id="nome" name="nome" placeholder="Seu nome" required autocomplete="name">
            </div>

            <div class="form-group">
                <label class="form-label" for="email">E-mail</label>
                <input class="form-input" type="email" id="email" name="email" placeholder="seu@email.com" required autocomplete="email">
            </div>

            <div class="form-group">
                <label class="form-label" for="ocupacao">Ocupação Atual</label>
                <input class="form-input" type="text" id="ocupacao" name="ocupacao" placeholder="Sua ocupação" required autocomplete="organization-title">
            </div>

            <div class="form-group">
                <label class="form-label" for="data">Data de Nascimento</label>
                <input class="form-input" type="date" id="data" name="data" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="foto">Foto de perfil</label>
                <input class="form-input" type="file" id="foto" name="foto" accept="image/*" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="senha">Senha</label>
                <input class="form-input" type="password" id="senha" name="senha" placeholder="Mínimo 8 caracteres" required minlength="8" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label class="form-label" for="confirmar">Confirmar senha</label>
                <input class="form-input" type="password" id="confirmar" name="confirmar" placeholder="Repita a senha" required minlength="8" autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn--primary btn--full btn--lg mt-2">Criar conta</button>

        </form>

        <div class="auth-divider">ou</div>

        <div class="auth-footer">
            <a href="login.php">entrar</a>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>