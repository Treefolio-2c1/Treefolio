<?php

session_start();

include "config/conexao.php";

    if($_SERVER ["REQUEST_METHOD"] == "POST"){
        $email = $_POST['email'];
        $senha = $_POST['senha'];
    }

    $sql = "SELECT * FROM usuario WHERE email = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
    $email,
    $senha
    ]);



    $usuario = $stmt->fetch();

    if($usuario){
    $_SESSION["id_user"] = $usuario["id_user"];
    $_SESSION["nome"] = $usuario["nome"];

    header("Location: index.php");
    exit;
    }
    else{
    echo "E-mail ou senha inválidos.";
    }


?>

<!DOCTYPE html>
<html>
<head>

    <title>Login</title>
    
</head>
<body>

<h1>Login</h1>

<form method="POST">
    <label>Email:</label>
    <input type="email" name="email" required>
    <br><br>
    <label>Senha:</label>
    <input type="password" name="senha" required>
    <br><br>
    <button type="submit">Logar</button>
</form>

</body>
</html>

