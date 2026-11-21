<?php

// Recuperamos a sessão.
session_start();

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>
        Resultado
    </title>

</head>

<body>

    <h1>
        Sistema
    </h1>

    <?php

    // Verificamos se existe
    // uma mensagem armazenada.
    if (isset($_SESSION["mensagem"])) {

        // Mostramos a mensagem.
        echo "<p>"
            . $_SESSION["mensagem"]
            . "</p>";

        // Depois que mostramos,
        // removemos a mensagem.
        unset(
            $_SESSION["mensagem"]
        );
    }

    ?>

</body>

</html>