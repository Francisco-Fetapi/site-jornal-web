<?php

    require_once '../model/Noticia.php';
    $Noticia = new Noticia();
    extract($_GET);
    $Noticia->selecionar_noticia($id_noticia);

    $msg = ['tipo'=>$tipo];

    $Noticia->reagir($id_usuario,$tipo);

    echo $msg;
?>