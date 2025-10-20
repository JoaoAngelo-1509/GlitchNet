<?php
$host = "sql10.freesqldatabase.com";
$usuario = "sql10798661";
$senha = "DvlR1bjY7L";
$banco = "sql10798661";
$porta = 3306;

$conn = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

?>
