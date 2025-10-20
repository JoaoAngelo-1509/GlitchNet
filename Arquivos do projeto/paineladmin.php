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
  <link rel="stylesheet" href="styleadminpainel.css">
  <title>Painel Admin- GlitchNet</title>
</head>
<body>

  <header class="glow">
    <div class="titulo">
      <h2>GlitchNet - ADMIN HUB</h2>
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
        <li><a href="#">Terminal de Mensagens</a></li>
        <li>
          <details>
            <summary>Laboratórios ▼</summary>
            <div class="menu-content">
                <a href="gerenciamentoLab1.php">Lab 1</a>
                <a href="#">Lab 2</a>
                <a href="#">Lab 3</a>
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
