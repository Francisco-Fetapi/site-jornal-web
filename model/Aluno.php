<?php
    require_once 'conexao.php';
    require_once "Usuario.php";

    class Aluno extends Usuario{

        private $classe;
        private $curso;
        private $periodo;
        public function __construct($nome,$genero,$dataNasc,$email,$numId,$senha,$classe,$curso,$periodo){
            parent::__construct($nome,$genero,$dataNasc,$email,$numId,$senha);

            //os atributos especias dele
            $this->classe = $classe;
            $this->curso = $curso;
            $this->periodo = $periodo;

            $this->BD = BD::getConexao();
        }

        public function cadastrar(){
            $id_usuario = parent::cadastrar(); //cadastrar usuario

            if($id_usuario){
                $cmd = $this->BD->prepare("UPDATE usuario SET classe = :c, curso = :cu, periodo = :p, tipo = :t WHERE id = :id ");
                $cmd->bindValue(':c',$this->classe);
                $cmd->bindValue(':cu',$this->curso);
                $cmd->bindValue(':p',$this->periodo);
                $cmd->bindValue(':id',$id_usuario);
                $cmd->bindValue(':t','A'); //tipo aluno
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

                $_SESSION['usuario']['classe'] = $this->classe;
                $_SESSION['usuario']['curso'] = $this->curso;
                $_SESSION['usuario']['periodo'] = $this->periodo;
                $_SESSION['usuario']['tipo'] = 'A';

                return true;
            }else{
                return false;
            }
        }

        public function modificar_dados($senha,$nome,$genero,$dataNasc,$email,$numId,$classe,$curso,$periodo){
           $deuCerto = parent::alterar_dados($senha,$nome,$genero,$dataNasc,$email,$numId);
            $id_usuario = $this->getMeusDados()['id'];
           if($deuCerto){
                $this->BD->query("UPDATE usuario 
                SET classe = '$classe',
                    curso = '$curso',
                    periodo = '$periodo'
                WHERE id = '$id_usuario' ");

                $this->reiniciar_sessao();

                return true;
            }else{
                return false;
            }
        }

        public function reiniciar_sessao(){
            $dados = $this->getMeusDados();

            $this->classe = $dados['classe'];
            $this->curso = $dados['curso'];
            $this->periodo = $dados['periodo'];

            parent::reiniciar_sessao();
        }

    }

?>