<?php
include("../config/db.php");
session_start();

// Garante que qualquer sessão antiga seja limpa
session_unset();
session_destroy();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    // Busca apenas o usuário com o email informado
    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verifica a senha
        if (password_verify($senha, $user["senha"])) {
            // Salva dados na sessão
            $_SESSION["id"] = $user["id_usuario"];
            $_SESSION["usuario"] = $user["nome"];
            $_SESSION["tipo"] = $user["tipo"];

            // Redireciona para o dashboard e encerra
            header("Location: dashboard.php");
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - Distribuição</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container mt-5">
  <div class="card shadow-lg p-4" style="max-width: 400px; margin: auto;">
    <h2 class="text-center mb-4">Login</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required autocomplete="off" value="">
      </div>
      <div class="mb-3">
        <label class="form-label">Senha</label>
        <input type="password" name="senha" class="form-control" required autocomplete="off" value="">
      </div>
      <button type="submit" class="btn btn-primary w-100">Entrar</button>
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
