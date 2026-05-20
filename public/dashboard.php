<?php 
session_start();
if(!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
$usuario = $_SESSION["usuario"];
$tipo = $_SESSION["tipo"];
$id = $_SESSION["id"];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Distribuição</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<!-- Menu superior -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Distribuição</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="dashboard.php">🏠 Início</a></li>
      <li class="nav-item"><a class="nav-link" href="editar.php?id=<?php echo $id; ?>">⚙️ Meus Dados</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php">🚪 Sair</a></li>
    </ul>
  </div>
</nav>

<div class="container mt-5">
  <h2>Bem-vindo, <?php echo $usuario; ?>!</h2>
  <p class="lead">Você está logado como <strong><?php echo ucfirst($tipo); ?></strong>.</p>

  <div class="row mt-4">
    <?php if($tipo == "admin"): ?>
      <div class="col-md-4">
        <div class="card p-3 shadow-sm">
          <h5>📦 Registrar Doação</h5>
          <p>Cadastre novas doações de alimentos.</p>
          <a href="doador.php" class="btn btn-primary">Acessar</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3 shadow-sm">
          <h5>🛒 Solicitar Alimentos</h5>
          <p>Solicite alimentos disponíveis para retirada.</p>
          <a href="beneficiario.php" class="btn btn-primary">Acessar</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3 shadow-sm">
          <h5>🚚 Entregas</h5>
          <p>Acompanhe e registre entregas realizadas.</p>
          <a href="voluntario.php" class="btn btn-primary">Acessar</a>
        </div>
      </div>
      <div class="col-md-4 mt-3">
        <div class="card p-3 shadow-sm">
          <h5>🏢 Gestão de Estoque</h5>
          <p>Gerencie os alimentos armazenados no depósito.</p>
          <a href="deposito.php" class="btn btn-primary">Acessar</a>
        </div>
      </div>
      <div class="col-md-4 mt-3">
        <div class="card p-3 shadow-sm">
          <h5>👥 Gestão de Usuários</h5>
          <p>Visualize e gerencie todos os cadastrados.</p>
          <a href="usuarios.php" class="btn btn-primary">Acessar</a>
        </div>
      </div>
    <?php elseif($tipo == "doador"): ?>
      <div class="col-md-4">
        <div class="card p-3 shadow-sm">
          <h5>📦 Registrar Doação</h5>
          <p>Cadastre novas doações de alimentos.</p>
          <a href="doador.php" class="btn btn-primary">Acessar</a>
        </div>
      </div>
    <?php elseif($tipo == "beneficiario"): ?>
      <div class="col-md-4">
        <div class="card p-3 shadow-sm">
          <h5>🛒 Solicitar Alimentos</h5>
          <p>Solicite alimentos disponíveis para retirada.</p>
          <a href="beneficiario.php" class="btn btn-primary">Acessar</a>
        </div>
      </div>
    <?php elseif($tipo == "voluntario"): ?>
      <div class="col-md-4">
        <div class="card p-3 shadow-sm">
          <h5>🚚 Entregas</h5>
          <p>Acompanhe e registre entregas realizadas.</p>
          <a href="voluntario.php" class="btn btn-primary">Acessar</a>
        </div>
      </div>
    <?php elseif($tipo == "deposito"): ?>
      <div class="col-md-4">
        <div class="card p-3 shadow-sm">
          <h5>🏢 Gestão de Estoque</h5>
          <p>Gerencie os alimentos armazenados no depósito.</p>
          <a href="deposito.php" class="btn btn-primary">Acessar</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<footer class="text-center mt-5">
  <img src="../assets/logo.png" alt="Distribuição" class="logo-footer">
</footer>

</body>
</html>
