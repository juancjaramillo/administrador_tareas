<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">📋 Admin Tareas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">🏠 Tareas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="create_task.php">➕ Nueva</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="../controllers/logout.php">⛔ Salir</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
