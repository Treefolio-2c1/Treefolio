<?php

    require_once "../config/conexao.php";

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmar'];

    if($senha !== $confirmar){
        echo "Senhas não coincidem";
        exit;
    }

    $sql = "INSERT INTO usuario (nome, email, senha)
            VALUES (?, ?, ?) " ;

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
    $nome,
    $email,
    $senha
    ]);

    header("location: email.php");
    exit;
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