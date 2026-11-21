<?php

// --------------------------------------------------
// LISTAGEM DE ALUNOS
// SELECT + LIKE + FILTRO + ORDENAÇÃO + PAGINAÇÃO
// --------------------------------------------------

require_once "conexao.php";

// --------------------------------------------------
// PARÂMETROS DA URL
// --------------------------------------------------

// Pesquisa digitada pelo usuário.
$pesquisa = trim($_GET["pesquisa"] ?? "");

// Curso selecionado no filtro.
$curso = trim($_GET["curso"] ?? "");

// Opção de ordenação.
$ordem = $_GET["ordem"] ?? "nome_asc";

// Página atual.
$pagina = (int) ($_GET["pagina"] ?? 1);

// Evitamos páginas menores que 1.
if ($pagina < 1) {
    $pagina = 1;
}

// Quantidade de registros por página.
$porPagina = 5;

// Calculamos quantos registros serão ignorados.
$offset = ($pagina - 1) * $porPagina;


// --------------------------------------------------
// ORDENAÇÃO
// --------------------------------------------------

// Não colocamos diretamente qualquer valor recebido
// pelo usuário dentro do ORDER BY.
//
// Criamos uma lista de opções permitidas.
switch ($ordem) {

    case "nome_desc":
        $orderBy = "nome DESC";
        break;

    case "email_asc":
        $orderBy = "email ASC";
        break;

    case "curso_asc":
        $orderBy = "curso ASC";
        break;

    default:
        $orderBy = "nome ASC";
        $ordem = "nome_asc";
}


// --------------------------------------------------
// FILTROS
// --------------------------------------------------

$condicoes = [];
$parametros = [];

// Pesquisa por nome OU e-mail.
if ($pesquisa !== "") {

    $condicoes[] = "
        (
            nome LIKE :pesquisa_nome
            OR email LIKE :pesquisa_email
        )
    ";

    $parametros[":pesquisa_nome"] =
        "%" . $pesquisa . "%";

    $parametros[":pesquisa_email"] =
        "%" . $pesquisa . "%";
}

// Filtro exato por curso.
if ($curso !== "") {

    $condicoes[] = "curso = :curso";

    $parametros[":curso"] = $curso;
}

// Criamos o WHERE somente quando houver filtros.
$where = "";

if (count($condicoes) > 0) {

    $where =
        " WHERE "
        . implode(
            " AND ",
            $condicoes
        );
}


// --------------------------------------------------
// CONTAGEM TOTAL
// --------------------------------------------------

// Antes da consulta principal,
// contamos quantos registros atendem aos filtros.
//
// Isso será utilizado para calcular
// quantas páginas existem.
$sqlTotal = "
    SELECT COUNT(*)
    FROM alunos
    {$where}
";

$stmtTotal =
    $pdo->prepare($sqlTotal);

// Associamos os parâmetros encontrados.
foreach (
    $parametros
    as $nomeParametro => $valorParametro
) {

    $stmtTotal->bindValue(
        $nomeParametro,
        $valorParametro,
        PDO::PARAM_STR
    );
}

$stmtTotal->execute();

$totalRegistros =
    (int) $stmtTotal->fetchColumn();

$totalPaginas =
    (int) ceil(
        $totalRegistros / $porPagina
    );


// --------------------------------------------------
// CONSULTA PRINCIPAL
// --------------------------------------------------

$sql = "
    SELECT
        id,
        nome,
        email,
        curso
    FROM alunos
    {$where}
    ORDER BY {$orderBy}
    LIMIT :limite
    OFFSET :offset
";

$stmt = $pdo->prepare($sql);

// Ligamos os filtros.
foreach (
    $parametros
    as $nomeParametro => $valorParametro
) {

    $stmt->bindValue(
        $nomeParametro,
        $valorParametro,
        PDO::PARAM_STR
    );
}

// LIMIT e OFFSET devem ser inteiros.
$stmt->bindValue(
    ":limite",
    $porPagina,
    PDO::PARAM_INT
);

$stmt->bindValue(
    ":offset",
    $offset,
    PDO::PARAM_INT
);

$stmt->execute();

// fetchAll() retorna todos os registros encontrados.
$alunos =
    $stmt->fetchAll(
        PDO::FETCH_ASSOC
    );


// --------------------------------------------------
// CURSOS PARA O FILTRO
// --------------------------------------------------

$sqlCursos = "
    SELECT DISTINCT curso
    FROM alunos
    ORDER BY curso ASC
