<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleserro.css">
    <title>Erro</title>
</head>
<body>
    <a href="login.php" class="erro">Retornar</a>
</body>
</html>



<?php
session_start();
include('conexao.php');

$nome = $_POST['txtnome'];
$email = $_POST['txtemail'];
$senha = $_POST['txtsenha'];


if (empty($nome) || empty($email) || empty($senha)) {
    echo "<h2>Preencha todos os dados.</h2>";
    exit;
}

$sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) == 1) {
    $usuario = mysqli_fetch_assoc($resultado);

    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['email'] = $usuario['email'];
    $_SESSION['imagem'] = $usuario['imagem'];


    header("Location: painel_animacao.php");

    exit;
} else {
    echo "<div class='erro'>Email, nome ou senha inválidos.</div>";
}
?>
