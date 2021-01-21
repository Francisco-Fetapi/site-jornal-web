<?php

    foreach($_GET as $chave=>$valor){
        $$chave = addslashes($valor);
    }

    session_start();
    foreach($_SESSION['usuario'] as $chave=>$valor){
        $nomeVar = 's'.$chave;
        $$nomeVar = $valor;
    }

    session_abort(); //para terminar sessao , porque na linha abaixo sera iniciada de novo
    
    if($tipo == 'Aluno'){
        require_once "../model/Aluno.php";
        $Aluno = new Aluno($snome,$sgenero,$sdataNasc,$semail,$snumId,$ssenha,$sclasse,$scurso,$speriodo);
        if($Aluno->alterar_senha($senha,$novaSenha)){
            $res['modificado'] = "sim";
        }else{ //senha esta errada
            $res['modificado'] = "nao";
        }
    }else{ //eh professor
        require_once "../model/Professor.php";
        $Professor = new Professor($snome,$sgenero,$sdataNasc,$semail,$snumId,$ssenha,$sdisciplina);
        if($Professor->alterar_senha($senha,$novaSenha)){
            $res['modificado'] = "sim";
        }else{ //senha esta errada
            $res['modificado'] = "nao";
        }
    }

    echo json_encode($res);
?>