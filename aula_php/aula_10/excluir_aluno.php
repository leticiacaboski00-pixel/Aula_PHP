<?php

    require_once("conexao.php");

     // Array para armazenar os erros
    $erros = [];

    $id = filter_input(
        INPUT_GET,
        "id",
        FILTER_VALIDATE_INT
    );

    //verifica se é um ID valido 
    if($id === false || $id === null) {
        die("ID inválido!");
    }


     //Buscando o aluno a ser editado
    $sql = "
        SELECT 
            id,
            nome,
            email,
            curso
        FROM alunos
        WHERE id = :id
    
    ";

    //prepara o statement
    $stmt = $pdo->prepare($sql);

    //substitui o espaço em memoria pela variavel de ID
    $stmt->bindValue(
        ":id",
        $id,
        PDO::PARAM_INT
    );

    //Executa a query 
    $stmt->execute();

    //Retornar somente o usuario que vamos editar 
    $aluno = $stmt->fetch(
        PDO::FETCH_ASSOC
    );


     //Cria variaveis com o retorno do banco 
    $nome = $aluno["nome"];
    $email = $aluno["email"];
    $curso = $aluno["curso"];
    
    //Processamento do formulario de edição 
    if ($_SERVER["REQUEST_METHOD"] === "POST"){

        $sqlDelete = "
            DELETE FROM alunos
            WHERE id = :id
        ";


        //preparar a query
        $stmtDelete = $pdo->prepare($sqlDelete);

        //seta no espaço em memoria os valores da variavel nome
        $stmtDelete->bindValue(
            ":id",
            $id,
            PDO::PARAM_INT
        );

        //Executar query
        $stmtDelete->execute();

        //voltamos para a página de lista de alunos
        header("Location: listar_alunos.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Aluno</title>
</head>
<body>
    <h1>Excluir Aluno</h1>

    <h3>Você realmente deseja excluir? </h3>

    <p><?
        htmlspecialchars(
            $nome,
            ENT_QUOTES,
            "UTF-8"
        )
    ?></p>


    <form method="POST">
        <button type="submit">Confirmar Exclusão</button>
    </form>

     <p> 
        <a href="listar_alunos.php">
            Cancelar
        </a>
    </p>
</body>
</html>