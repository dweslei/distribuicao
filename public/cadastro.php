<?php 
include("../config/db.php"); 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $telefone = trim($_POST["telefone"]);
    $senha = $_POST["senha"];
    $tipo = isset($_POST["tipo"]) ? trim($_POST["tipo"]) : "";

    // Verifica se o tipo foi realmente selecionado
    if ($tipo == "") {
        $erro = "Selecione o tipo de usuário.";
    } else {
        // Verifica se email já existe
        $sqlCheck = "SELECT id_usuario FROM usuario WHERE email=?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            $erro = "Este email já está cadastrado. Use outro.";
        } else {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuario (nome, email, telefone, senha, tipo) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nome, $email, $telefone, $senhaHash, $tipo);

            if ($stmt->execute()) {
                $sucesso = "Cadastro realizado com sucesso! Você já pode fazer login.";
            } else {
                $erro = "Erro ao cadastrar: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro - Distribuição</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Distribuição</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="login.php">🏠 Início</a></li>
    </ul>
  </div>
</nav>

<div class="container mt-5">
  <div class="card shadow-lg p-4" style="max-width: 500px; margin: auto;">
    <h2 class="text-center mb-4">Criar Conta</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="nome" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Telefone</label>
        <input type="text" name="telefone" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Senha</label>
        <input type="password" name="senha" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Tipo de Usuário</label>
        <select name="tipo" class="form-select" required>
          <option value="">Selecione...</option>
          <option value="admin">Administrador</option>
          <option value="voluntario">Voluntário</option>
          <option value="doador">Doador</option>
          <option value="beneficiario">Beneficiário</option>
          <option value="deposito">Depósito</option>
        </select>
      </div>
      <button type="submit" class="btn btn-success w-100">Cadastrar</button>
    </form>

    <?php if(isset($sucesso)): ?>
      <div class="alert alert-success text-center mt-3"><?php echo $sucesso; ?></div>
    <?php endif; ?>
    <?php if(isset($erro)): ?>
      <div class="alert alert-danger text-center mt-3"><?php echo $erro; ?></div>
    <?php endif; ?>

    <div class="text-center mt-3">
      <a href="login.php" class="text-decoration-none">Já tem conta? Faça login</a>
    </div>
  </div>
</div>

<footer class="text-center mt-5">
  <img src="../assets/logo.png" alt="Distribuição" class="logo-footer">
</footer>

</body>
</html>
