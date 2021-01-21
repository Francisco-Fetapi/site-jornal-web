<?php

    require_once '../model/Noticia.php';

    extract($_GET);

    $Noticia = new Noticia();
    $Noticia->inserirDados($titulo,$noticia,$grupo);
    $Noticia->publicar();

    echo "certo";
?>