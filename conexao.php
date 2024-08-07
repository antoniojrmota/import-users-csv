<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

try {

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $conn = new PDO($dsn, $username, $password, $options);

    echo "Conexão bem-sucedida!";

} catch (PDOException $e) {
    // Se houver um erro na conexão, exibe a mensagem de erro
    echo "Erro: " . $e->getMessage();
}