<?php

require_once '../model/conexao.php';
$BD = BD::getConexao();

session_start();
$usuario_id = $_SESSION['usuario']['id'];

//nome do arquivo
$nome_ficheiro = 'foto' . $usuario_id.'.jpg';
$endereco_ficheiro = "../public/img/usuarios/$nome_ficheiro";

if(move_uploaded_file($_FILES['foto']['tmp_name'],$endereco_ficheiro)){
    echo "Arquivo enviado";

    $BD->query("UPDATE usuario SET foto = '$nome_ficheiro' WHERE id = '$usuario_id' ");
    $_SESSION['usuario']['foto'] = $nome_ficheiro;
    header('location: ../index.php');
}else{
    echo "Arquivo nao enviado";
}

?>