";

$cursos =
    $pdo
        ->query($sqlCursos)
        ->fetchAll(
            PDO::FETCH_COLUMN
        );

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>
        Lista de Alunos
    </title>

</head>

<body>

    <h1>
        Alunos cadastrados
    </h1>

    <p>
        <a href="cadastro_aluno.php">
            Cadastrar novo aluno
        </a>
    </p>

    <!--
        Usamos GET porque pesquisa,
        filtro, ordenação e paginação
        podem aparecer na URL.
    -->
    <form method="GET">

        <label for="pesquisa">
            Pesquisa:
        </label>

        <input
            type="text"
            id="pesquisa"
            name="pesquisa"
            placeholder="Nome ou e-mail"
            value="<?= htmlspecialchars(
                $pesquisa,
                ENT_QUOTES,
                "UTF-8"
            ) ?>"
        >

        <label for="curso">
            Curso:
        </label>

        <select
            id="curso"
            name="curso"
        >

            <option value="">
                Todos
            </option>

            <?php foreach ($cursos as $itemCurso): ?>

                <option
                    value="<?= htmlspecialchars(
                        $itemCurso,
                        ENT_QUOTES,
                        "UTF-8"
                    ) ?>"
                    <?= $curso === $itemCurso
                        ? "selected"
                        : "" ?>
                >
                    <?= htmlspecialchars(
                        $itemCurso,
                        ENT_QUOTES,
                        "UTF-8"
                    ) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <label for="ordem">
            Ordenar:
        </label>

        <select
            id="ordem"
            name="ordem"
        >

            <option
                value="nome_asc"
                <?= $ordem === "nome_asc"
                    ? "selected"
                    : "" ?>
            >
                Nome A-Z
            </option>

            <option
                value="nome_desc"
                <?= $ordem === "nome_desc"
                    ? "selected"
                    : "" ?>
            >
                Nome Z-A
            </option>

            <option
                value="email_asc"
                <?= $ordem === "email_asc"
                    ? "selected"
                    : "" ?>
            >
                E-mail A-Z
            </option>

            <option
                value="curso_asc"
                <?= $ordem === "curso_asc"
                    ? "selected"
                    : "" ?>
            >
                Curso A-Z
            </option>

        </select>

        <button type="submit">
            Aplicar
        </button>

    </form>

    <p>
        Registros encontrados:
        <strong>
            <?= $totalRegistros ?>
        </strong>
    </p>

    <table
        border="1"
        cellpadding="8"
        cellspacing="0"
    >

        <thead>

            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Curso</th>
                <th>Ações</th>
            </tr>

        </thead>

        <tbody>

            <?php if (count($alunos) === 0): ?>

                <tr>

                    <td colspan="5">
                        Nenhum aluno encontrado.
                    </td>

                </tr>

            <?php else: ?>

                <?php foreach ($alunos as $aluno): ?>

                    <tr>

                        <td>
                            <?= (int) $aluno["id"] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $aluno["nome"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $aluno["email"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $aluno["curso"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>

                        <td>

                            <!--
                                Passamos o ID pela URL
                                para identificar o registro.
                            -->
                            <a href="editar_aluno.php?id=<?= (int) $aluno["id"] ?>">
                                Editar
                            </a>

                            |

                            <a href="excluir_aluno.php?id=<?= (int) $aluno["id"] ?>">
                                Excluir
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

        </tbody>

    </table>


    <!-- PAGINAÇÃO -->
    <?php if ($totalPaginas > 1): ?>

        <p>
            Páginas:
        </p>

        <?php
        for (
            $i = 1;
            $i <= $totalPaginas;
            $i++
        ):
        ?>

            <?php

            // Preservamos todos os filtros
            // quando alteramos somente a página.
            $linkPagina =
                "listar_alunos.php?"
                . http_build_query([
                    "pesquisa" => $pesquisa,
                    "curso" => $curso,
                    "ordem" => $ordem,
                    "pagina" => $i
                ]);

            ?>

            <?php if ($i === $pagina): ?>

                <strong>
                    <?= $i ?>
                </strong>

            <?php else: ?>

                <a href="<?= htmlspecialchars(
                    $linkPagina,
                    ENT_QUOTES,
                    "UTF-8"
                ) ?>">
                    <?= $i ?>
                </a>

            <?php endif; ?>

        <?php endfor; ?>

    <?php endif; ?>

</body>

</html>