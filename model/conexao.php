<?php
    class BD{
        
        private static $BD;

        private function __construct(){}

        public static function getConexao(){

            if(!isset(self::$BD)){
                $nome_banco = 'jornal_web';
                $host = 'localhost';
                $usuario = 'root';
                $senha = '';
                try{
                    self::$BD = new PDO("mysql:dbname=$nome_banco;host=$host",$usuario,$senha);
                }catch(Exception $e){
                    echo "<h1>Erro: $e</h1>";
                }
            }

            return self::$BD;
        }
        
        
    }
?>