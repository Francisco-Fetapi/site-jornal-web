<?php
   require_once 'conexao.php';

    abstract class Usuario{

        private $nome;
        private $genero;
        private $dataNasc;
        private $email;
        private $numId;
        private $senha;
        private $foto;
        private $permitido;
        private $BD;

        public function __construct($nome,$genero,$dataNasc,$email,$numId,$senha){
            $this->nome = $nome;
            $this->genero = $genero;
            $this->dataNasc = $dataNasc;
            $this->email = $email;
            $this->numId = $numId;
            $this->senha = $senha;
            $this->foto = "user.jpg";
            $this->permitido = "sim";

            $this->BD = BD::getConexao();
        }

        public function cadastrar(){

            $cmd = $this->BD->query("SELECT * FROM usuario WHERE numId = '$this->numId' ");
            
            if($cmd->rowCount() > 0){ // ja existe
                return false;
            }else{

                //converter alguns valores
                $this->senha = md5($this->senha);

                $this->BD->query("INSERT INTO usuario (nome,genero,dataNasc,email,numId,senha,foto,permitido)
                            VALUES('$this->nome',
                            '$this->genero',
                            '$this->dataNasc',
                            '$this->email',
                            '$this->numId',
                            '$this->senha',
                            '$this->foto',
                            '$this->permitido'
                            )
                        ");

                return $this->getMeusDados()['id'];
            }   
        }

        public function getMeusDados(){
            $cmd = $this->BD->query("SELECT * FROM usuario WHERE numId = '$this->numId'");
            $usuario = $cmd->fetch(PDO::FETCH_ASSOC);
            
            return $usuario;
        }

        public function iniciar_sessao(){
            session_start();
        
            $_SESSION['usuario']['id'] = $this->getMeusDados()['id'];
            $_SESSION['usuario']['nome'] = stripslashes( $this->nome);
            $_SESSION['usuario']['genero'] = $this->genero;
            $_SESSION['usuario']['dataNasc'] = $this->dataNasc;
            $_SESSION['usuario']['email'] = stripslashes($this->email);
            $_SESSION['usuario']['numId'] = $this->numId;
            $_SESSION['usuario']['senha'] = stripslashes($this->senha);
            $_SESSION['usuario']['foto'] = $this->getMeusDados()['foto'];
            $_SESSION['usuario']['permitido'] = $this->permitido;
        }

        public function reiniciar_sessao(){
            $dados = $this->getMeusDados();
            
            $this->nome = $dados['nome'];
            $this->genero = $dados['genero'];
            $this->dataNasc = $dados['dataNasc'];
            $this->email = $dados['email'];
            $this->numId = $dados['numId'];
            $this->senha = $dados['senha'];
            $this->foto = $dados['foto'];
            
            $this->iniciar_sessao();
        }
        
        public function jaExisteMeuNumId(){
            $cmd = $this->BD->query("SELECT * FROM usuario WHERE numId = '$this->numId' ");
            
            if($cmd->rowCount() > 0){ // ja existe
                return true;
            }else{
                return false;
            }
        }

        public function alterar_dados($senha,$nome,$genero,$dataNasc,$email,$numId){
            $id = $this->getMeusDados()['id'];
            if(md5($senha) === $this->senha){
                $this->BD->query("UPDATE usuario 
                SET nome = '$nome',
                    genero = '$genero',
                    dataNasc = '$dataNasc',
                    email = '$email',
                    numId = '$numId'
                WHERE id = '$id' ");

                return true;
            }else{
                return false;
            }
        }

        public function alterar_senha($senha,$novaSenha){
            $senha = md5($senha);

            if($senha == $this->senha){ //se a senha que ele inseriu eh igual a que ja existe
                $id_usuario = $this->getMeusDados()['id'];
                $novaSenha = md5($novaSenha);

                $this->BD->query("UPDATE usuario SET senha = '$novaSenha' WHERE id = '$id_usuario' ");
                $this->reiniciar_sessao();
                return true;
            }else{ //senha de confirmacao incorreta
                return false;
            }

        }


    }

    

?>