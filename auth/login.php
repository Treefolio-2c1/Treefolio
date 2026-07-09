<?php

$email = $_POST['email'];
$senha = $_POST['senha'];

header("location:index.php");
exit;
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