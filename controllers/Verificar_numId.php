<?php
    require '../helpers/funcoes_gerais.php';

    // extract($_GET);
    foreach($_GET as $chave=>$valor){
        $$chave = addslashes($valor);
    }
    $res = ['msg'=>''];
    require_once "../model/Professor.php"; 
    //podia ser Aluno, sem problemas,apenas quero usar uma 
    //funcao que as duas classes herdam da classe abstrata Usuario

    $usuario = new Professor($nome,$genero,$dataNasc,$email,$numId,$senha,'');

    if($usuario->jaExisteMeuNumId()){
        $res['msg'] = "S"; //sim existe
    }else{
        $res['msg'] = "N"; //nao existe
    }


    echo json_encode($res);
?>