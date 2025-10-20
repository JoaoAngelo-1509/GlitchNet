<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];
$nome = $_POST['txtnome'];
$email = $_POST['txtemail'];
$senha = $_POST['txtsenha'];

// Verifica campos obrigatórios
if (empty($nome) || empty($email)) {
    echo "Preencha nome e email.";
    exit;
}

// Verifica se o novo e-mail já existe (exceto se for o mesmo do usuário atual)
$verifica = "SELECT * FROM usuarios WHERE email = '$email' AND id != $id";
$res_verifica = mysqli_query($conn, $verifica);
if (mysqli_num_rows($res_verifica) > 0) {
    echo "Este email já está sendo usado.";
    exit;
}

// Atualiza nome e email
$sql = "UPDATE usuarios SET nome='$nome', email='$email'";

// Se a senha foi preenchida, também atualiza
if (!empty($senha)) {
    $sql .= ", senha='$senha'";
}

$sql .= " WHERE id=$id";
$resultado = mysqli_query($conn, $sql);

if ($resultado) {
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;
    echo "Dados atualizados com sucesso.";
    header("Location: painel.php");
} else {
    echo "Erro ao atualizar: " . mysqli_error($conn);
}
?>
