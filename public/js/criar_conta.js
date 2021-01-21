$(function(){

    funcao.mostrarView('main > .row',0.6);
    funcao.mostrarView('footer',1.3);

    var usuario = {};

    var $listQuem = $('#listQuem');
    var $cursos = $('#cursos');
    var $periodos = $('#periodos');
    var $classes = $('#classes');
    var $disciplinas = $('#disciplinas');

    //para debug
    // funcao.mostrarLoading({tempo:5,msg:'Aguarde um pouco'})


    constante.tipos_usuarios.forEach((val,ind)=>{
        $listQuem.append(`<option value='${val}'>${val}</option> \n`);
    });
    constante.cursos.forEach((val,ind)=>{
        $cursos.append(`<option value='${val}'>${val}</option> \n`);
    });
    constante.periodos.forEach((val,ind)=>{
        $periodos.append(`<option value='${val}'>${val}</option> \n`);
    });
    constante.classes.forEach((val,ind)=>{
        $classes.append(`<option value='${val}'>${val}</option> \n`);
    });
    constante.disciplinas.forEach((val,ind)=>{
        $disciplinas.append(`<option value='${val}'>${val}</option> \n`);
    });

    $('.form1').submit(function(e){
        e.preventDefault();
        

        usuario.nome = $('#nome').val();
        usuario.dataNasc = $('#dataNasc').val();
        usuario.genero = $('#genero').val();
        usuario.senha = $('#senha').val();
        usuario.email = $('#email').val();
        usuario.numId = $('#numId').val();

        if(funcao.usuarioValidado(usuario)){
            // valida o numId aqui, requisita isso
            $.get('./controllers/Verificar_numId.php',usuario,function(res){
        
                if(res.msg == "N"){ //nao existe um Numid igual
                    informar({
                            msg:'Todos os dados foram inseridos corretamente!',
                            titulo:'Tudo certo!',
                            tipo:'certo',
                            tempo:2
                        },function(){
                            $('#formModal').modal('show');
                        });
                }else if(res.msg == "S"){//sim,existe um igual
                    informar({
                        msg:'O número de identificação inserido já existe, por favor insira um ID diferente.<br> Recomendamos que insira o seu número de telefone!',
                        titulo:'Problema com o N. de identificação!',
                        tipo:'erro',
                        tempo:8
                    });
                    $('#numId').focus();
                }
            },'json');
            
        }        
    });

    $('#formModal form').submit(function(e){
        e.preventDefault();
        let confSenha = $('#confSenha').val();
        let quem = $('#quem').val();

        if(confSenha != usuario.senha){
            funcao.informar({
                msg:'A senha e o confirmar senha devem ser iguais',
                titulo:'Erro ao definir Senha',
                tipo:'erro'
            })
        }else if(!quem.includes("Professor") && !quem.includes("Aluno")){
                funcao.informar({
                    msg:'O campo \'quem és\' está com um valor inválido!<br> Tem de ser \'Professor\' ou \' Aluno\' ',
                    titulo:'Erro no campo \'quem és\' ',
                    tipo:'erro'
            })
        }else{ //confsenha e quem es estao validos

            //validar caso for aluno
            if(quem.includes('Aluno')){
                usuario.tipo = 'Aluno';
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
                    funcao.cadastrar(usuario);
                }
            }else{ //eh professor
                let disciplina = $('#disciplina').val();
                usuario.tipo = 'Professor';

                if(!constante.disciplinas.includes(disciplina)){
                    funcao.informar({
                        msg:'A disciplina inserida não consta na lista de disciplinas dessa escola!',
                        titulo:'Disciplina inválida!',
                        tipo:'erro'
                    });
                }else{ //tudo ok
                    usuario.disciplina = disciplina;
                    funcao.cadastrar(usuario);
                }
            }

        }
    });

    $('#quem').on('input',function(e){
        let texto_digitado = $(this).val();

        if(!(/Professor|Aluno/gi).test(texto_digitado)){
            $('.aluno, .professor').removeClass('ativo').animate({opacity:0},'fast');
        }else{
            if(texto_digitado.includes('Aluno') && !$('.aluno').hasClass('ativo')){
                $('.aluno').addClass('ativo').animate({opacity:1},'slow');
            }else if(texto_digitado.includes('Professor') && !$('.professor').hasClass('ativo')){
                $('.professor').addClass('ativo').animate({opacity:1},'fast');
            }
        }
    });
    $('.dropdown-menu a').click(function(e){
        e.preventDefault();
        let escolha_texto = $(this).text();
        let input = $(this).parent().parent().siblings('input');
        input.val(escolha_texto);
    });

    $('.dropdown-menu a').each(function(ind,el){
        let input = $(this).parent().parent().siblings('input');
        if(input){
            input.addClass('input_select');
        }
    });

})