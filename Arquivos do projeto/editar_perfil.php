<?php
session_start();
include('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];
$sql = "SELECT * FROM usuarios WHERE id = $id";
$res = mysqli_query($conn, $sql);
$usuario = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Perfil</title>
</head>
<body>
  <h2>Editar Perfil</h2>
  <form method="POST" action="atualizar_perfil.php" >
    <label>Nome:</label><br>
    <input type="text" name="txtnome" value="<?php echo $usuario['nome']; ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="txtemail" value="<?php echo $usuario['email']; ?>"><br><br>

    <label>Nova Senha (deixe em branco para não alterar):</label><br>
    <input type="password" name="txtsenha"><br><br>

    <input type="submit" value="Atualizar">
  </form>
</body>
</html>
