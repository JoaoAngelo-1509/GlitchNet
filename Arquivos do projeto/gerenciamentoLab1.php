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
    <link rel="stylesheet" href="stylesgerenciamentolab1.css">
    <title>Lab1- AdminHub</title>
</head>
<body>
    <header class="glow">
    <div class="titulo">
      <h2>Gerenciamento Lab1 - ADMIN HUB</h2>
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
            <summary>PC 1 ▼</summary>
            <div class="menu-content">
                <a href="#">Problemas</a>
                <a href="#">Relatórios</a>
                <a href="#">Gerenciar</a>
            </div>
        </details>
      </li>
      <li>
          <details>
            <summary>PC 2 ▼</summary>
            <div class="menu-content">
                <a href="#">Problemas</a>
                <a href="#">Relatórios</a>
                <a href="#">Gerenciar</a>
            </div>
        </details>
      </li>
      <li>
          <details>
            <summary>PC 3 ▼</summary>
            <div class="menu-content">
                <a href="#">Problemas</a>
                <a href="#">Relatórios</a>
                <a href="#">Gerenciar</a>
            </div>
        </details>
      </li>
        <li><a href="logout_animacao.php">Encerrar Sessão</a></li>
        <li>
          <img src="images/skullfoda.png" alt="skeleton" class="glow-img decor-img">
        </li>
      </ul>
    </section>
</body>
</html>