<?php

    require_once '../helpers/funcoes_gerais.php';
    require_once '../model/Noticia.php';
    $Noticia = new Noticia();
    extract($_GET);

    $noticias = $Noticia->pesquisar($titulo);
    $encontradas = count($noticias);
?>

<div class="modal-header p-0">
    <h3 class="m-3 text-center"><span class="fa fa-search"></span> Resultados da pesquisa</h3>
    <span class='close' data-dismiss='modal'>&times;</span>
</div>
<div class="modal-body p-0">
    <!-- Aqui vai aparecer as info de um usuario -->
    <div class="header-pesquisa">
        <ul>
            <li>Resultados:</li>
            <li><?php echo $encontradas ?></li>
        </ul>
    </div>
    <ul class="list-group">
        <?php 
            foreach($noticias as $noticia):
        ?>
        <a href="#" class="list-group-item ler_mais" data-id-noticia="<?php echo $noticia['id'] ?>"><span
                class="titulo_noticia"><?php echo $noticia['titulo'] ?></span> -
            <span class="cheirinho_noticia"><?php echo x_palavras($noticia['noticia'],5) ?>... </span></a>
        <?php endforeach ?>
    </ul>
</div>

<script>
$('.ler_mais').click(function(e) {
    e.preventDefault();
    $('#modalPesquisar').modal('hide');
    let id_noticia = $(this).attr('data-id-noticia');
    const dados = {
        id_noticia: id_noticia
    }
    $.get('view/dados_noticia.php', dados, function(res) {
        $('#modalLerNoticia .modal-body').html(res);
        $('#modalLerNoticia').modal('show');
        $('#modalLerNoticia').modal('handleUpdate')

    });
    console.log('Chegou aqui');
});
</script>