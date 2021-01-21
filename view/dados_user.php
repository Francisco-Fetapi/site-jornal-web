<?php 

    require_once '../model/conexao.php';
    $BD = BD::getConexao();
    // receba o id.
    //pesquise e exiba as informacaoes

    extract($_GET);

    $cmd = $BD->query("SELECT * FROM usuario WHERE id = '$id'");
    $dado = $cmd->fetch();
    extract($dado);

?>

<div class="dados_user">
    <ul>
        <li>
            <span class="campo">Nome:</span>
            <span class="registo"><?php echo $nome ?></span>
        </li>
        <li>
            <span class="campo">Genero:</span>
            <span class="registo"><?php echo ($genero == "M")?"Masculino":"Feminino" ?></span>
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
            <span class="registo"><?php echo ($tipo == "A")?"Aluno":"Professor" ?></span>
        </li>
        <li>
            <span class="campo">Permitido</span>
            <span class="registo"><?php echo $permitido ?></span>
        </li>

        <?php if($tipo == "A"): ?>
        <!-- Para Aluno -->
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

        <?php if($tipo == "P"): ?>
        <!-- Para professor -->
        <li>
            <span class="campo">Disciplina</span>
            <span class="registo"><?php echo $disciplina ?></span>
        </li>
        <?php endif ?>
    </ul>
</div>