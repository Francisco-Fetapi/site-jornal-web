$(function(){

    $("#carrossel").carousel( 
        { 
        interval: 20000, 
        pause: false 
    });

    // $('#modalPublicar').modal('show');
    $('.publicar').click(function(){
        $('#modalPublicar').modal('show');
    });

    // $('a').click(function(e){
    //     e.preventDefault();
    // });

    function mostrarAguarde(){
        funcao.mostrarLoading({
            tempo:7
        });
    }
    function ocultarAguarde(){
        funcao.ocultarLoading();
    }
    
    // Aqui fica o codigo para carregar uma noticia qualquer
    $('.ler_mais').click(function(e){
        e.preventDefault();

        mostrarAguarde('carregando noticia');

        $('#modalNoticiasGuardadas').modal('hide');
        let id_noticia = $(this).attr('data-id-noticia');
        const dados = {
            id_noticia:id_noticia
        }
        $.get('view/dados_noticia.php',dados,function(res){
            $('#modalLerNoticia .modal-body').html(res);
            $('#modalLerNoticia').modal('show');

            $('#modalLerNoticia').modal('handleUpdate');
            ocultarAguarde();
        });
    });

    $('.ver_perfil').click(function(){
        $('#modalPerfil').modal('show');
    });

    
    //alterar dados
    $('.alterar_dados').click(function(){
        $('#modalPerfil').modal('hide');
        $('#modalAlterarPerfil').modal('show');
    });

    // alterar senha
    $('.alterar_senha').click(function(){
        $('#modalAlterarSenha').modal('show');
    });

    // Alterar foto
    $('.alterar_foto').click(function(){
        $('#modalAlterarFoto').modal('show');
    });


    $('.lista_guardados').click(function(){
        $('#modalNoticiasGuardadas').modal('show');
    });


    // $('#modalComunidade').modal('show');
    $('.comunidade').click(function(){
        $('#modalComunidade').modal('show');
    });

     // Aqui fica o codigo para carregar as info de uma noticia
     
     $('.editar_noticia').click(function(){
         const id_noticia = $(this).attr('data-id-noticia');

        mostrarAguarde();

         $.get('view/dados_publicacao.php',{id:id_noticia},function(res){
            $('#modalEditarPub .modal-content').html(res);
            $('#modalEditarPub').modal('show');
            ocultarAguarde();
        })
        console.log(id_noticia);
    });


     // Aqui fica o codigo para carregar as info de um usuario
     $('.ver').click(function(){
        $('#modalComunidade').modal('hide');
         const id_usuario = $(this).attr('data-id-usuario');

        mostrarAguarde();

        $.get('view/dados_user.php',{id:id_usuario},function(res){
            $('#modalUsuario .modal-body').html(res);
            $('#modalUsuario').modal('show');
            ocultarAguarde();
        })
        $('#modalUsuario').on('hide.bs.modal',function(){
            $('#modalComunidade').modal('show');
        });
    });
     $('.remover').click(function(){
        const id_usuario = $(this).attr('data-id-usuario');
        const permitido = $(this).attr('data-permitido');
        let dados = {
            'id':id_usuario,
            'permitido':permitido
        }
        if(dados.permitido == "sim"){
            $(this).attr('data-permitido','nao');
            dados.permitido = 'nao';
            $(this).html(`<span class='fa fa-remove'></span> Desbloquear`)
        }else{
            $(this).attr('data-permitido','sim');
            dados.permitido = 'sim';
            $(this).html(`<span class='fa fa-remove'></span> Bloquear`)
        }
        console.log(dados);
        $.get('controllers/alterar_permissao.php',dados,function(res){
            console.log(res);
        })
    });

    $('form').submit(function(e){
        // e.preventDefault();
    });

    $('#btn_publicar').click(function(){
        let titulo = $('#titulo').val();
        let conteudo = $('#conteudo').val();
        let para_quem = $('#quem').val();


        if(titulo.length == 0 || conteudo.length == 0){
            funcao.informar({
                tipo:'erro',
                msg:'Nenhum dado pode estar vazio',
                titulo:'Campo Vazio',
                tempo:4
            });
        }else if(!constante.para_quem.includes(para_quem)){
            funcao.informar({
                tipo:'erro',
                msg:'O campo \'Para\' tem de estar com valores como <b>Alunos</b> , <b>Professores</b> ou <b>Todos</b> ',
                titulo:'Publico alvo inválido',
                tempo:8
            });
        }else{ //se deu tudo certo
            const dados = {
                titulo:$('#titulo').val(),
                noticia: $('#conteudo').val(),
                grupo: $('#quem').val()
            }

            if(dados.grupo == "Todos") dados.grupo = "T";
            if(dados.grupo == "Alunos") dados.grupo = "A";
            if(dados.grupo == "Professores") dados.grupo = "P";
            $.get('controllers/publicar_noticia.php',dados,function(res){
                if(res == 'certo') window.location.reload();
            });
            console.log(dados);
        }
        
    });

    $('.eliminar_noticia').click(function(){
        id_noticia = $(this).attr('data-id-noticia');
        const dados = {
            id:id_noticia
        }
        mostrarAguarde();
        let resposta = window.confirm("Tem certeza disso?");
        if(resposta == true){
            $.get('controllers/eliminar_noticia.php',dados,function(res){
                ocultarAguarde();;
                if(res == 'certo') window.location.reload();
            });
        }
    })

    // MENU para dispositivos moveis
    $('.glyphicon-menu-hamburger').click(function(){
        $('#navBar').toggleClass('ativo');
        console.log($('#navBar').attr('class') || 'Nao ativo');
    });


    var $cursos = $('#cursos');
    var $periodos = $('#periodos');
    var $classes = $('#classes');
    var $disciplinas = $('#disciplinas');
    var $generos = $('#generos');
    var $para_quem = $('#para_quem');

    // para todos
    constante.generos.forEach((val,ind)=>{
        $generos.append(`<option value='${val}'>${val}</option> \n`);
    });

    if($('#modalPublicar').length > 0){ //eh ADM
        constante.para_quem.forEach((val)=>{
            $para_quem.append(`<option value='${val}'>${val}</option> \n`);
        });
    }

    if($disciplinas.length > 0){ //entao eh professor
        console.log('Sou professor');
        constante.disciplinas.forEach((val,ind)=>{
            $disciplinas.append(`<option value='${val}'>${val}</option> \n`);
        });
    }else{ //eh aluno
        console.log('Sou Aluno');
        constante.cursos.forEach((val,ind)=>{
            $cursos.append(`<option value='${val}'>${val}</option> \n`);
        });
        constante.periodos.forEach((val,ind)=>{
            $periodos.append(`<option value='${val}'>${val}</option> \n`);
        });
        constante.classes.forEach((val,ind)=>{
            $classes.append(`<option value='${val}'>${val}</option> \n`);
        });
    }
   
    var usuario = {};
    var id_usuario = $('#id_usuario').val();
    usuario.id = id_usuario;

    $('.alterar').click(function(){

        let nome = $('#nome').val();
        let genero = $('#genero').val();
        let dataNasc = $('#dataNasc').val();
        let email = $('#email').val();
        let numId = $('#numId').val();
        let senha = $('#senha1').val();


        if(!(/[A-Z]\w+\s[A-Z]\w+/g).test(nome)){
            funcao.informar({
                msg:'<b>NOTA:</b>Insira o primeiro e último nome. As inicias com maiuscula',
                titulo:'Nome inválido!',
                tipo:'erro'
            });
        }else if(!constante.generos.includes(genero)){
            funcao.informar({
                msg:'Insira um género válido!',
                titulo:'Género inválido!',
                tipo:'erro'
            });
        }else if(!(/\w+@\w+\.com/).test(email)){
            funcao.informar({
                msg:'Insira um email válido!',
                titulo:'Email inválido!',
                tipo:'erro'
            });
        }else if(numId.length != 9){
            funcao.informar({
                msg:'O número de identificação tem de ter 9 digitos!',
                titulo:'Número de identificação inválido!',
                tipo:'erro'
            });
        }else if(senha.length < 6){
            funcao.informar({
                msg:'A senha tem de ter 6 digitos ou mais!',
                titulo:'Formato da senha inválido!',
                tipo:'erro'
            });
        }else{ //info gerais tudo certo
            usuario.nome = nome;
            usuario.genero = genero;
            usuario.dataNasc = dataNasc;
            usuario.email = email;
            usuario.numId = numId;
            usuario.senha = senha;


            if($disciplinas.length == 0){ //eh aluno
                let curso = $('#curso').val();
                let periodo = $('#periodo').val();
                let classe = $('#classe').val();
    
                if(!constante.cursos.includes(curso)){
                    funcao.informar({
                        msg:'O curso informado não está na lista',
                        titulo:'Curso inválido!',
                        tipo:'erro'
                    });
                }else if(!constante.periodos.includes(periodo)){
                    funcao.informar({
                        msg:'O periodo informado não é válido',
                        titulo:'Periodo inválido!',
                        tipo:'erro'
                    });
                }else if(!constante.classes.includes(classe)){
                    funcao.informar({
                        msg:'A Classe informada não é válida',
                        titulo:'Classe inválida!',
                        tipo:'erro'
                    });
                }else{ // tudo ok                    
                    usuario.curso = curso;
                    usuario.periodo = periodo;
                    usuario.classe = classe;
                    usuario.tipo = 'Aluno';
    
                    funcao.alterarDados(usuario);
                }
            }else{ //eh professor
                let disciplina = $('#disciplina').val();
                
    
                if(!constante.disciplinas.includes(disciplina)){
                    funcao.informar({
                        msg:'A disciplina inserida não consta na lista de disciplinas dessa escola!',
                        titulo:'Disciplina inválida!',
                        tipo:'erro'
                    });
                }else{ //tudo ok
                    usuario.disciplina = disciplina;
                    usuario.tipo = 'Professor';
                    funcao.alterarDados(usuario);
                }
            }

        }
        
    });

    $('.btn_alterar_senha').click(function(){
        let novaSenha = $('#novaSenha').val();
        let confNovaSenha = $('#confNovaSenha').val();
        let senha = $('#senha2').val();
        
        let dados = {};

        if(novaSenha < 6 || confNovaSenha < 6  || senha < 6){
            funcao.informar({
                msg:'As senhas têm de ter 6 digitos no minimo',
                titulo:'Senha inválida!',
                tipo:'erro'
            });
        }else if(novaSenha != confNovaSenha){
            funcao.informar({
                msg:'A Nova Senha e confirmar nova senha devem ser iguais',
                titulo:'Nova Senha inválida!',
                tipo:'erro',
                tempo:6
            });
        }else{
            dados.novaSenha = novaSenha; 
            dados.senha = senha;
            
            if($('#disciplina').length == 0){ //eh aluno
                dados.tipo = "Aluno";
            }else{ //eh professor
                dados.tipo = "Professor";
            }

            funcao.alterarSenha(dados);
        }
    });

    // GOSTAR -- na verdade eh REAGIR em geral!
    $('.gostar_noticia').click(function() {
        const dados = {
            id_usuario: $(this).attr('data-id-usuario'),
            id_noticia: $(this).attr('data-id-noticia'),
            tipo:'1'
        }
        mostrarAguarde();
        $.get('controllers/reagir_noticia.php', dados, function() {
            ocultarAguarde();
            window.location.reload();
        })
    });

    // LER MAIS TARDE
    $('.ler_mais_tarde').click(function(){
        let id_usuario = $(this).attr('data-id-usuario');
        let id_noticia = $(this).attr('data-id-noticia');

        const dados = {
            id_usuario:id_usuario,
            id_noticia:id_noticia
        }
        mostrarAguarde();

        $.get('controllers/guardar_noticia.php',dados,function(res){
            ocultarAguarde();
            location.reload();
        })
    });

    $('.remover_noticia').click(function(){
        let id_noticia = $(this).attr('data-id-noticia');
        let id_usuario = $(this).attr('data-id-usuario');

        const dados = {
            id_noticia:id_noticia,
            id_usuario:id_usuario
        }
        mostrarAguarde();

        $.get('controllers/remover_noticia_guardada.php',dados,function(res){
            ocultarAguarde();
            if(res == 'certo') location.reload();
        })
    });

    
    $('.btn-pesquisa').click(function(){
        let titulo = $('#noticia').val();

        const dados = {
            titulo:titulo
        }
        mostrarAguarde();
        $.get('view/dados_pesquisa.php',dados,function(res){
            ocultarAguarde();
            $('#modalPesquisar .modal-content').html(res);
            $('#modalPesquisar').modal('show');
        });
    })
});