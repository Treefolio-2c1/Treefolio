<?php 






?>

<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Static/Styles/style.css">
  <title>Treefolio</title>
</head>
<body>

<img src="Static/img/newlogo.svg" alt="logo_treefolio" width=200>

<h1>Index</h1>

<button onclick="window.location.href='auth/cadastro.php'">
    Cadastro
</button>

<button onclick="window.location.href='auth/login.php'">
    Login
</button>

<button onclick="window.location.href='auth/logout.php'">
    Logout
</button>

<?php include "../includes/footer.php"; ?>

</body>
</html>