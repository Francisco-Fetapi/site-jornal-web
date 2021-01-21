<?php 

    extract($_GET);
    require_once "../model/Noticia.php";
    $Noticia = new Noticia();
    $Noticia->selecionar_noticia($id_noticia);

    $Noticia->guardar($id_usuario);
?>