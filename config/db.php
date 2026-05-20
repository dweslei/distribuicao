<?php
$host = "localhost";
$user = "root"; // usuário padrão do XAMPP
$pass = "";     // senha padrão (vazia no XAMPP)
$db   = "distribuicao";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
