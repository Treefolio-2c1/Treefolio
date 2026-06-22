<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Treefolio — Gerencie seu portfólio com inteligência</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Static/Styles/style.css">
  <script src="Static/JS/app.js" defer></script>
</head>
<body>

<!-- ── NAVBAR ── -->
<nav class="navbar">
  <a class="navbar__logo" href="index.php">
    <img src="Static/img/logo.svg" alt="Treefolio logo">
    <span class="navbar__logo-text">tree<span>folio</span></span>
  </a>
  <div class="navbar__actions">
    <a href="auth/login.php" class="btn btn--ghost btn--sm">Entrar</a>
    <a href="auth/cadastro.php" class="btn btn--primary btn--sm">Cadastrar</a>
    <button class="theme-toggle" aria-label="Alternar tema">
      <span class="theme-toggle__thumb">☀️</span>
    </button>
  </div>
</nav>

<!-- ── MAIN ── -->
<main class="page">

  <!-- HERO -->
  <section class="hero">
    <span class="hero__badge">✦ Beta</span>
    <h1 class="heading-xl hero__title">
      Seu portfólio,<br><span class="accent">organizado na nuvem</span>
    </h1>
    <p class="hero__subtitle">
      Treefolio reúne seus projetos, documentos e conquistas em um único lugar — limpo, rápido e sempre acessível.
    </p>
    <div class="hero__cta">
      <a href="auth/cadastro.php" class="btn btn--primary btn--lg">Criar conta grátis</a>
      <a href="auth/login.php" class="btn btn--subtle btn--lg">Já tenho conta</a>
    </div>
  </section>

  <!-- STATS -->
  <div class="container">
    <div class="stats-row">
      <div class="stat-card">
        <span class="stat-card__number">2.4k</span>
        <span class="stat-card__label">Usuários</span>
      </div>
      <div class="stat-card">
        <span class="stat-card__number">18k</span>
        <span class="stat-card__label">Projetos</span>
      </div>
      <div class="stat-card">
        <span class="stat-card__number">99%</span>
        <span class="stat-card__label">Uptime</span>
      </div>
    </div>
  </div>

  <!-- FEATURES -->
  <section class="features">
    <div class="container">
      <h2 class="heading-lg features__title">Tudo que você precisa</h2>
      <div class="features__grid">

        <div class="card feature-card">
          <div class="feature-card__icon">🌿</div>
          <h3 class="heading-md">Portfólio vivo</h3>
          <p class="text-muted">Adicione projetos, links e mídias. Seu portfólio cresce com você.</p>
        </div>

        <div class="card feature-card">
          <div class="feature-card__icon">☁️</div>
          <h3 class="heading-md">Na nuvem, sempre</h3>
          <p class="text-muted">Acesse de qualquer dispositivo, em qualquer lugar, sem instalar nada.</p>
        </div>

        <div class="card feature-card">
          <div class="feature-card__icon">🔒</div>
          <h3 class="heading-md">Privacidade total</h3>
          <p class="text-muted">Você decide o que é público e o que fica só pra você.</p>
        </div>

        <div class="card feature-card">
          <div class="feature-card__icon">⚡</div>
          <h3 class="heading-md">Super rápido</h3>
          <p class="text-muted">Interface leve, sem travamentos, mesmo em redes lentas.</p>
        </div>

        <div class="card feature-card">
          <div class="feature-card__icon">📊</div>
          <h3 class="heading-md">Métricas</h3>
          <p class="text-muted">Veja quem visitou seu portfólio e quais projetos chamaram atenção.</p>
        </div>

        <div class="card feature-card">
          <div class="feature-card__icon">🎨</div>
          <h3 class="heading-md">Personalizável</h3>
          <p class="text-muted">Escolha temas e organize seu espaço do jeito que preferir.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- CTA STRIP -->
  <div class="container">
    <div class="cta-strip card">
      <h2 class="heading-lg">Pronto para começar?</h2>
      <p class="text-muted">Crie sua conta grátis em menos de 1 minuto. Sem cartão de crédito.</p>
      <a href="auth/cadastro.php" class="btn btn--primary btn--lg">Criar minha conta</a>
    </div>
  </div>

</main>

<!-- ── FOOTER ── -->
<footer class="footer">
  © 2025 <strong>treefolio</strong> — todos os direitos reservados
</footer>

</body>
</html>
