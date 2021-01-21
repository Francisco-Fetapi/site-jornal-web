<?php

    require_once '../model/Noticia.php';
    $Noticia = new Noticia();
    extract($_GET);

    $Noticia->selecionar_noticia($id);
    $Noticia->alterar_dados($titulo,$noticia,$grupo);

    echo "certo";

?>