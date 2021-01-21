<?php

    require_once "../model/conexao.php";
    $BD = BD::getConexao();
    extract($_GET);

    $BD->query("UPDATE usuario SET permitido = '$permitido' WHERE id = '$id' ");

    echo "Feito";
?>