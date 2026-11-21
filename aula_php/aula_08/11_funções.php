<?php

// Criamos uma função responsável
// por validar um e-mail.
function validarEmail($email)
{
    // filter_var retorna o e-mail
    // caso ele seja válido.
    //
    // Caso seja inválido,
    // retorna false.
    return filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    );
}


// Criamos uma função responsável
// por limpar textos.
function limparTexto($texto)
{
    // trim remove espaços extras.
    $texto = trim($texto);

    // Retornamos o texto limpo.
    return $texto;
}

?>