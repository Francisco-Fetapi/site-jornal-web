<?php
    session_start();
    require_once "./helpers/funcoes_gerais.php";
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

        $genero = ($genero == "M") ? "Masculino" : "Feminino";
    }else{
        //depois vou testar se o ADM esta logado! 'ADM'
        //senao ele vai redirecionar para o login
        header('location: login.html');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jornal Web</title>
    <link rel="stylesheet" href="./public/lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./public/lib/bootstrap/css/bootstrap3+++4.css">
    <link rel="stylesheet" href="./public/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="./public/css/style.css">
    <link rel="stylesheet" href="./public/css/index.css">
    <link rel="shortcut icon" href="./public/img/logo-chimbanda.png"/>
</head>

<body>
    <div class='loading text-center'>
        <div class='spinner text-primary spinner-border'></div>
        <p>Aguarde</p>
    </div>
    <div class="container">
        <header>
            <section id="linha1">
                <img class="logo_chimbanda logo2" src="./public/img/logo-chimbanda.png" alt="">
                <article id="desc">
                    <h3>Jornal Web</h3>
                    <p>Saiba em primeira mão tudo que acontece no colégio <b>Chimbanda</b></p>
                </article>
                <article id="redes-sociais">
                    <ul>
                        <li><span class="fa fa-facebook"></span></li>
                        <li><span class="fa fa-whatsapp"></span></li>
                        <li><span class="fa fa-twitter"></span></li>
                        <li><span class="fa fa-google"></span></li>
                    </ul>
                </article>
            </section>
            <nav id="navBar">
                <ul class="menu1">
                    <li class='active'><a href="#"><span class="fa fa-home"></span> Home</a></li>
                    <?php if(!$ehADM): ?>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="fa fa-user"></span> Perfil <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="ver_perfil">Ver <span class="fa fa-eye"></span></a></li>
                            <li><a href="#" class="alterar_dados">Editar <span class="fa fa-pencil"></span> </a></li>
                            <li><a href="#" class="alterar_senha">Alterar Senha <span
                                        class="fa fa-pencil-square"></span></a></li>
                            <li><a href="#" class="alterar_foto">Alterar Foto<span class="fa fa-photo"></span> </a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="lista_guardados"><span class="glyphicon glyphicon-save"></span> Guardados</a>
                    </li>
                    <?php endif ?>
                    <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span> Sobre</a></li>
                    <?php if($ehADM): ?>
                    <li><a href="#" class="comunidade"><span class="fa fa-users"></span> Comunidade</a></li>
                    <?php endif ?>
                </ul>


                <ul class="menu2">
                    <li><a href="#" class="<?php echo (!$ehADM) ? 'ver_perfil' : '' ?>"><img
                                src="./public/img/usuarios/<?php echo $foto ?>" class="img-user" alt="">
                            <?php echo $nome ?></a></li>
                    <li><a href="./sair.php" class="sair">Sair</a></li>
                </ul>

            </nav>
            <div>
                <span class="glyphicon glyphicon-menu-hamburger"></span>
            </div>
        </header>

        <div id="carrossel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carrossel" data-slide-to="0" class="active"></li>
                <li data-target="#carrossel" data-slide-to="1"></li>
                <li data-target="#carrossel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="active item">
                    <img src="./public/img/slide-1.jpg" alt="First Slide">
                    <div class="carousel-caption">
                        <h3>O que posso encontrar aqui?</h3>
                        <p>Aqui você encontra informações de diversos assuntos relacionados ao colégio
                            <b>Chimbanda</b></b></p>
                    </div>
                </div>
                <div class="item">
                    <img src="./public/img/slide-2.jpg" alt="Second Slide">
                    <div class="carousel-caption">
                        <h3>Mais informado sobre o Chimbanda</h3>
                        <p>Novidades acima de novidades.Esta plataforma foi concebida extamente pra isso, explore-a e se
                            informe!</p>
                    </div>
                </div>
                <div class="item">
                    <img src="./public/img/slide-3.jpg" alt="Third Slide">
                    <div class="carousel-caption">
                        <h3>Não perca mais nenhuma Notícia</h3>
                        <p>Sem exagero algum, com essa plataforma você será o cara das NOVIDADES!</p>
                    </div>
                </div>
            </div>
        </div>

        <main class="conteudo">
            <div class="posts">
                <?php 
                    require_once './model/Noticia.php';
                    $Noticia = new Noticia();

                    $dados = $Noticia->getTodas();

                    foreach($dados as $noticia):
                ?>
                <div class="panel">
                    <div class="panel-heading">
                        <h2 class="panel-title py-3 px-2"><?php echo $noticia['titulo'] ?></h2>
                    </div>
                    <div class="panel-body">
                        <ul class="list-inline">
                            <li><span class="glyphicon glyphicon-time"></span> <?php escreve_data($noticia['data']) ?>
                            </li>
                            <li><span class="glyphicon glyphicon-thumbs-up"></span> <?php echo $noticia['likes'] ?></li>
                            <li><span class="glyphicon glyphicon-thumbs-down"></span> <?php echo $noticia['deslikes'] ?>
                            </li>
                            <li><span class="glyphicon glyphicon-comment"></span> <?php echo $noticia['comentarios'] ?>
                            </li>
                        </ul>
                        <p><?php echo x_palavras($noticia['noticia'],20) ?>
                            <?php if(x_palavras($noticia['noticia'],20) != $noticia['noticia']): ?>
                            <a href='#' class="ler_mais" data-id-noticia='<?php echo $noticia['id'] ?>'>ler mais</a>
                            <?php endif ?>
                        </p>

                        <div id="ops">
                            <ul>
                                <?php if(!$ehADM): ?>
                                <?php 
                                    require_once './model/conexao.php';
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
                                    <span class="ler_mais"
                                        data-id-noticia="<?php echo $noticia['id'] ?>">comentar</span>
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
                                    <span class="editar_noticia"
                                        data-id-noticia="<?php echo $noticia['id'] ?>">editar</span>
                                </li>
                                <li>
                                    <span class="fa fa-trash"></span>
                                    <span class="eliminar_noticia"
                                        data-id-noticia="<?php echo $noticia['id'] ?>">eliminar</span>
                                </li>

                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div> <!-- posts -->

        </main>


    </div> <!-- container-->

    <div class="container-fluid">
        <section class="row noticias">
            <div class="container">
                <div class="col-xs-12 mb-5 pesquisa">
                    <div class="input-group">
                        <input type="search" id="noticia" class="form-control"
                            placeholder="Pesquise o titulo de alguma noticia">
                        <span class="input-group-btn">
                            <button class="btn btn-dark btn-pesquisa"><span class="fa fa-search"></span></button>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php
                        $mais_comentada = $Noticia->getMaisComentada();
                    ?>
                    <h3><span class="cc1">Mais comentada</span> - <?php escreve_data($mais_comentada['data']) ?></h3>
                    <p><a href="#" class="ler_mais"
                            data-id-noticia="<?php echo $mais_comentada['id'] ?>"><?php echo $mais_comentada['titulo'] ?>
                            - <?php echo x_palavras($mais_comentada['noticia'],10).'...' ?> </a>
                    </p>
                </div>
                <div class="col-sm-6">
                    <?php 
                        $mais_reagida = $Noticia->getMaisReagida();
                    ?>
                    <h3><span class="cc2">Mais reagida</span> - <?php escreve_data($mais_reagida['data']) ?></h3>
                    <p><a href="#" class="ler_mais"
                            data-id-noticia="<?php echo $mais_reagida['id'] ?>"><?php echo $mais_reagida['titulo'] ?>
                            - <?php echo x_palavras($mais_reagida['noticia'],10).'...' ?> </a>
                    </p>
                </div>

            </div> <!-- /.container -->
        </section> <!-- /.row -->
    </div> <!-- /.container-fluid -->

    <div id="footer" class="container-fluid text-center text-white">
        &copy; Colégio Chimbanda - Todos os direitos reservados
    </div>

    <?php if($ehADM): ?>
    <div class="publicar">
        <span class="fa fa-plus"></span>
    </div>
    <div class="modal modal1 .modal-back fade" id="modalPublicar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="m-0 text-center">Publicar Notícia</h3>
                    <span class='close' data-dismiss='modal'>&times;</span>
                </div>
                <div class="modal-body">
                    <div action="">
                        <div class="form-group">
                            <label for="titulo" class="control-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo">
                        </div>
                        <div class="form-group">
                            <label for="conteudo" class="control-label">Conteudo</label>
                            <textarea rows="5" class="form-control" id="conteudo"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="quem" class="control-label">Para</label>
                            <input type="text" class="form-control" id="quem" list="para_quem">
                            <datalist id="para_quem">

                            </datalist>
                        </div>
                        <button class="btn btn-secondary btn1 btn2" id="btn_publicar">Publicar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal1 fade" id="modalEditarPub">
        <div class="modal-dialog">
            <div class="modal-content">
                <!--  Aqui ha de aparecer um conteudo dinamicamente -->
            </div>
        </div>
    </div>
    <?php endif ?>

    <div class="modal modal2 fade" id="modalLerNoticia">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- A noticia vai ser carregada dinamicamente -->
                </div>
            </div>
        </div>
    </div>

    <?php if(!$ehADM): ?>
    <!-- MODAL PERFIL -->
    <div class="modal modal1 modal3 fade" id="modalPerfil">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h3 class="m-3 text-center"><span class="fa fa-user"></span> Meu Perfil</h3>
                    <span class='close' data-dismiss='modal'>&times;</span>
                </div>
                <div class="modal-body p-0">
                    <div class="dados_user">
                        <ul>
                            <li>
                                <span class="campo">Nome:</span>
                                <span class="registo"><?php echo $nome ?></span>
                            </li>
                            <li>
                                <span class="campo">Genero:</span>
                                <span class="registo"><?php echo $genero ?></span>
                            </li>
                            <li>
                                <span class="campo">Data de nascimento:</span>
                                <span class="registo"><?php echo $dataNasc ?></span>
                            </li>
                            <li>
                                <span class="campo">Email</span>
                                <span class="registo"><?php echo $email ?></span>
                            </li>
                            <li>
                                <span class="campo">Número de Identificação</span>
                                <span class="registo"><?php echo $numId ?></span>
                            </li>
                            <li>
                                <span class="campo">Você é</span>
                                <span class="registo">
                                    <?php
                                        echo ($tipo == "A")? 'Aluno' : 'Professor';
                                    ?>
                                </span>
                            </li>

                            <!-- Para Aluno -->
                            <?php if($tipo == "A"): ?>
                            <li>
                                <span class="campo">Classe</span>
                                <span class="registo"><?php echo $classe ?></span>
                            </li>
                            <li>
                                <span class="campo">Curso</span>
                                <span class="registo"><?php echo $curso ?></span>
                            </li>
                            <li>
                                <span class="campo">Periodo</span>
                                <span class="registo"><?php echo $periodo ?></span>
                            </li>
                            <?php endif ?>
                            <!-- Para professor -->
                            <?php if($tipo == "P"): ?>
                            <li>
                                <span class="campo">Disciplina</span>
                                <span class="registo"><?php echo $disciplina ?></span>
                            </li>
                            <?php endif ?>
                            <!-- Envie o ID do Usuario tambem, isso para testar se a senha esta certa -->
                        </ul>
                    </div>
                    <div class="rodape">
                        <a href="#" class="alterar_dados">Quero alterar meus dados</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal modal1 modal3 modal4 fade" id="modalAlterarPerfil">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h3 class="m-3 text-center"><span class="fa fa-edit"></span> Editar Perfil</h3>
                    <span class='close' data-dismiss='modal'>&times;</span>
                </div>
                <div class="modal-body p-0">
                    <div class="dados_user">
                        <ul>
                            <li>
                                <span class="campo">Nome:</span>
                                <span class="registo">
                                    <input type="text" class="form-control" id="nome" value="<?php echo $nome ?>">
                                </span>
                            </li>
                            <li>
                                <span class="campo">Genero:</span>
                                <span class="registo">
                                    <input type="text" list="generos" id="genero" class="form-control"
                                        value="<?php echo $genero ?>">
                                </span>
                                <!-- DataList para validar dados -->
                                <datalist id="generos">
                                    <!-- sera carregado os generos dinamicamente -->
                                </datalist>
                            </li>
                            <li>
                                <span class="campo">Data de nascimento:</span>
                                <span class="registo">
                                    <input type="date" id="dataNasc" class="form-control"
                                        value="<?php echo $dataNasc ?>">
                                </span>
                            </li>
                            <li>
                                <span class="campo">Email</span>
                                <span class="registo">
                                    <input type="text" id="email" class="form-control" value="<?php echo $email ?>">
                                </span>
                            </li>
                            <li>
                                <span class="campo">Número de Identificação</span>
                                <span class="registo">
                                    <input type="number" id="numId" class="form-control" value="<?php echo $numId ?>">
                                </span>
                            </li>
                            <!-- Para Aluno -->
                            <?php if($tipo == "A"): ?>
                            <li>
                                <span class="campo">Classe</span>
                                <span class="registo">
                                    <input type="text" list="classes" id="classe" class="form-control"
                                        value="<?php echo $classe ?>">
                                </span>
                                <datalist id="classes">
                                    <!-- vai aparecer as classes  -->
                                </datalist>
                            </li>
                            <li>
                                <span class="campo">Curso</span>
                                <span class="registo">
                                    <input type="text" list="cursos" id="curso" class="form-control"
                                        value="<?php echo $curso ?>">
                                </span>
                                <datalist id="cursos">

                                </datalist>
                            </li>
                            <li>
                                <span class="campo">Periodo</span>
                                <span class="registo">
                                    <input type="text" list="periodos" id="periodo" class="form-control"
                                        value="<?php echo $periodo ?>">
                                </span>
                                <datalist id="periodos">

                                </datalist>
                            </li>
                            <?php endif ?>
                            <!-- Para professor -->
                            <?php if($tipo == "P"): ?>
                            <li>
                                <span class="campo">Disciplina</span>
                                <span class="registo">
                                    <input type="text" list="disciplinas" id="disciplina" class="form-control"
                                        value="<?php echo $disciplina ?>">
                                </span>
                                <datalist id="disciplinas">

                                </datalist>
                            </li>
                            <?php endif?>
                        </ul>
                        <!-- Envie o ID do Usuario tambem, isso para testar se a senha esta certa -->
                    </div>
                    <div class="rodape">
                        <input type="text" class="form-control" id="senha1"
                            placeholder="Digite aqui a sua senha para confirmar as alterações">
                        <a href="#" class="alterar">Alterar dados</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal1 modal3 modal4 fade" id="modalAlterarFoto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h3 class="m-3 text-center"><span class="fa fa-edit"></span> Alterar Foto</h3>
                    <span class='close' data-dismiss='modal'>&times;</span>
                </div>
                <form action="./controllers/alterar_foto.php" method="post" enctype="multipart/form-data"
                    class="modal-body p-0">
                    <div class="dados_user">
                        <ul>
                            <li>
                                <span class="campo">Foto</span>
                                <span class="registo">
                                    <labeL for="foto">
                                        <img src="./public/img/usuarios/<?php echo $foto ?>" class="foto_user">
                                    </label>
                                    <input type="file" size="1000" class="form-control d-none" id="foto" name="foto">
                                </span>
                            </li>
                        </ul>
                        <!-- Envie o ID do Usuario tambem, isso para testar se a senha esta certa -->
                        <div class="rodape">
                            <input type="submit" value="Alterar Foto" class="bg-transparent btn_submit">
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <div class="modal modal1 modal3 modal4 fade" id="modalAlterarSenha">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h3 class="m-3 text-center"><span class="fa fa-edit"></span> Alterar Senha</h3>
                    <span class='close' data-dismiss='modal'>&times;</span>
                </div>
                <div class="modal-body p-0">
                    <div class="dados_user">
                        <li>
                            <span class="campo">Nova Senha</span>
                            <span class="registo">
                                <input type="password" id="novaSenha" class="form-control" value="">
                            </span>
                        </li>
                        <li>
                            <span class="campo">Confirmar Nova Senha</span>
                            <span class="registo">
                                <input type="password" id="confNovaSenha" class="form-control" value="">
                            </span>
                        </li>
                        <!-- Envie o ID do Usuario tambem, isso para testar se a senha esta certa -->
                        </ul>
                    </div>
                    <div class="rodape">
                        <input type="password" class="form-control" id="senha2"
                            placeholder="Digite aqui a sua senha para confirmar as alterações">
                        <a href="#" class="btn_alterar_senha">Alterar Senha</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal1 modal3 modal4 fade" id="modalNoticiasGuardadas">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h3 class="m-3 text-center"><span class="glyphicon glyphicon-save"></span> Noticias Guardadas</h3>
                    <span class='close' data-dismiss='modal'>&times;</span>
                </div>
                <div class="modal-body p-0">
                    <?php 
                        $ids = $Noticia->getIdGuardadas($id);

                        foreach($ids as $id_noticia):
                    ?>
                    <div class="dados_noticia">
                        <?php
                            $noticia = $Noticia->selecionar_noticia($id_noticia);
                        ?>
                        <ul>
                            <li>
                                <span class="campo">Titulo da Noticia</span>
                                <span class="registo">
                                    <?php echo $noticia['titulo'] ?>
                                </span>
                            </li>
                            <li>
                                <span class="campo">Guardado desde</span>
                                <span class="registo">
                                    <?php escreve_data($Noticia->getDataNoticiaGuardada($noticia['id']))  ?>
                                </span>
                            </li>
                            <li>
                                <span class="campo">Ações</span>
                                <span class="registo">
                                    <div class="noticiasAcoes">
                                        <p><a href="#" class="ler_mais"
                                                data-id-noticia="<?php echo $noticia['id'] ?>"><span
                                                    class="fa fa-eye"></span>
                                                Ver</a></p>
                                        <p><a href="#" class="remover_noticia" data-id-usuario="<?php echo $id ?>"
                                                data-id-noticia="<?php echo $noticia['id'] ?>"><span
                                                    class="fa fa-remove"></span> Remover</a></p>
                                    </div>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <?php endforeach ?>
                    <?php if(count($ids) == 0): ?>
                    <h2 class="msg_a">Nenhuma noticia guardada</h2>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>

    <?php if($ehADM): ?>
    <div class="modal modal1 modal3 modal4 fade" id="modalComunidade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h3 class="m-3 text-center"><span class="fa fa-users"></span> Comunidade</h3>
                    <span class='close' data-dismiss='modal'>&times;</span>
                </div>
                <div class="modal-body p-0">
                    <?php 
                        require_once './model/conexao.php';
                        $BD = BD::getConexao();

                        $cmd = $BD->query("SELECT * FROM usuario");
                        $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);

                        foreach($dados as $dado):
                    ?>
                    <div class="dados_usuario">
                        <ul>
                            <li>
                                <span class="campo">Nome do usuario</span>
                                <span class="registo">
                                    <?php echo $dado['nome'] ?>
                                </span>
                            </li>
                            <li>
                                <span class="campo">Ações</span>
                                <span class="registo">
                                    <div class="usuarioAcoes">
                                        <p><a href="#" class="ver" data-id-usuario="<?php echo $dado['id'] ?>"><span
                                                    class="fa fa-eye"></span>
                                                Ver</a></p>
                                        <p><a href="#" class="remover" data-permitido="<?php echo $dado['permitido'] ?>"
                                                data-id-usuario="<?php echo $dado['id'] ?>"><span
                                                    class="fa fa-remove"></span><?php echo ($dado['permitido'] == "sim")?" Bloquear":" Desbloquear" ?></a>
                                        </p>
                                    </div>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <?php 
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal1 modal3 fade" id="modalUsuario">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <h3 class="m-3 text-center"><span class="fa fa-user"></span> Dados do Usuario</h3>
                    <span class='close' data-dismiss='modal'>&times;</span>
                </div>
                <div class="modal-body p-0">
                    <!-- Aqui vai aparecer as info de um usuario -->
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>

    <div class="msg">
        <span class="titulo">
            Titulo da Mensagem
        </span>
        <p>

        </p>
    </div>

    <div class="modal modal1 modal3 fade" id="modalPesquisar">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Aqui vai aparecer os dados da pesquisa -->
            </div>
        </div>
    </div>

    <?php if(!$ehADM): ?>
    <input type="hidden" id="id_usuario" value="<?php echo $id ?>">
    <?php endif ?>

    <script src="./public/lib/bootstrap/js/jquery.js"></script>
    <script src="./public/lib/bootstrap/js/bootstrap.js"></script>
    <script src="./public/js/funcoes.js"></script>
    <script src="./public/js/constantes.js"></script>
    <script src="./public/js/index.js"></script>
</body>

</html>