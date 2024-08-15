<?php
// echo '<link rel="stylesheet" href="style.css">';
//echo '<link rel="stylesheet" href="https://raw.githubusercontent.com/gelvaziosenac/sistemaescolar/main/api/style.css">';


echo '<body class="background-06">';
echo '
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
    }

    .background-06 {
        background: linear-gradient(90deg, #43a4f9, #1ef4ff);
    }

    body{
        height: 85vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>';

$sHTML = '
<div class="header">
    <ul>
        <li><a href="aluno.php">Alunos</a></li>
    </ul>
</div>';

echo $sHTML;