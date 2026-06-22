<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if(isset($_SESSION['usuario'])){

        $user = $_SESSION['usuario'];

        if($email === $user['email'] && password_verify($senha, $user['senha'])){
            $_SESSION['logado'] = true;
            echo "Login OK <br>";
            echo "<a href='dashboard.php'>Ir pro sistema</a>";
        } else {
            echo "Email ou senha inválidos";
        }

    } else {
        echo "Nenhum usuário cadastrado";
    }
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