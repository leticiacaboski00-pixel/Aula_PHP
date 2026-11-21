<?php
    // Classe responsável por cadastrar alunos

    //importação da classe de conexão
    require_once("conexao.php");

    //Cria variaveis que serão usadas no form
    $nome  = "";
    $email = "";
    $curso = "";

    // Cria um array para preencher os erros obtidos pela aplicação
    $erro = [];

    //mostra mensagem de sucesso para o user
    $sucesso = "";

    //Processamento do formulario 
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $curso = $_POST["curso"];

        if ($nome === ""){
            $erro[] = "Informe um nome válido!";
        }

        //Guarda os dados no banco somente se não houver erros
        if(count($erro) == 0){
            $sql = "
                INSERT INTO alunos (nome,email,curso) 
                VALUES ( :nome, :email, :curso ) 
            ";
            
            //O banco passa a reconhecer o texto da variavel SQL como uma query de fato.
            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(
                ":nome",
                $nome,
                PDO::PARAM_STR
            );

            $stmt->bindValue(
                ":email",
                $email,
                PDO::PARAM_STR
            );

            $stmt->bindValue(
                ":curso",
                $curso,
                PDO::PARAM_STR
            );
            
            $stmt->execute();

            //Criamos mensagem de sucesso
            $sucesso = "Aluno Cadastrado com sucesso!";
            
            //Limpamos os campos após cadastro
            $nome =  "";
            $email = "";
            $curso = "";

        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
</head>
<body>

    <h1>Cadastro de Alunos</h1>

    <?php

    #Mensagens de erro 

    if (count($erro) > 0){

        echo "<h2>Verifique os dados: </h2>";
        echo "<ul>";

        foreach ($erro as $e) {
            echo 
            "<li>".
                htmlspecialchars(
                    $e,
                    ENT_QUOTES
                )
            ."</li>";

        }

        echo "</ul>";

    }

    #Mensagem de sucesso 
    if($sucesso != ""){
        echo 
            "<p>".
                htmlspecialchars(
                    $sucesso,
                    ENT_QUOTES
                )
            ."</p>";
    }

    ?>




    <form method="POST">
        
        <!--Campo Nome -->
        <label for="nome">Nome:</label>
        <input type="text" 
               id="nome" 
               name="nome"
               value = "<?= htmlspecialchars($nome, ENT_QUOTES , "UTF-8")?>"
        >
        <br>

        <!--Campo email -->
        <label for="email">email:</label>
        <input type="text" 
               id="email" 
               name="email"
               value = "<?= htmlspecialchars($email, ENT_QUOTES , "UTF-8")?>"
        >
        <br>

        <!--Campo curso -->
        <label for="curso">curso:</label>
        <input type="text" 
               id="curso" 
               name="curso"
               value = "<?= htmlspecialchars($curso, ENT_QUOTES , "UTF-8")?>"
        >
        <br>

        <button type="submit">Cadastrar</button>
    </form>

    <p> 
        <a href="listar_alunos.php">
            Ver Alunos Cadastrados
        </a>
    </p>
</body>
</html>