<?php

    require_once '../model/Noticia.php';
    $Noticia = new Noticia();
    extract($_GET);
    $Noticia->selecionar_noticia($id_noticia);

    $Noticia->comentar($id_usuario,$comentario);

    echo 'certo';
?>