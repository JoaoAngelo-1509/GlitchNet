<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações Supabase
$SUPABASE_URL = "https://huyibmcljsmridkmlafk.supabase.co";
$SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imh1eWlibWNsanNtcmlka21sYWZrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTc4ODMxODgsImV4cCI6MjA3MzQ1OTE4OH0.ixBRF60Wlc8xuIvGsizXuiVUpzr4it2UkPAGm4YHRpo";

// Função para requisições Supabase
function supabaseRequest($endpoint, $data = null, $method = "POST") {
    global $SUPABASE_URL, $SUPABASE_KEY;

    $ch = curl_init("$SUPABASE_URL/$endpoint");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $SUPABASE_KEY",
        "Authorization: Bearer $SUPABASE_KEY",
        "Content-Type: application/json"
    ]);
    if ($data) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);

    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        die('Erro de conexão: ' . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ["body" => json_decode($response, true), "httpCode" => $httpCode, "raw" => $response];
}

// Processa cadastro
$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["txtnome"]);
    $email = trim($_POST["txtemail"]);
    $senha = $_POST["txtsenha"];
    $confirmar = $_POST["txtconfirmar"];

    if ($senha !== $confirmar) {
        $mensagem = "As senhas não coincidem!";
    } elseif (strlen($senha) < 6) {
        $mensagem = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        // 1️⃣ Cria usuário no Auth
        $resAuth = supabaseRequest("auth/v1/signup", [
            "email" => $email,
            "password" => $senha
        ]);

        // Ajuste: verifica id corretamente
        $uid = $resAuth["body"]["user"]["id"] ?? $resAuth["body"]["id"] ?? null;

        if ($uid) {
            // 2️⃣ Salva na tabela 'usuarios' com hash da senha
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $resTable = supabaseRequest("rest/v1/usuarios", [
                "id" => $uid,
                "nome" => $nome,
                "email" => $email,
                "senha" => $senha_hash
            ]);

            if ($resTable["httpCode"] >= 400) {
                // Remove usuário Auth se falhar insert
                supabaseRequest("auth/v1/admin/users/$uid", null, "DELETE");
                $mensagem = "Erro ao salvar na tabela usuarios: HTTP " . $resTable["httpCode"] . " - " . $resTable["raw"];
            } else {
                $_SESSION['nome'] = $nome;
                header("Location: login.php?sucesso=1");
                exit;
            }
        } else {
            $mensagem = "Erro no Auth: " . json_encode($resAuth["body"]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="images/logo.png" />
<link rel="stylesheet" href="stylesindex.css">
<title>Cadastro</title>
</head>
<body>
<h2 class="glow">Cadastro de Usuário</h2>

<?php if($mensagem != ""): ?>
<p style="color:red; font-weight:bold;"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<form method="POST">
    <fieldset>
        <img src="images/joinus.gif" class="image glow-img" alt="joinus"><br><br>

        <label for="nome" class="glow">Nome de usuário:</label><br><br>
        <input type="text" name="txtnome" id="nome" class="glow" required value="<?= isset($nome) ? htmlspecialchars($nome) : "" ?>"><br><br>

        <label for="email" class="glow">E-mail:</label><br><br>
        <input type="email" name="txtemail" id="email" class="glow" required value="<?= isset($email) ? htmlspecialchars($email) : "" ?>"><br><br>

        <label for="senha" class="glow">Senha:</label><br><br>
        <input type="password" name="txtsenha" id="senha" class="glow" required><br><br>

        <label for="confirmar" class="glow">Confirmar Senha:</label><br><br>
        <input type="password" name="txtconfirmar" id="confirmar" class="glow" required><br><br>

        <input type="submit" value="Cadastrar" class="submit">
        <h3 class="glow">Já tem uma conta?</h3><a href="login.php">Log-in</a>
    </fieldset>
</form>
</body>
</html>
