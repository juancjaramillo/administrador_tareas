// public/js/prevent-back.js
(function() {
  // Solo si el navegador soporta history API
  if (window.history && history.pushState) {
    // 1) Insertamos el estado actual para que el primer back dispare popstate
    history.pushState(null, document.title, window.location.href);

    // 2) Si el usuario pulsa Atrás, recargamos la página desde el servidor
    window.addEventListener('popstate', function() {
      window.location.reload(); // ignore cache, fuerza PHP a redirigir si no hay sesión
    });

    // 3) En algunos navegadores se usa pageshow con persisted=true
    window.addEventListener('pageshow', function(event) {
      if (event.persisted) {
        window.location.reload();
      }
    });
  }
})();
