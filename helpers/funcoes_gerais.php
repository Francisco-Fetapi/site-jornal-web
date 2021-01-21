<?php


    function x_palavras($string,$numPalavras){
        $palavras = explode(' ',$string);
        $novaFrase = '';

        if(count($palavras) > $numPalavras){
            for($c = 0; $c <=$numPalavras;$c++){
                $novaFrase .=' '.$palavras[$c];
            }
    
            return $novaFrase;
        }else{
            return $string;
        }
    }

    function escreve_data($data){
        $parte = explode('-',$data);

        $ano = $parte[0];
        $mes = $parte[1];
        $dia = $parte[2];

        echo $dia.'/'.$mes.'/'.$ano;
    }

    function escreve_hora($hora){
        $partes = explode(':',$hora);
        $hora = $partes[0];
        $minuto = $partes[1];

        echo "$hora:$minuto";
    }

?>