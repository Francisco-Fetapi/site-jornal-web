<?php 
    require_once "../helpers/funcoes_gerais.php";
    require_once "../model/Noticia.php";
    extract($_GET);

    session_start();
    if(isset($_SESSION['ADM'])){
        $ehADM = true;

        extract($_SESSION['ADM']);
        // ehADM
    }else if(isset($_SESSION['usuario'])){
        $ehADM = false;
        //vou extrair esses dados
        foreach($_SESSION['usuario'] as $chave=>$valor){
            $$chave = stripslashes($valor);
        }
    }
    $Noticia = new Noticia();
    $noticia = $Noticia->selecionar_noticia($id_noticia);
?>

<div class="panel">
    <div class="panel-heading">
        <h2 class="panel-title py-3 px-2"><?php echo $noticia['titulo'] ?></h2>
    </div>
    <div class="panel-body" style="position: relative;">
        <ul class="list-inline">
            <li><span class="glyphicon glyphicon-time"></span> <?php escreve_data($noticia['data']) ?>
            </li>
            <li><span class="glyphicon glyphicon-thumbs-up"></span> <?php echo $noticia['likes'] ?></li>
            <li><span class="glyphicon glyphicon-thumbs-down"></span> <?php echo $noticia['deslikes'] ?>
            </li>
            <li><span class="glyphicon glyphicon-comment"></span> <?php echo $noticia['comentarios'] ?>
            </li>
        </ul>
        <p><?php echo nl2br($noticia['noticia']) ?>

        </p>

        <div id="ops">
            <ul>
                <?php if(!$ehADM): ?>
                <?php 
                require_once '../model/conexao.php';
                $BD = BD::getConexao();

                $cmd = $BD->query("SELECT * FROM noticia_reacoes WHERE id_noticia = '$noticia[id]' AND id_usuario = '$id' ");
                $jaReagiu = $cmd->rowCount();
                
            ?>
                <?php if($jaReagiu): ?>
                <?php
                $dados = $cmd->fetch(PDO::FETCH_ASSOC);
                $estado = $dados['estado'];
                if($estado == 2):
            ?>
                <li>
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    <span class="gostar_noticia" data-id-usuario="<?php echo $id ?>"
                        data-id-noticia="<?php echo $noticia['id'] ?>">gostar</span>
                </li>
                <?php endif ?>
                <?php if($estado == 1): ?>
                <li>
                    <span class="glyphicon glyphicon-thumbs-down"></span>
                    <span class="gostar_noticia" data-id-usuario="<?php echo $id ?>"
                        data-id-noticia="<?php echo $noticia['id'] ?>">não gostar</span>
                </li>
                <?php endif ?>
                <?php endif ?>
                <?php endif ?>

                <?php if(!$ehADM): ?>
                <?php if(!$jaReagiu): ?>
                <li>
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    <span class="gostar_noticia" data-id-usuario="<?php echo $id ?>"
                        data-id-noticia="<?php echo $noticia['id'] ?>">gostar</span>
                </li>
                <?php endif ?>
                <?php endif ?>
                <li>
                    <span class="fa fa-comment"></span>
                    <span class="ler_mais" data-id-noticia="<?php echo $noticia['id'] ?>">comentar</span>
                </li>
                <?php if(!$ehADM): ?>
                <?php 
                $Noticia->selecionar_noticia($noticia['id']);

                if(!$Noticia->guardada($id)):
            ?>
                <li>
                    <span class="fa fa-share"></span>
                    <span class="ler_mais_tarde" data-id-usuario="<?php echo $id ?>"
                        data-id-noticia="<?php echo $noticia['id'] ?>">ler mais
                        tarde</span>
                </li>
                <?php endif ?>
                <?php if($Noticia->guardada($id)): ?>
                <li style="cursor: default;color:white !important;">
                    <span class="fa fa-save"></span>
                    <span class="guardada" data-id-usuario="<?php echo $id ?>"
                        data-id-noticia="<?php echo $noticia['id'] ?>">guardada</span>
                </li>
                <?php endif ?>
                <?php endif ?>
                <!-- So para o ADM -->
                <?php if($ehADM): ?>
                <li>
                    <span class="fa fa-pencil"></span>
                    <span class="editar_noticia" data-id-noticia="<?php echo $noticia['id'] ?>">editar</span>
                </li>
                <li>
                    <span class="fa fa-trash"></span>
                    <span class="eliminar_noticia" data-id-noticia="<?php echo $noticia['id'] ?>">eliminar</span>
                </li>

                <?php endif ?>
                <!-- Para todos -->
                <li class="voltar">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    voltar
                </li>
            </ul>
        </div>
    </div>

    <div class="comentarios">
        <h2>Comentarios</h2>
        <div class="com">
            <?php 
                $comentarios = $Noticia->getComentarios();

                if($comentarios != false):
                foreach($comentarios as $comentario):
            ?>
            <div class="media">
                <?php if($comentario['id_usuario'] != 0): ?>
                <!-- nao eh o ADM -->
                <?php $Comentador = $Noticia->getDadosComentador($comentario['id_usuario']); ?>
                <div class="media-left">
                    <img src="./public/img/usuarios/<?php echo $Comentador['foto'] ?>" alt="">
                </div>
                <div class="media-body">
                    <p class="nome"><?php echo $Comentador['nome'] ?></p>
                    <?php endif ?>
                    <?php if($comentario['id_usuario'] == 0): ?>
                    <!-- eh o ADM -->
                    <?php 
                    require_once '../model/Administrador.php';
                    $ADM = new Administrador();
                    $Comentador['nome'] = "{$ADM->nome} - Administrador(a)";
                    $Comentador['foto'] = $ADM->foto;
                ?>
                    <div class="media-left">
                        <img src="./public/img/usuarios/<?php echo $Comentador['foto'] ?>" alt="">
                    </div>
                    <div class="media-body">
                        <p class="nome"><?php echo $Comentador['nome'] ?></p>
                        <?php endif ?>
                        <!-- bloco caso seja o ADM -->
                        <div class="comentario">
                            <p><?php echo nl2br($comentario['comentario'])?></p>
                        </div>
                        <ul class="info">
                            <?php
                            $data_hora =explode(' ',$comentario['data_hora']);
                            $data = $data_hora[0];
                            $hora = $data_hora[1];   
                        ?>
                            <li><span class="glyphicon glyphicon-time"></span> <?php escreve_data($data) ?></li>
                            <li><?php escreve_hora($hora) ?></li>
                        </ul>
                    </div>
                </div>
                <?php endforeach ?>
                <?php endif ?>
                <?php if(!$comentarios):?>
                <h3 class="msg_comentar">Seja o primeiro a comentar</h3>
                <?php endif ?>
            </div>

            <div class="comentar">
                <div class="form-group">
                    <label for="text_comentario"><span class="fa fa-comment"></span> Comentar</label>
                    <br>
                    <textarea class="form-control" id="text_comentario"></textarea>
                </div>
                <?php if(!$ehADM): ?>
                <button class="btn btn-secondary btn_comentar" data-id-noticia="<?php echo $noticia['id'] ?>"
                    data-id-usuario="<?php echo $id ?>">Comentar</button>
                <?php endif ?>
                <?php if($ehADM): ?>
                <button class="btn btn-secondary btn_comentar" data-id-noticia="<?php echo $noticia['id'] ?>"
                    data-id-usuario="0">Comentar</button>
                <?php endif ?>
            </div>
        </div>

        <script>
        function mostrarAguarde() {
            funcao.mostrarLoading({
                tempo: 7
            });
        }

        function ocultarAguarde() {
            funcao.ocultarLoading();
        }
        // ELIMINAR
        $('.eliminar_noticia').click(function() {
            id_noticia = $(this).attr('data-id-noticia');
            const dados = {
                id: id_noticia
            }

            mostrarAguarde();

            let resposta = window.confirm("Tem certeza disso?");
            if (resposta == true) {
                $.get('controllers/eliminar_noticia.php', dados, function(res) {
                    ocultarAguarde();
                    if (res == 'certo') window.location.reload();
                });
            }
        });

        // EDITAR
        $('.editar_noticia').click(function() {
            $('#modalLerNoticia').modal('hide');
            const id_noticia = $(this).attr('data-id-noticia');

            mostrarAguarde();
            $.get('view/dados_publicacao.php', {
                id: id_noticia
            }, function(res) {
                ocultarAguarde();
                $('#modalEditarPub .modal-content').html(res);
                $('#modalEditarPub').modal('show');
            })
            console.log(id_noticia);
        });
        // VOLTAR
        $('#modalLerNoticia .voltar').click(function() {
            $('#modalLerNoticia').modal('hide');
        });

        // GOSTAR -- na verdade eh REAGIR em geral!
        $('.gostar_noticia').click(function() {
            const dados = {
                id_usuario: $(this).attr('data-id-usuario'),
                id_noticia: $(this).attr('data-id-noticia'),
                tipo: '1'
            }
            mostrarAguarde();
            $.get('controllers/reagir_noticia.php', dados, function() {
                ocultarAguarde();
                window.location.reload();
            })
        });

        $('.ler_mais').click(function() {
            $('#text_comentario').focus();
        })

        // COMENTAR
        $('.btn_comentar').click(function() {
            let id_noticia = $(this).attr('data-id-noticia');
            let id_usuario = $(this).attr('data-id-usuario');
            let texto_comentario = $('#text_comentario').val();

            if (texto_comentario.length == 0) {
                funcao.informar({
                    msg: 'O campo não pode estar vazio!',
                    titulo: 'Erro ao comentar',
                    tipo: 'erro',
                    tempo: 2.5
                })
            } else {
                const dados = {
                    id_usuario: id_usuario,
                    id_noticia: id_noticia,
                    comentario: texto_comentario
                }
                mostrarAguarde();
                $.get('controllers/comentar.php', dados, function(res) {
                    ocultarAguarde();
                    if (res == 'certo') location.reload();
                })
            }

        });

        // LER MAIS TARDE
        $('.ler_mais_tarde').click(function() {
            let id_usuario = $(this).attr('data-id-usuario');
            let id_noticia = $(this).attr('data-id-noticia');

            const dados = {
                id_usuario: id_usuario,
                id_noticia: id_noticia
            }
            mostrarAguarde();

            $.get('controllers/guardar_noticia.php', dados, function(res) {
                ocultarAguarde();
                location.reload();
            })
        })
        </script>