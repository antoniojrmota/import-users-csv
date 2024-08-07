<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar .csv</title>
</head>
<body>
    <h1>Importar</h1>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="post" enctype="multipart/form-data" action="importa.php">
        <label for="arquivo">Arquivo:</label>
        <input type="file" name="arquivo" id="arquivo">
        <br><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>