<?php

// Recuperamos a sessão atual.
session_start();

// Removemos todas as variáveis
// armazenadas dentro da sessão.
session_unset();

// Encerramos a sessão.
session_destroy();

// Mostramos uma mensagem.
echo "Sessão encerrada.";

?>