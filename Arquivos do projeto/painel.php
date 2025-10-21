<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$nomeUsuario = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylespainel.css">
  <title>Painel - GlitchNet</title>
</head>
<body>

  <header class="glow">
    <div class="titulo">
      <h2>GlitchNet - HUB</h2>
    </div>

    <div class="user-area">
      <p><?php echo htmlspecialchars($nomeUsuario); ?> |</p>
      <img src="images/profile.jpg" alt="profile" class="profile-image">
    </div>
  </header>

  <div class="mainpage">
    <section class="side-main">
      <ul>
        <li><a href="#">Usuários</a></li>
        <li><a href="painelmensagem.php">Terminal de Mensagens</a></li>
        <li><a href="editar_perfil.php">Editar Perfil</a></li>
        <li><a href="logout_animacao.php">Encerrar Sessão</a></li>
        <li>
          <img src="images/skullfoda.png" alt="skeleton" class="glow-img decor-img">
        </li>
      </ul>
    </section>

    <main>

      <div class="console">

        <p>Bem-vindo ao sistema, <?php echo htmlspecialchars($nomeUsuario); ?>.</p>
        <a href="paineladmin.php">Adm</a>
        <a href="gerenciamentoLab1.php">Adm</a>

      </div>

    </main>
  </div>

</body>
</html>
