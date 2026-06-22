<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>

<h1>Cadastro</h1>

<form action="" method="POST">
    <label>Nome:</label>
    <input type="text" name="nome" required>
    <br><br>

    <label>Email:</label>
    <input type="email" name="email" required>
    <br><br>

    <label>Senha:</label>
    <input type="password" name="senha" required>
    <br><br>

    <label>Confirme sua Senha:</label>
    <input type="password" name="confirmar" required>
    <br><br>

    <button type="submit">Cadastrar</button>
</form>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

    require_once "../config/conexao.php";

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmar'];

    // verifica senha
    if($senha !== $confirmar){
        echo "Senhas não coincidem";
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // verifica email duplicado
    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    if($stmt->rowCount() > 0){
        echo "Email já cadastrado";
        exit;
    }

    // insere
    $sql = "INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $senhaHash]);

    echo "Cadastrado com sucesso";
}
?>

</body>
</html>