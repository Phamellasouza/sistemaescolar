<?php
function alterar_Materia(){
    $codigoMateriaAlterar = $_POST["codigo"];
    $materia = $_POST["materia"];
    $turma = $_POST["curso"];
    
    $dadosMateria = @file_get_contents("materia.json");
    $arDadosMateria = json_decode($dadosMateria, true);

    $arDadosMateriaNovo = array();
    foreach($arDadosMateria as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoMateriaAlterar == $codigoAtual){
            $aDados["materia"] = $materia;
            $aDados["curso"] = $materia;
        }

        $arDadosMateriaNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("materia.json", json_encode($arDadosMateriaNovo));
}

function excluir_Materia(){
    $codigoMateriaExcluir = $_GET["codigo"];

    $dadosMateria = @file_get_contents("materia.json");
    $arDadosMateria = json_decode($dadosMateria, true);

    $arDadosMateriaNovo = array();
    foreach($arDadosMateria as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoMateriaExcluir == $codigoAtual){
            // ignora e vai para o proximo registro
            continue;
        }

        $arDadosMateriaNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("materia.json", json_encode($arDadosMateriaNovo));
}

function incluir_Materia(){
    $arDadosMateria = array();

    // Primeiro, verifica se existe dados no arquivo json
    // @ na frente do metodo, remove o warning
    $dadosMateria = @file_get_contents("materia.json");
    if($dadosMateria){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosMateria = json_decode($dadosMateria, true);
    }

    // Armazenar os dados do matéria atual, num array associativo

    $aDadosMateriaAtual = array();
    $aDadosMateriaAtual["codigo"] = getProximoCodigo($arDadosMateria);
    $aDadosMateriaAtual["descricao"] = $_POST["descricao"];
    $aDadosMateriaAtual["curso"] = $_POST["curso"];
   

    // Pega os dados atuais do aluno e armazena no array que foi lido
    $arDadosMateria[] = $aDadosMateriaAtual;

    // Gravar os dados no arquivo
    file_put_contents("materia.json", json_encode($arDadosMateria));
}

function getProximoCodigo($arDadosmateria){
    $ultimoCodigo = 0;
    foreach($arDadosMateria as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoAtual > $ultimoCodigo){
            $ultimoCodigo = $codigoAtual;
        }      
    }

    return $ultimoCodigo + 1;
}

// PROCESSAMENTO DA PAGINA
// echo "<pre>" . print_r($_POST, true) . "</pre>";return true;
// echo "<pre>" . print_r($_GET, true) . "</pre>";return true;

// Verificar se esta setado o $_POST
if(isset($_POST["ACAO"])){
    $acao = $_POST["ACAO"];
    if($acao == "INCLUIR"){
        incluir_materia();

        // Redireciona para a pagina de consulta de materia
        header('Location: consulta_materia.php');
    } else if($acao == "ALTERAR"){        
        alterar_materia();

        // Redireciona para a pagina de consulta de materia
        header('Location: consulta_materia.php');
    }
} else if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "EXCLUIR"){
        excluir_materia();
        
        // Redireciona para a pagina de consulta de materia
        header('Location: consulta_materia.php');
    } else if($acao == "ALTERAR"){
        $codigoAlunoAlterar = $_GET["codigo"];

        // Redireciona para a pagina de materia
        header('Location: materia.php?ACAO=ALTERAR&codigo=' . $codigoMateriaAlterar);
    }
} else {
    // Redireciona para a pagina de consulta de materia
    header('Location: consulta_materia.php');
}
