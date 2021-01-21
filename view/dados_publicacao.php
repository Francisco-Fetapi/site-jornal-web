<?php

    require_once '../model/Noticia.php';
    $Noticia = new Noticia();
    extract($_GET);

    $noticia = $Noticia->getNoticia($id);
    $grupo = $noticia['grupo'];
    if($grupo == "A") $grupo = "Alunos";
    if($grupo == "P") $grupo = "Professores";
    if($grupo == "T") $grupo = "Todos";
?>

<div class="modal-header">
    <h3 class="m-0 text-center"> <span class="fa fa-pencil-square-o"></span> Editar Notícia</h3>
    <span class='close' data-dismiss='modal'>&times;</span>
</div>
<div class="modal-body">
    <div>
        <div class="form-group">
            <label for="titulo" class="control-label">Titulo</label>
            <input type="text" class="form-control" value="<?php echo $noticia['titulo'] ?>" id="titulo_e">
        </div>
        <div class="form-group">
            <label for="conteudo" class="control-label">Conteudo</label>
            <textarea rows="5" class="form-control" id="conteudo_e"><?php echo $noticia['noticia'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="quem" class="control-label">Para</label>
            <input type="text" class="form-control" value="<?php echo $grupo ?>" id="quem_e" list="para_quem">
        </div>
        <button class="btn btn-secondary btn1 btn2" data-id-noticia="<?php echo $noticia['id'] ?>"
            id="btn_atualizar">Atualizar</button>
    </div>
</div>

<script>
// EDITAR
$('#btn_atualizar').click(function() {
    let titulo = $('#titulo_e').val();
    let conteudo = $('#conteudo_e').val();
    let quem = $('#quem_e').val();
    let id = $(this).attr('data-id-noticia');


    if (titulo.length == 0 || conteudo.length == 0) {
        funcao.informar({
            tipo: 'erro',
            msg: 'Nenhum dado pode estar vazio',
            titulo: 'Campo Vazio',
            tempo: 4
        });
    } else if (!constante.para_quem.includes(quem)) {
        funcao.informar({
            tipo: 'erro',
            msg: 'O campo \'Para\' tem de estar com valores como <b>Alunos</b> , <b>Professores</b> ou <b>Todos</b> ',
            titulo: 'Publico alvo inválido',
            tempo: 8
        });
    } else { //se deu tudo certo
        const dados = {
            titulo: titulo,
            noticia: conteudo,
            grupo: quem,
            id: id
        }

        if (dados.grupo == "Todos") dados.grupo = "T";
        if (dados.grupo == "Alunos") dados.grupo = "A";
        if (dados.grupo == "Professores") dados.grupo = "P";

        $.get('controllers/editar_noticia.php', dados, function(res) {
            if (res == 'certo') window.location.reload();
        });
        console.log(dados);
    }

});
</script>