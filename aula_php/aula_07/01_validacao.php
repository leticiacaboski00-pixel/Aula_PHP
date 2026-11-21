<?php

// Criamos variáveis vazias para armazenar
// os valores recebidos pelo formulário.
$nome = "";
$email = "";
$idade = "";

// Criamos uma variável para armazenar
// uma possível mensagem de erro.
$mensagem = "";

// Verificamos se a página foi chamada
// através do método POST.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recebemos o nome enviado pelo formulário.
    // O ?? "" evita erro caso o campo não exista.
    $nome = $_POST["nome"] ?? "";

    // Removemos espaços do início e do final.
    $nome = trim($nome);

    // Recebemos o e-mail enviado pelo formulário.
    $email = $_POST["email"] ?? "";

    // Removemos espaços desnecessários.
    $email = trim($email);

    // Recebemos a idade.
    $idade = $_POST["idade"] ?? "";

    // Verificamos se o nome ficou vazio.
    if ($nome === "") {

        // Guardamos uma mensagem de erro.
        $mensagem = "O nome é obrigatório.";

    // Validamos o formato do e-mail.
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // Caso o e-mail não seja válido.
        $mensagem = "Informe um e-mail válido.";

    // Convertemos a idade para inteiro
    // e verificamos se é maior que zero.
    } elseif ((int) $idade <= 0) {

        // Caso a idade seja inválida.
        $mensagem = "Informe uma idade válida.";

    } else {

        // Protegemos o nome antes de mostrar
        // o conteúdo dentro do HTML.
        // serve para transformar caracteres especiais de HTML em texto seguro para exibição no navegador.
        // Caso o user coloque um <h1> TEXTO </h1> não permitirá que o HTML interprete como titulo
        $nomeSeguro = htmlspecialchars(
            $nome,
            ENT_QUOTES,
            "UTF-8"
        );

        // Protegemos o e-mail antes da saída.
        $emailSeguro = htmlspecialchars(
            $email,
            ENT_QUOTES, # ENT_QUOTES é uma opção usada dentro do htmlspecialchars() para dizer ao PHP que ele deve converter tanto aspas duplas quanto aspas simples em entidades HTML.
            "UTF-8"
        );

        // Criamos a mensagem final.
        $mensagem =
            "Cadastro realizado: "
            . $nomeSeguro
            . " - "
            . $emailSeguro;
    }
}

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>
        Validação de formulário
    </title>

</head>

<body>

    <h1>
        Cadastro
    </h1>

    <form method="POST">

        <label>
            Nome:
        </label>

        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($nome) ?>"
        >

        <br><br>

        <label>
            E-mail:
        </label>

        <input
            type="text"
            name="email"
            value="<?= htmlspecialchars($email) ?>"
        >

        <br><br>

        <label>
            Idade:
        </label>

        <input
            type="number"
            name="idade"
            value="<?= htmlspecialchars($idade) ?>"
        >

        <br><br>

        <button type="submit">
            Cadastrar
        </button>

    </form>

    <?php

    // Verificamos se existe alguma mensagem.
    if ($mensagem !== "") {

        // Mostramos a mensagem.
        echo "<p>{$mensagem}</p>";
    }

    ?>

</body>

</html>