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

<<<<<<< HEAD
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

=======
<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="senha" placeholder="Senha" required><br><br>
    <input type="password" name="confirmar" placeholder="Confirmar senha" required><br><br>
    <button type="submit">Cadastrar</button>
</form>

>>>>>>> 127cbd3acc6e79bd6a4404af11cb0b5031b20eba
</body>
</html>