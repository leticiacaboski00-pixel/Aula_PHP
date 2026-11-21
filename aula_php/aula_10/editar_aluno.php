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


    //Caso o ID nao seja encontrado, retorna um erro 
    if(!$aluno){
        die("Aluno não encontrado!");
    }

    
    //Cria variaveis com o retorno do banco 
    $nome = $aluno["nome"];
    $email = $aluno["email"];
    $curso = $aluno["curso"];
    
    //Processamento do formulario de edição 
    if ($_SERVER["REQUEST_METHOD"] === "POST"){

        //Verifica se os campos estão vazios
        if($nome === "" ){
            $erros[] = "O nome é obrigatório!!!";
        }
        elseif($email === ""){
            $erros[] = "O email é obrigatório!!!";
        }

        //Prepara o UPDATE dos dados 
        if(count($erros) === 0){
            //String de UPDATE
            $sqlUpdate = 
            "
                UPDATE alunos 
                SET 
                    nome =  :nome,
                    email = :email,
                    curso = :curso
                WHERE id =  :id 
            
            ";
            //preparar a query
            $stmtUpdate = $pdo->prepare($sqlUpdate);

            //seta no espaço em memoria os valores da variavel nome
            $stmtUpdate->bindValue(
                ":nome",
                $nome,
                PDO::PARAM_STR
            );

            $stmtUpdate->bindValue(
                ":email",
                $email,
                PDO::PARAM_STR
            );

            $stmtUpdate->bindValue(
                ":curso",
                $curso,
                PDO::PARAM_STR
            );

            $stmtUpdate->bindValue(
                ":id",
                $id,
                PDO::PARAM_INT
            );


            //Executar query
            $stmtUpdate->execute();

            //voltamos para a página de lista de alunos
            header("Location: listar_alunos.php");

            exit;

        }
    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
</head>
<body>
    
    <h1>Editar Alunos</h1>

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

        <button type="submit">Salvar Alterações</button>
    </form>

    <p> 
        <a href="listar_alunos.php">
            Voltar para a listagem
        </a>
    </p>

</body>
</html>