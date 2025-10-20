<?php
session_start();

// Configurações do Supabase
$SUPABASE_URL = "https://huyibmcljsmridkmlafk.supabase.co";
$SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imh1eWlibWNsanNtcmlka21sYWZrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTc4ODMxODgsImV4cCI6MjA3MzQ1OTE4OH0.ixBRF60Wlc8xuIvGsizXuiVUpzr4it2UkPAGm4YHRpo";

// Função para chamar Supabase API
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
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ["body" => json_decode($response,true), "httpCode" => $httpCode, "raw" => $response];
}

$mensagem = "";

// Login via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["txtemail"];
    $senha = $_POST["txtsenha"];

    // 1) Login no Supabase Auth
    $res = supabaseRequest("auth/v1/token?grant_type=password", ["email"=>$email,"password"=>$senha]);

    if(isset($res["body"]["access_token"])) {
        $user_id = $res["body"]["user"]["id"] ?? null;

        // 2) Buscar nome na tabela usuarios
        $ch = curl_init("$SUPABASE_URL/rest/v1/usuarios?email=eq.$email&select=nome");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "apikey: $SUPABASE_KEY",
            "Authorization: Bearer $SUPABASE_KEY"
        ]);
        $resNome = curl_exec($ch);
        curl_close($ch);

        $dadosUsuario = json_decode($resNome, true);
        $nomeUsuario = $dadosUsuario[0]["nome"] ?? $email; // se não achar, usa email

        // 3) Guardar dados na sessão
        $_SESSION["id"]   = $user_id;
        $_SESSION["nome"] = $nomeUsuario;
        $_SESSION["email"] = $email;

        header("Location: painel_animacao.php");
        exit;
    } else {
        $mensagem = "Email ou senha inválidos: ".json_encode($res["body"]);
    }
}

// Mensagem de sucesso após cadastro
if(isset($_GET['sucesso']) && $_GET['sucesso'] == 1){
    $mensagem = "Cadastro realizado com sucesso! Faça o login.";
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="images/logo.png"/>
<link rel="stylesheet" href="styleslogin.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Stencil:opsz,wght@10..72,100..900&family=Libertinus+Mono&display=swap" rel="stylesheet">
<title>Log-in</title>
</head>
<body>
<h2 class="glow">Log-in</h2>

<?php if($mensagem!=""): ?>
<p style="color:red; font-weight:bold;"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<fieldset>
    <img src="images/skull.gif" class="image glow-img" alt="skull">
    <form method="POST">
        <label for="nome" class="glow">Nome de usuario:</label><br><br>
        <input type="text" name="txtnome" class="glow"><br><br>

        <label for="email" class="glow">Email:</label><br><br>
        <input type="text" name="txtemail" class="glow" required><br><br>

        <label for="senha" class="glow">Senha:</label><br><br>
        <input type="password" name="txtsenha" id="senha" class="glow" required><br><br>

        <input type="submit" value="Log-in" class="submit"><br><br>
        <h3 class="glow">Não tem uma conta?</h3><a href="cadastro.php">Cadastro</a>
    </form>

    <hr>
</fieldset>
</body>
</html>
