<?php

// Criamos as variáveis inicialmente vazias.
$nome = "";
$email = "";
$idade = "";

// Verificamos se o formulário foi enviado.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Buscamos o campo "nome" diretamente
    // da requisição POST.
    $nome = filter_input(
        INPUT_POST,
        "nome"
    );

    // Removemos espaços extras.
    $nome = trim($nome ?? "");

    // Buscamos o e-mail e já pedimos
    // ao PHP que valide seu formato.
    $email = filter_input(
        INPUT_POST,
        "email",
        FILTER_VALIDATE_EMAIL
    );

    // Buscamos a idade e verificamos
    // se ela representa um número inteiro.
    $idade = filter_input(
        INPUT_POST,
        "idade",
        FILTER_VALIDATE_INT
    );

    // Validamos o nome.
    if ($nome === "") {

        echo "Nome obrigatório.";

    // Quando FILTER_VALIDATE_EMAIL falha,
    // o resultado será false.
    } elseif ($email === false) {

        echo "E-mail inválido.";

    // Quando FILTER_VALIDATE_INT falha,
    // o resultado também será false.
    } elseif ($idade === false || $idade <= 0) {

        echo "Idade inválida.";

    } else {

        // Protegemos o nome antes de exibir.
        $nomeSeguro = htmlspecialchars(
            $nome,
            ENT_QUOTES,
            "UTF-8"
        );

        // Exibimos os dados.
        echo "Nome: {$nomeSeguro}<br>";

        echo "E-mail: {$email}<br>";

        echo "Idade: {$idade}";
    }
}

?>

<form method="POST">

    <label>
        Nome:
    </label>

    <input
        type="text"
        name="nome"
    >

    <br><br>

    <label>
        E-mail:
    </label>

    <input
        type="text"
        name="email"
    >

    <br><br>

    <label>
        Idade:
    </label>

    <input
        type="number"
        name="idade"
    >

    <br><br>

    <button type="submit">
        Enviar
    </button>

</form>