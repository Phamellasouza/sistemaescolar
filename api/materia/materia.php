<?php
require_once("../core/header.php");

function getComboTurma($codigoTurma = false){
    $arDadosTurma = array();
    $dadosTurma = @file_get_contents("../turma/turmas.json");
    if($dadosTurma){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDadosTurma = json_decode($dadosTurma, true);
    }

    $html = '<div style="display:flex;gap:5px;flex-direction:row;">';

    $html .= '  <label for="turma">Turma:</label>';
    $html .= '  <select id="turma" name="turma">';
    $html .= '    <option value="0">Selecione</option>';

    //  preencher com php - mais options de ESCOLA
    foreach($arDadosTurma as $aDados){
        $selected = "";
        if($codigoTurma == $aDados["codigo"]){
            $selected = " selected ";                    
        }

        $html .= '<option value="'. $aDados["codigo"] .'" ' . $selected .'>' . $aDados["nome"] . '</option>';
    }

    $html .= '</select>';
    $html .= '</div>';

    return $html;
}



function getDadosMateria($codigoMateriaAlterar){
    $descricao = "";
    $curso="";

    // VAI BUSCAR OS DADOS DE materia.JSON
    $dadosMateria = @file_get_contents("materia.json");

    // TRANSFORMAR EM ARRAY
    $arDadosMateria = json_decode($dadosMateria, true);

    $encontrouMateria = false;
    foreach($arDadosMateria as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoMateriaAlterar == $codigoAtual){
            $encontrouMateria = true;
            $descricao = $aDados["descricao"];
            $curso = $aDados["turma"];

            // para a execução do loop
            break;
        }
    }

    return array($descricao, $curso, $encontrouMateria);
}

// Verificar se existe acao
$codigo = "";
$descricao = "";
$curso = "";
$display = "block;";

$encontrouMateria = false;
$mensagemMateriaNaoEncontrada = "Não foi encontrada nenhuma matéria para o codigo informado!Código: ";

$acaoFormulario = "INCLUIR";
if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "ALTERAR"){
        $acaoFormulario = "ALTERAR";

        $display = "none;";
        $codigo = $_GET["codigo"];
        list($descricao, $curso, $encontrouMateria) = getDadosMateria($codigo);

        if($encontrouMateria){
            // Limpa a mensagem de erro
            $mensagemMateriaNaoEncontrado = "";
        } else {
            // Adiciona o codigo da matéria  no fim
            $mensagemMateriaNaoEncontrada .= $codigo;
        }
    }
}

$comboTurma = getComboTurma($codigo);

$sHTML = '<div> <link rel="stylesheet" href="../css/formulario.css">';


// FORMULARIO DE CADASTRO DE Matéria
$sHTML .= '<h2 style="text-align:center;">Formulário de Matéria</h2>
    <h3>' . $mensagemMateriaNaoEncontrada . '</h3>
    <form action="cadastrar_materia.php" method="POST">
        <input type="hidden" id="ACAO" name="ACAO" value="' . $acaoFormulario . '">

        <label for="codigo">Código:</label>
        <input type="hidden" id="codigo" name="codigo" value="' . $codigo . '" required>
        <input type="text" id="codigoTela" name="codigoTela" value="' . $codigo . '" disabled>
        
        ' .  $comboTurma . '
        
        <label for="descricao"> Descrição:</label>
        <input type="text" id="descricao" name="descricao" required value="' . $descricao . '">

        <input type="submit" value="Enviar">
    </form>';

// CONSULTA DE MATÉRIA
$sHTML .= '</div>';

echo $sHTML;

require_once("../core/footer.php");
