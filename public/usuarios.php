<?php
include("../config/db.php");
session_start();

// Apenas administrador pode acessar
if ($_SESSION["tipo"] != "admin") {
    die("Acesso negado. Somente administradores podem visualizar esta página.");
}

// Excluir usuário (se solicitado)
if (isset($_GET["delete"])) {
    $deleteId = intval($_GET["delete"]);
    $sqlDelete = "DELETE FROM usuario WHERE id_usuario=?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $deleteId);
    if ($stmtDelete->execute()) {
        $_SESSION["flash"] = "Usuário excluído com sucesso!";
        header("Location: usuarios.php");
        exit();
    } else {
        $erro = "Erro ao excluir: " . $conn->error;
    }
}

// Buscar todos os usuários
$sql = "SELECT id_usuario, nome, email, telefone, tipo FROM usuario ORDER BY id_usuario ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gestão de Usuários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Distribuição</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="dashboard.php">🏠 Início</a></li>
      <li class="nav-item"><a class="nav-link" href="editar.php?id=<?php echo $_SESSION['id']; ?>">⚙️ Meus Dados</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php">🚪 Sair</a></li>
    </ul>
  </div>
</nav>

<div class="container mt-5">
  <h2 class="mb-4">👥 Gestão de Usuários</h2>

  <?php if(isset($_SESSION["flash"])): ?>
    <div class="alert alert-success"><?php echo $_SESSION["flash"]; unset($_SESSION["flash"]); ?></div>
  <?php endif; ?>
  <?php if(isset($erro)): ?>
    <div class="alert alert-danger"><?php echo $erro; ?></div>
  <?php endif; ?>

  <table class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Tipo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row["id_usuario"]; ?></td>
          <td><?php echo htmlspecialchars($row["nome"]); ?></td>
          <td><?php echo htmlspecialchars($row["email"]); ?></td>
          <td><?php echo htmlspecialchars($row["telefone"]); ?></td>
          <td><?php echo ucfirst($row["tipo"]); ?></td>
          <td>
            <a href="editar.php?id=<?php echo $row['id_usuario']; ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="usuarios.php?delete=<?php echo $row['id_usuario']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<footer class="text-center mt-5">
  <img src="../assets/logo.png" alt="Distribuição" class="logo-footer">
</footer>

</body>
</html>
