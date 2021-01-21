<?php
    require '../helpers/funcoes_gerais.php';

    // extract($_GET);
    foreach($_GET as $chave=>$valor){
        $$chave = addslashes($valor);
    }
    $res = ['msg'=>''];

    if(trim($tipo) == "Professor"){
        require_once "../model/Professor.php";

        $usuario = new Professor($nome,$genero,$dataNasc,$email,$numId,$senha,$disciplina);
        if($usuario->cadastrar()){
            $res['msg'] = "Cadastrado";
        }else{
            $res['msg'] = "Erro";
        }
        
    }else{ //eh aluno
        require_once "../model/Aluno.php";

        $usuario = new Aluno($nome,$genero,$dataNasc,$email,$numId,$senha,$classe,$curso,$periodo);
        if($usuario->cadastrar()){
            $res['msg'] = "Cadastrado";
        }else{
            $res['msg'] = "Erro";
        }    
    }

    echo json_encode($res);
?>