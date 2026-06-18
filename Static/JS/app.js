/* ============================================================
   TREEFOLIO — app.js
   Dark mode toggle persistido via localStorage
   ============================================================ */

(function () {
  'use strict';

  // ── Aplica tema salvo ANTES do render (evita flash) ──────
  var saved = localStorage.getItem('tf-theme');
  var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  var initialTheme = saved || (prefersDark ? 'dark' : 'light');
  document.documentElement.setAttribute('data-theme', initialTheme);

  document.addEventListener('DOMContentLoaded', function () {

    // ── Renderiza thumbs com ícone correto ───────────────
    syncToggles(document.documentElement.getAttribute('data-theme'));

    // ── Escuta todos os .theme-toggle da página ──────────
    document.querySelectorAll('.theme-toggle').forEach(function (btn) {
      btn.setAttribute('role', 'switch');
      btn.setAttribute('tabindex', '0');
      btn.addEventListener('click', toggleTheme);
      btn.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggleTheme(); }
      });
    });

  });

  function toggleTheme() {
    var current = document.documentElement.getAttribute('data-theme');
    var next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('tf-theme', next);
    syncToggles(next);
  }

  function syncToggles(theme) {
    document.querySelectorAll('.theme-toggle').forEach(function (btn) {
      var thumb = btn.querySelector('.theme-toggle__thumb');
      if (thumb) thumb.textContent = theme === 'dark' ? '🌙' : '☀️';
      btn.setAttribute('aria-checked', theme === 'dark' ? 'true' : 'false');
      btn.setAttribute('aria-label', theme === 'dark' ? 'Ativar modo claro' : 'Ativar modo escuro');
    });
  }

})();
