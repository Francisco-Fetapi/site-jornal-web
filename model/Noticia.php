<?php


    require_once 'conexao.php';

    class Noticia{
         public $id;
         public $titulo;
         public $noticia;
         public $data;
         public $grupo;
         public $ikes;
         public $deslikes;
         public $reacoes;
         public $comentarios;

         public function __construct(){
             $this->likes = 0;
             $this->deslikes = 0;
             $this->reacoes = 0;
             $this->comentarios = 0;

             $this->BD = BD::getConexao();
         }
         
         public function inserirDados($titulo,$noticia,$grupo){
            $this->titulo = $titulo;
            $this->noticia = $noticia;
            $this->grupo = $grupo;
         }

         public function publicar(){
             $this->BD->query("INSERT INTO noticias (titulo,noticia,data,grupo,likes,deslikes,reacoes,comentarios) 
             VALUES(
                '$this->titulo',
                '$this->noticia',
                NOW(),
                '$this->grupo',
                '$this->likes',
                '$this->deslikes',
                '$this->reacoes',
                '$this->comentarios'
             )");
         }

         public function getTodas(){
            if(isset($_SESSION['usuario'])){
                $tipoUsuario = $_SESSION['usuario']['tipo'];
                $cmd = $this->BD->query("SELECT * FROM noticias WHERE grupo = 'T' OR grupo = '$tipoUsuario' ");
            }else if(isset($_SESSION['ADM'])){
                $cmd = $this->BD->query("SELECT * FROM noticias");
            }
            $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);

            return $dados;
         }

         public function getNoticia($id){
             $cmd = $this->BD->query("SELECT * FROM noticias WHERE id = '$id'");
             $dados = $cmd->fetch(PDO::FETCH_ASSOC);

             return $dados;
         }

         public function selecionar_noticia($id){
             $cmd = $this->BD->query("SELECT * FROM noticias WHERE id = '$id'");
             $dados = $cmd->fetch();

             $this->id = $dados['id'];
             $this->titulo = $dados['titulo'];
             $this->noticia = $dados['noticia'];
             $this->data = $dados['data'];
             $this->grupo = $dados['grupo'];
             $this->likes = $dados['likes'];
             $this->deslikes = $dados['deslikes'];
             $this->reacoes = $dados['reacoes'];

             return $dados;
         }
         public function alterar_dados($titulo,$noticia,$grupo){
            $this->BD->query("UPDATE noticias SET titulo = '$titulo',noticia = '$noticia', grupo = '$grupo' WHERE id = '$this->id' ");
         }
         public function eleminar(){//seria eliminar
             $this->BD->query("DELETE FROM noticias WHERE id = '$this->id'");
         }

         public function reagir($id_usuario){
             // tipo -> 1 ->gostar
             // tipo -> 2 -> nao gostar

             $cmd = $this->BD->query("SELECT * FROM noticia_reacoes WHERE id_noticia = '$this->id' AND id_usuario = '$id_usuario' ");
             $estado = $cmd->fetch();
             $estado = $estado['estado'];
            if($cmd->rowCount() > 0){ //ja reagiu
                if($estado == 1) $estado = 2;
                else $estado = 1;
                $this->BD->query("UPDATE noticia_reacoes SET estado = '$estado' WHERE id_noticia = '$this->id' AND id_usuario = '$id_usuario' ");
            }else{ //nunca reagiu
                $this->BD->query("INSERT INTO noticia_reacoes (id_noticia,id_usuario,estado) 
                    VALUES(
                        '$this->id',
                        '$id_usuario',
                        '1'
                    )");
            }
            
            // UPDATE reacoes
            $cmd = $this->BD->query("SELECT * FROM noticia_reacoes WHERE id_noticia = '$this->id' ");
            $qtd = $cmd->rowCount();
            $this->BD->query("UPDATE noticias SET reacoes = '$qtd' WHERE id = '$this->id' ");

            // UPDATE likes
            $cmd = $this->BD->query("SELECT * FROM noticia_reacoes WHERE id_noticia = '$this->id' AND estado = '1' ");
            $qtd = $cmd->rowCount();
            $this->BD->query("UPDATE noticias SET likes = '$qtd' WHERE id = '$this->id' ");
            
            // UPDATE deslikes
            $cmd = $this->BD->query("SELECT * FROM noticia_reacoes WHERE id_noticia = '$this->id' AND estado = '2' ");
            $qtd = $cmd->rowCount();
            $this->BD->query("UPDATE noticias SET deslikes = '$qtd' WHERE id = '$this->id' ");
         }

         public function guardar($id_usuario){
            $this->BD->query("INSERT INTO noticias_guardadas (id_usuario,id_noticia,data) 
            VALUES(
                '$id_usuario',
                '$this->id',
                NOW()
            )");
         }

         public function guardada($id_usuario){
            $cmd = $this->BD->query("SELECT * FROM noticias_guardadas WHERE id_noticia = '$this->id' AND id_usuario = '$id_usuario' ");
            
            return $cmd->rowCount(); // 0 ou 1
         }

         public function getIdGuardadas($id_usuario){
             $cmd = $this->BD->query("SELECT * FROM noticias_guardadas WHERE id_usuario = '$id_usuario' ");
             $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
             $ids = [];

             foreach($dados as $dado){
                $ids[] = $dado['id_noticia'];
             }

             return $ids;
         }

         public function getDataNoticiaGuardada($id_noticia){
            $cmd = $this->BD->query("SELECT * FROM noticias_guardadas WHERE id_noticia = '$id_noticia'");
            $dados = $cmd->fetch();

            return $dados['data'];
         }

         public function remover_guardada($id_usuario){
             $this->BD->query("DELETE FROM noticias_guardadas WHERE id_noticia = '$this->id' AND id_usuario = '$id_usuario' ");
         }

         public function comentar($id_usuario,$comentario){
            $this->BD->query("INSERT INTO noticias_comentarios (id_noticia,id_usuario,comentario,data_hora) 
            VALUES(
                '$this->id',
                '$id_usuario',
                '$comentario',
                NOW()
            )");

            // UPDATE comentarios
            $cmd = $this->BD->query("SELECT * FROM noticias_comentarios WHERE id_noticia = '$this->id' ");
            $qtd = $cmd->rowCount();
            $this->BD->query("UPDATE noticias SET comentarios = '$qtd' WHERE id = '$this->id' ");

         }

         public function getComentarios(){
             $cmd = $this->BD->query("SELECT * FROM noticias_comentarios WHERE id_noticia = '$this->id' ");
             $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);

             if($cmd->rowCount() == 0) return false;
             return $dados;
         }

         public function getDadosComentador($id_usuario){
            $cmd = $this->BD->query("SELECT * FROM usuario WHERE id = '$id_usuario' ");
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);

            $Dados = [
                'nome' => $dados['nome'],
                'foto' => $dados['foto']
            ];

            return $Dados;
         }

         public function getMaisComentada(){
            if(isset($_SESSION['usuario'])){
                $tipoUsuario = $_SESSION['usuario']['tipo'];
                $cmd = $this->BD->query("SELECT * FROM noticias WHERE grupo = 'T' OR grupo = '$tipoUsuario' ORDER BY comentarios DESC ");
            }else if(isset($_SESSION['ADM'])){
                $cmd = $this->BD->query("SELECT * FROM noticias ORDER BY comentarios DESC");
            }
            $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);

             return $dados[0];
         }
         public function getMaisReagida(){
            if(isset($_SESSION['usuario'])){
                $tipoUsuario = $_SESSION['usuario']['tipo'];
                $cmd = $this->BD->query("SELECT * FROM noticias WHERE grupo = 'T' OR grupo = '$tipoUsuario' ORDER BY reacoes DESC ");
            }else if(isset($_SESSION['ADM'])){
                $cmd = $this->BD->query("SELECT * FROM noticias ORDER BY reacoes DESC");
            }
            $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);

             return $dados[0];
         }

         public function pesquisar($titulo){
            session_start();
            if(isset($_SESSION['usuario'])){
                $tipoUsuario = $_SESSION['usuario']['tipo'];
                $cmd = $this->BD->query("SELECT * FROM noticias WHERE (grupo = 'T' OR grupo = '$tipoUsuario') AND titulo LIKE '%$titulo%' ");
            }else if(isset($_SESSION['ADM'])){
                $cmd = $this->BD->query("SELECT * FROM noticias WHERE titulo LIKE '%$titulo%' ");
            }
            $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);

            return $dados;
         }
    }


?>