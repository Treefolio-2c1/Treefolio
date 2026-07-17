<?php


    require_once("../config/conexao.php");
    require_once __DIR__ . "/../config/brevo.php";


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confirmar = $_POST['confirmar'];
    
    
    if($senha !== $confirmar){
        echo "Senhas não coincidem";
        exit;
    }

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $token = bin2hex(random_bytes(32));

    $sql = "INSERT INTO usuario (nome, email, senha, ativo, token)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $nome,
        $email,
        $senha,
        0,
        $token
    ]);

    $link = "http://192.168.1.11/Treefolio/auth/confirmar.php?token=".$token;

    $assunto = "Confirme sua conta";

    $mensagem = "
    <h2>Bem-vindo ao Treefolio!</h2>

    <p>Clique no botão abaixo para confirmar sua conta.</p>

    <p>
        <a href='$link'>Confirmar conta</a>
    </p>    
    ";

    $resposta = enviar_email(
        $email,
        $nome,
        $assunto,
        $mensagem
    );

    if (strpos($resposta, "Erro:") !== false) {
        die($resposta);
    }

    header("Location: email.php");
    exit;
    }    
?>

<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Static/Styles/style.css">
    <title>Criar conta — Treefolio</title>

</head>
<body>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="senha" placeholder="Senha" required><br><br>
    <input type="password" name="confirmar" placeholder="Confirmar senha" required><br><br>
    <button type="submit">Cadastrar</button>
</form>

<br>

<button onclick="window.location.href='../index.php'">
    Voltar
</button>

<?php include "../includes/footer.php"; ?>

</body>
</html>