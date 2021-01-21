<?php
    require_once 'conexao.php';
    require_once "Usuario.php";

    class Professor extends Usuario{

        private $disciplina;
        public function __construct($nome,$genero,$dataNasc,$email,$numId,$senha,$disciplina){
            parent::__construct($nome,$genero,$dataNasc,$email,$numId,$senha);

            //os atributos especias dele
            $this->disciplina = $disciplina;
            

            $this->BD = BD::getConexao();
        }

        public function cadastrar(){
            $id_usuario = parent::cadastrar(); //cadastrar usuario

            if($id_usuario){
                $cmd = $this->BD->prepare("UPDATE usuario SET disciplina = :d , tipo = :t WHERE id = :id ");
                $cmd->bindValue(':d',$this->disciplina);
                $cmd->bindValue(':id',$id_usuario);
                $cmd->bindValue(':t','P'); //tipo aluno
                $cmd->execute();

                $this->iniciar_sessao();
                return true;
            }else{
                return false;
            }
        }
    
        public function iniciar_sessao()
        {
            //so inicia sessao se foi permitido!
            $permitido = $this->getMeusDados()['permitido'];

            if($permitido == 'sim'){
                parent::iniciar_sessao(); //session_start();

                $_SESSION['usuario']['disciplina'] = $this->disciplina;
                $_SESSION['usuario']['tipo'] = 'P';

                return true;
            }else{
                return false;
            }
        }

        public function modificar_dados($senha,$nome,$genero,$dataNasc,$email,$numId,$disciplina){
            $deuCerto = parent::alterar_dados($senha,$nome,$genero,$dataNasc,$email,$numId);
            $id_usuario = $this->getMeusDados()['id'];

            if($deuCerto){
                 $this->BD->query("UPDATE usuario 
                 SET disciplina = '$disciplina'
                 WHERE id = '$id_usuario' ");
 
                $this->reiniciar_sessao();
                
                 return true;
             }else{
                 return false;
             }
        }

        public function reiniciar_sessao(){
            $dados = $this->getMeusDados();

            $this->disciplina = $dados['disciplina'];

            parent::reiniciar_sessao();
        }

    }

?>