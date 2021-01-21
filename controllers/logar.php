<?php

    require_once '../model/conexao.php';
    $BD = BD::getConexao();


    // extract($_GET);
    foreach($_GET as $chave=>$valor){
        $$chave = addslashes($valor);
    }
    $msg = ['msg'=>''];
    
    require_once "../model/Administrador.php";
    $ADM = new Administrador();

    if($numId == $ADM->numId && $senha == $ADM->senha){
        $ADM->iniciar_sessao();
        $msg['msg'] = "OK";
        $msg['adm'] = "sim";
    }else{

    $senha = md5($senha);
    $cmd = $BD->query("SELECT * FROM usuario WHERE numID = '$numId' AND senha= '$senha'");
    if($cmd->rowCount() > 0){ 
        $msg['msg'] = "OK";

        $usuario = $cmd->fetch(PDO::FETCH_ASSOC);
        extract($usuario);

        if($usuario['tipo'] == "P"){
            require_once "../model/Professor.php";
            $Professor = new Professor($nome,$genero,$dataNasc,$email,$numId,$senha,$disciplina);
            if(!$Professor->iniciar_sessao()){
                $msg['msg'] = "Acesso negado";
            }
            
        }else{ //entao eh Aluno
            require_once "../model/Aluno.php";
            $Aluno = new Aluno($nome,$genero,$dataNasc,$email,$numId,$senha,$classe,$curso,$periodo);
            if(!$Aluno->iniciar_sessao()){
                $msg['msg'] = "Acesso negado";
            }
        }
    }
}

    echo json_encode($msg);
?>