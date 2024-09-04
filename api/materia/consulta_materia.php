<?php

function getNomeTurma($codigoTurma){    
    $arDados = array();
    $dados = @file_get_contents("../turma/turmas.json");
    if($dados){
        $arDados = json_decode($dados, true);
    }

    $nome = "Nome invalido!";
    foreach($arDados as $aDados){
        if($aDados["codigo"] == $codigoTurma){
            $nome = $aDados["nome"];
        }
    }

    return $nome;    
}

function getAcaoExcluirMateria($codigoMateria){
    $sHTML = "<a id='acaoExcluir' href='http://localhost/sistemaescolar/api/materia/cadastrar_materia.php?ACAO=EXCLUIR&codigo=" . $codigoMateria . "'>Excluir</a>";

    return $sHTML;
}

function getAcaoAlterarMateria($codigoMateria){
    $sHTML = "<a id='acaoAlterar' href='http://localhost/sistemaescolar/api/materia/cadastrar_materia.php?ACAO=ALTERAR&codigo=" . $codigoMateria . "'>Alterar</a>";

    return $sHTML;
}

require_once("../core/header.php");

echo '<h3 style="text-align:center;">CONSULTA DE MATERIA</h3>';

// JAVASCRIPT
$htmlTabelaMateria = "
    <script>
        function abreCadastroInclusao(){
            // alert('Abrindo cadastro de inclusao de Materia...');
            window.location.href = 'materia.php';
        }
    </script>
";

 $htmlTabelaMateria .= "<button class='button' type='button' onclick='abreCadastroInclusao()'>Incluir - JAVASCRIPT<button>";

// $htmlTabelaMateria .= "<a href='materia.php' target='_blank'><button class='button' type='button'>Incluir<button></a>";
//$htmlTabelaMateria .= "<a href='materia.php'><button class='button' type='button'>Incluir<button></a>";

$htmlTabelaMateria .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaMateria .= "<head>";

// TITULOS DA TABLE
$htmlTabelaMateria .= "<tr>";
$htmlTabelaMateria .= "  <th>Código</th>";
$htmlTabelaMateria .= "  <th>descricao</th>";
$htmlTabelaMateria .= "  <th>curso</th>";
$htmlTabelaMateria .= "  <th colspan='2'>Ações</th>";
$htmlTabelaMateria .= "</tr>";

$htmlTabelaMateria .= "</head>";

// CORPO DA TABELA
$htmlTabelaMateria .= "<tbody>";

// LINHAS DA TABELA
// LER OS DADOS DO ARQUIVO
$arDadosMateria = array();
// Primeiro, verifica se existe dados no arquivo json
// @ na frente do metodo, remove o warning
$dadosMateria = @file_get_contents("materia.json");
if($dadosMateria){
    // transforma os dados lidos em ARRAY, que estavam em JSON
    $arDadosMateria = json_decode($dadosMateria, true);
}

foreach($arDadosMateria as $aDados){
    // echo '<br>lendo dados do Materia: ' . json_encode($aDados);

    // ABRIR UMA NOVA LINHA
    $htmlTabelaMateria .= "<tr>";
    
    // COLUNAS DENTRO DA LINHA
    // ALINHAMENTO
    // TEXTO, ALINHADO A ESQUERDA
    // VALORES, ALINHADOS A DIREITA
    $htmlTabelaMateria .= "<td align='center'>" . $aDados["codigo"] . "</td>";
    $htmlTabelaMateria .= "<td>" . $aDados["descricao"] . "</td>";

    $nomeTurma = getNomeTurma( $aDados["turma"]);
    $htmlTabelaMateria .= "<td>" . $nomeTurma . "</td>";
    


    // Adiciona a ação de excluir Materia
    $codigoMateria = $aDados["codigo"];

    $htmlTabelaMateria .= '<td>';
    $htmlTabelaMateria .= getAcaoExcluirMateria($codigoMateria);
    $htmlTabelaMateria .= '</td>';

    $htmlTabelaMateria .= '<td>';
    $htmlTabelaMateria .= getAcaoAlterarMateria($codigoMateria);
    $htmlTabelaMateria .= '</td>';


    // FECHAR A LINHA ATUAL
    $htmlTabelaMateria .= "</tr>";
}

$htmlTabelaMateria .= "</tbody>";

$htmlTabelaMateria .= "</table>";

echo $htmlTabelaMateria;

require_once("../core/footer.php");
