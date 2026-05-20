<?php
include("../config/db.php");
session_start();

// Proteção extra: só pode editar o próprio cadastro
if (!isset($_GET["id"]) || $_GET["id"] != $_SESSION["id"]) {
    die("Você não tem permissão para editar este cadastro.");
}

$id = intval($_GET["id"]);

// Busca dados atuais
$sql = "SELECT * FROM usuario WHERE id_usuario=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Usuário não encontrado.");
}

$user = $result->fetch_assoc();

// Atualiza dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $senha = $_POST["senha"];

    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE usuario SET nome=?, email=?, telefone=?, senha=? WHERE id_usuario=?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ssssi", $nome, $email, $telefone, $senhaHash, $id);
    } else {
        $sqlUpdate = "UPDATE usuario SET nome=?, email=?, telefone=? WHERE id_usuario=?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("sssi", $nome, $email, $telefone, $id);
    }

    if ($stmtUpdate->execute()) {
        $_SESSION["flash"] = "Cadastro atualizado com sucesso!";
        header("Location: dashboard.php");
        exit();
    } else {
        $erro = "Erro ao atualizar: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Cadastro</title>
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
  <div class="card shadow-lg p-4" style="max-width: 500px; margin: auto;">
    <h2 class="text-center mb-4">Editar Cadastro</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Telefone</label>
        <input type="text" name="telefone" class="form-control" value="<?php echo htmlspecialchars($user['telefone']); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Senha (deixe em branco se não quiser alterar)</label>
        <input type="password" name="senha" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
    </form>

    <?php if(isset($erro)): ?>
      <div class="alert alert-danger text-center mt-3"><?php echo $erro; ?></div>
    <?php endif; ?>
  </div>
</div>

<footer class="text-center mt-5">
  <img src="../assets/logo.png" alt="Distribuição" class="logo-footer">
</footer>

</body>
</html>
