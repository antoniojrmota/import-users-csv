<?php

session_start();

include_once "conexao.php";

$arquivo = $_FILES['arquivo'];

$linhaZero = true;

$linhas_importadas = 0;
$linhas_nao_importadas = 0;
$usuarios_nao_importados = 0;

if ($arquivo['type'] == 'text/csv') {
    $dados_arquivo = fopen($arquivo['tmp_name'], "r");

    while ($linha = fgetcsv($dados_arquivo, 1000, ";")) {

        if ($linhaZero) {
            $linhaZero = false;
            continue;
        }

        array_walk_recursive($linha, 'converter');

        // insere ou atualiza
        $query = "INSERT INTO test.users (cpf, nome, email, endereco) 
              VALUES (:cpf, :nome, :email, :endereco)
              ON DUPLICATE KEY UPDATE
              nome = VALUES(nome), email = VALUES(email), endereco = VALUES(endereco)";

        // apenas insere
        // $query = "INSERT INTO test.users (cpf, nome, email, endereco) VALUES (:cpf, :nome, :email, :endereco)";

        $cpf = str_replace(['.', '-'], '', $linha[1]);
        $cad_user = $conn->prepare($query);
        $cad_user->bindValue(':nome', ($linha[0] ?? 'NULL'));
        $cad_user->bindValue(':cpf', $cpf);
        $cad_user->bindValue(':email', ($linha[2] ?? 'NULL'));
        $cad_user->bindValue(':endereco', ($linha[3] ?? 'NULL'));
        $cad_user->execute();

        if ($cad_user->rowCount()) {
            $linhas_importadas++;
        } else {
            $linhas_nao_importadas++;
            $usuarios_nao_importados = $usuarios_nao_importados . ", " . ($linha[0] ?? 'NULL');
        }
    }

    if (!empty($usuarios_nao_importados)) {
        $usuarios_nao_importados = "Usuários não importados: $usuarios_nao_importados.";
    }

    $_SESSION['msg'] = "<p style='color: green;'>$linhas_importadas linhas importadas: , $linhas_nao_importadas não importadas.</p>";
    header("Location: index.php");
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Necessário enviar arquivo csv.</p>";
    header("Location: index.php");
}

function converter($dados_arquivo)
{
    $dados_arquivo = mb_convert_encoding($dados_arquivo, "UTF-8", "ISO-8859-1");
}
