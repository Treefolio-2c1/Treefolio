<?php
session_start();

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../config/conexao.php";

    $nome     = trim($_POST['nome']);
    $email    = trim($_POST['email']);
    $senha    = $_POST['senha'];
    $confirmar = $_POST['confirmar'];

    if ($senha !== $confirmar) {
        $erro = "As senhas não coincidem.";
    } else {
        $sql  = "SELECT * FROM usuario WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $erro = "Este e-mail já está cadastrado.";
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $sql  = "INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $email, $hash]);

            $_SESSION['email'] = $email;
            header("Location: login.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar conta — Treefolio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../Static/Styles/style.css">
  <script src="../Static/JS/app.js" defer></script>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a class="navbar__logo" href="../index.php">
    <img src="../Static/img/logo.svg" alt="Treefolio logo">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <button class="theme-toggle" aria-label="Alternar tema">
      <span class="theme-toggle__thumb">☀️</span>
    </button>
  </div>
</nav>

<!-- AUTH PAGE -->
<div class="auth-page">
  <div class="card auth-card card--elevated">

    <div class="auth-header">
      <img src="../Static/img/logo.svg" alt="Treefolio" class="auth-header__logo">
      <h1 class="heading-lg">Criar conta grátis</h1>
      <p class="text-muted mt-1">Comece a organizar seu portfólio hoje</p>
    </div>

    <?php if ($erro): ?>
      <div class="alert alert--error mb-2">⚠️ <?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label class="form-label" for="nome">Nome completo</label>
        <input
          class="form-input"
          type="text"
          id="nome"
          name="nome"
          placeholder="Seu nome"
          required
          autocomplete="name"
        >
      </div>

      <div class="form-group">
        <label class="form-label" for="email">E-mail</label>
        <input
          class="form-input"
          type="email"
          id="email"
          name="email"
          placeholder="seu@email.com"
          required
          autocomplete="email"
        >
      </div>

      <div class="form-group">
        <label class="form-label" for="senha">Senha</label>
        <input
          class="form-input"
          type="password"
          id="senha"
          name="senha"
          placeholder="Mínimo 8 caracteres"
          required
          minlength="8"
          autocomplete="new-password"
        >
      </div>

      <div class="form-group">
        <label class="form-label" for="confirmar">Confirmar senha</label>
        <input
          class="form-input"
          type="password"
          id="confirmar"
          name="confirmar"
          placeholder="Repita a senha"
          required
          minlength="8"
          autocomplete="new-password"
        >
      </div>

      <button type="submit" class="btn btn--primary btn--full btn--lg mt-2">Criar conta</button>
    </form>

    <div class="auth-divider">ou</div>

    <div class="auth-footer">
      Já tem conta?
      <a href="login.php">Entrar</a>
    </div>

  </div>
</div>

<!-- FOOTER -->
<footer class="footer">
  © 2025 <strong>treefolio</strong> — todos os direitos reservados
</footer>

</body>
</html>
