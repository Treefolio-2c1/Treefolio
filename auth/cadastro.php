<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>

<h1>Cadastro</h1>

    <form action="cadastro.php" method="POST">
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
    <input type="password" required>  

    <button type="submit" >Cadastrar</button>
</body>
</html>
