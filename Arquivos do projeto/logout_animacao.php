<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Saindo...</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: black;
      color: #0099ff;
      font-family: 'Courier New', monospace;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
    }

    .typing-container {
      font-size: 2rem;
      text-align: center;
      white-space: nowrap;
      overflow: hidden;
      border-right: 2px solid #0099ff;
      width: 0;
      animation: typing 2s steps(28, end) forwards, glow 1.5s infinite alternate;
    }

    @keyframes typing {
      from { width: 0; }
      to { width: 28ch; }
    }

    @keyframes glow {
      from {
        text-shadow: 0 0 5px #0099ff, 0 0 10px #0099ff;
      }
      to {
        text-shadow: 0 0 15px #0099ff, 0 0 30px #0099ff;
      }
    }
  </style>

  <!-- Redireciona para logout.php após 2.2 segundos -->
  <meta http-equiv="refresh" content="2.2;url=logout.php">
</head>
<body>
  <div class="typing-container">
    Encerrando sessão... Aguarde.
  </div>
</body>
</html>
