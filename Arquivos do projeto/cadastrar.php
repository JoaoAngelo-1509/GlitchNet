<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleserro.css">
    <title>Erro</title>
</head>
<body>
    <a href="index.php" class="erro"> Retornar</a>
</body>
</html>



<?php
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['txtnome'];
    $email = $_POST['txtemail'];
    $senha = $_POST['txtsenha'];
    $confirmar = $_POST['txtconfirmar'];

    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar)) {
        echo "<div class='erro'>Preencha todos os dados.</div>";
        exit;
    }

    if ($senha !== $confirmar) {
        echo "<div class='erro'>As senhas não coincidem.</div>";
        exit;
    }

    $verifica = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conn, $verifica);

    if (mysqli_num_rows($resultado) > 0) {
        echo "<div class='erro'>Email já cadastrado.</div>";
        exit;
    }

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    $res = mysqli_query($conn, $sql);

    if ($res) {
       
        header("Location: cadastro_animacao.php?sucesso=1");

        exit;
    } else {
        echo "<div class='erro'>Erro ao cadastrar: </div>" . mysqli_error($conn);
    }
}
?>
