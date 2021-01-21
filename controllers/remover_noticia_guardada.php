<?php 

    require_once '../model/Noticia.php';
    $Noticia = new Noticia();
    extract($_GET);
    $Noticia->selecionar_noticia($id_noticia);
    $Noticia->remover_guardada($id_usuario);
    
    echo 'certo';
?>