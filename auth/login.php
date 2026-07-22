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
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entrar — Treefolio</title>
  <?php include "../includes/header.php"; ?>
</head>
<body>

<nav class="navbar">
  <a class="navbar__logo" href="../index.php">
    <img src="../Static/img/logo.svg" alt="Treefolio">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
</nav>

<div class="auth-page">
  <div class="card auth-card card--elevated">

    <div class="auth-header">
      <img class="auth-header__logo" src="../Static/img/logo.svg" alt="Treefolio">
    </div>

    <form method="POST" action="">
      <div class="form-group">
        <label class="form-label" for="email">E-mail</label>
        <input class="form-input" type="email" id="email" name="email" placeholder="seu@email.com" required autocomplete="email">
      </div>
      <div class="form-group">
        <label class="form-label" for="senha">Senha</label>
        <input class="form-input" type="password" id="senha" name="senha" placeholder="••••••••" required autocomplete="current-password">
      </div>
      <button type="submit" class="btn btn--primary btn--full btn--lg mt-2">Entrar</button>
    </form>

    <div class="auth-divider">ou</div>

    <div class="auth-footer">
    <a href="cadastro.php">Criar conta</a>
    </div>

  </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
