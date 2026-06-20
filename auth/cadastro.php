<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    require_once "../config/conexao.php";

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmar'];

    if($senha !== $confirmar){
        echo "Senhas não coincidem";
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    if($stmt->rowCount() > 0){
        echo "Email já cadastrado";
        exit;
    }

    $sql = "INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $senhaHash]);

    $_SESSION['email'] = $email;

    header("Location: email.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>

<h1>Cadastro</h1>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="senha" placeholder="Senha" required><br><br>
    <input type="password" name="confirmar" placeholder="Confirmar senha" required><br><br>
    <button type="submit">Cadastrar</button>
</form>

</body>
</html>