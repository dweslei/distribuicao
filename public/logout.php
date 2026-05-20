<?php
session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Logout - Distribuição</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style.css">
  <style>
    .logout-card {
      background-color: rgba(255, 255, 255, 0.85); /* branco com transparência */
      border-radius: 10px;
      padding: 40px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: 80px auto;
      text-align: center;
    }
  </style>
  <script>
    setTimeout(function(){
      window.location.href = "index.php";
    }, 20000);
  </script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Distribuição</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="index.php">🏠 Início</a></li>
      <li class="nav-item"><a class="nav-link" href="login.php">🔑 Login</a></li>
    </ul>
  </div>
</nav>

<div class="logout-card">
  <h1 class="text-primary mb-4">🌍 Distribuição</h1>
  <h3 class="mb-3">“Cada alimento doado é um gesto de esperança.”</h3>
  <p class="lead">Você saiu da sua conta. Em breve será redirecionado para a página inicial.</p>
  <p><a href="index.php" class="btn btn-primary mt-3">Ir agora</a></p>
</div>

<footer class="text-center mt-5">
  <img src="../assets/logo.png" alt="Distribuição" class="logo-footer">
</footer>

</body>
</html>
