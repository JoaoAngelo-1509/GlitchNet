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
  <link rel="stylesheet" href="stylepainelmsg.css">
  <title>Painel Admin- GlitchNet</title>
</head>
<body>

  <header class="glow">
    <div class="titulo">
      <h2>Terminal de Mensagens - HUB</h2>
    </div>

    <div class="user-area">
      <p><?php echo htmlspecialchars($nomeUsuario); ?> |</p>
      <img src="images/profile.jpg" alt="profile" class="profile-image">
    </div>
  </header>

  <div class="mainpage">
    <section class="side-main">
      <ul>
        <li>
          <details>
            <summary>Ajuda</summary>
            <div class="menu-content">
                <a href="serviços.php">Pedir Ajuda</a>
            </div>
        </details>
        </li>
        <li><a href="#">Amigos</a></li>
        <li><a href="#">Comunidade</a></li>
        <li>
          <details>
            <summary>Mensagens diretas ▼</summary>
            <div class="menu-content">
                <a href="#">Jão</a>
                <a href="#">Blanco</a>
                <a href="#">TheIlusion</a>
            </div>
        </details>
        </li>
        <li>
          <details>
            <summary> Grupos ▼</summary>
            <div class="menu-content">
                <a href="#">gp 1</a>
                <a href="#">gp 2</a>
                <a href="#">gp 3</a>
            </div>
        </details>
      </li>
        

        <li><a href="logout_animacao.php">Encerrar Sessão</a></li>
        <li>
          <img src="images/skullfoda.png" alt="skeleton" class="glow-img decor-img">
        </li>
      </ul>
    </section>

    <main>

      <div class="console">

        <p>Bem-vindo ao sistema, <?php echo htmlspecialchars($nomeUsuario); ?>.</p>

      </div>

    </main>
  </div>

</body>
</html>
