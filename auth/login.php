<?php

session_start();

require_once "../config/conexao.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST["email"];
    $senha = $_POST["senha"];


    $sql = "SELECT * FROM usuario WHERE email = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $email
    ]);


    $usuario = $stmt->fetch();


    if(!$usuario){
        echo "Email ou senha inválidos";
        exit;
    }


    if(!password_verify($senha, $usuario["senha"])){
        echo "Email ou senha inválidos";
        exit;
    }


    $_SESSION["id_user"] = $usuario["id_user"];
    $_SESSION["nome"] = $usuario["nome"];
    $_SESSION["email"] = $usuario["email"];

    header("Location: ../index.php");
    exit;

}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Static/Styles/style.css">

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

<?php include "../includes/footer.php"; ?>

</body>
</html>

