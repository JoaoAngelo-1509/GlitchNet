<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>GlitchNet | Acessando...</title>
  <meta http-equiv="refresh" content="5;url=index.php">
  <style>
    body {
      background-color: black;
      color: #0099ff;
      font-family: 'Courier New', monospace;
      font-size: 1.5rem;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
    }

    .typing {
      border-right: 2px solid #0099ff;
      white-space: nowrap;
      overflow: hidden;
      width: 0;
      animation: typing 3s steps(30, end) forwards, blink 0.7s infinite;
    }

    @keyframes typing {
      from { width: 0 }
      to { width: 24ch }
    }

    @keyframes blink {
      0%, 100% { border-color: transparent }
      50% { border-color: #0099ff }
    }

    .glitch {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: #0f0;
      font-size: 2.5rem;
      font-weight: bold;
      animation: glitch 0.8s infinite;
      opacity: 0.1;
    }

    @keyframes glitch {
      0% { transform: translate(-50%, -50%) }
      20% { transform: translate(-52%, -48%) skew(2deg, 1deg); opacity: 0.2; }
      40% { transform: translate(-48%, -52%) skew(-1deg, -2deg); opacity: 0.3; }
      60% { transform: translate(-51%, -49%) skew(1deg, -1deg); opacity: 0.2; }
      80% { transform: translate(-49%, -51%) skew(-2deg, 2deg); opacity: 0.3; }
      100% { transform: translate(-50%, -50%) }
    }
  </style>
</head>
<body>
  <div>
    <div class="typing">Acessando GlitchNet...</div>
    <div class="glitch">GL1TCH_N3T</div>
  </div>
</body>
</html>
