<?php


    class Administrador{
        public $nome;
        public $numId;
        public $senha;
        public $foto;


        public function __construct(){
            $this->nome = 'Francisco Fetapi';
            $this->numId = '943674398';
            $this->senha = 'Fetapi';
            $this->foto = "user.jpg";
        }

        public function iniciar_sessao(){
            session_start();

            unset($_SESSION['usuario']); //termina sessao do usuario logado!
            
            $_SESSION['ADM']['nome'] = $this->nome;
            $_SESSION['ADM']['numId'] = $this->numId;
            $_SESSION['ADM']['senha'] = $this->senha;
            $_SESSION['ADM']['foto'] = $this->foto;
        }

    }

?>