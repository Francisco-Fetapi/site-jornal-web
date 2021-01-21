function mostrarView(seletor,tempo){
    setTimeout(() => {
        $(seletor).addClass('ativo');
    }, tempo*1000 || 100);
}
function mostrarLoading(obj,func){
    let msg = obj.msg || 'Aguarde';
    let tempo = obj.tempo || 1.5 //segundos
    const div = $('.loading');

    div.find('p').html(msg);
    div.addClass('ativo');

    setTimeout(() => {
        $('.loading').removeClass('ativo');
        if(func) func();
    }, tempo*1000);
}
function ocultarLoading(){
    const div = $('.loading');
    div.removeClass('ativo');
}
function ocultarView(seletor,tempo){
    $(seletor).removeClass('ativo');
}
function inserirNameNosFormularios(){
    $('input,select').each(function(ind,el){
        if($(el).attr('id')){ //se tem id
            $(el).attr('name',$(el).attr('id')); //o name sera igual ao id
        }
    });
}

function usuarioValidado(usuario){

    if((/[A-Z]\w+\s[A-Z]\w+/g).test(usuario.nome) && usuario.nome.length > 5){
        if(usuario.dataNasc.length != 0){
            if(usuario.genero.length != 0){
                if(usuario.senha.length >= 6){
                    if((/\w+@\w+\.com/gi).test(usuario.email)){
                        if(usuario.numId.length == 9){
                            return true;
                        }else{
                            informar({
                                tipo:'erro',
                                titulo:"Numero de identificacao Invalido",
                                msg:'O Numero de identificacao tem de ter <b>9 digitos<b>!'
                            });
                        }
                    }else{
                        informar({
                            tipo:'erro',
                            titulo:"Email Invalido",
                            msg:'O Email deve estar no sequinte padrao:<br> algo@outrolAlgo.com'
                        });
                    }
                }else{
                    informar({
                        tipo:'erro',
                        titulo:"Senha Invalida",
                        msg:'A senha tem de ter no minimo 6 digitos'
                    });
                }
            }else{
                informar({
                    tipo:'erro',
                    titulo:"Genero Invalido!",
                    msg:'O campo genero nao pode estar vazio'
                });
            }
        }else{
            informar({
                tipo:'erro',
                titulo:"Data de nascimento Invalida!",
                msg:'O campo data deve ser preenchido!'
            });
        }
    }else{ //nome esta errado
        informar({
            tipo:'erro',
            titulo:"Nome Invalido!",
            msg:'O nome inserido eh invalido!<br> Insira apenas 2 nomes!'    
        });
    }

    return false;
}

function informar(obj,func){
    let container = $('.msg');

    container.find('.titulo').html(obj.titulo);
    container.find('p').html(obj.msg);


    container.addClass('ativo');
    container.addClass(obj.tipo);

    $(':button').attr('disabled','disabled');

    setTimeout(()=>{
        container.removeClass('ativo');
        container.removeClass(obj.tipo || '');
        $(':button').removeAttr('disabled');

        if(func) func();
    },obj.tempo * 1000 || 6 * 1000);
}

function cadastrar(usuario){

    if(usuario.genero.includes('Masculino')) usuario.genero = "M";
    else if(usuario.genero.includes('Feminino')) usuario.genero = "F";

    $.get('controllers/Cadastrar.php',usuario,function(res){
        console.log(res);
        if(res.msg == "Cadastrado"){
            mostrarLoading({
                msg:'A sua conta está sendo criada...',
                tempo:3
            },function(){
                window.location.href = "index.php";
            })
        }else{  //provavelmente nunca chegaremos aqui!
            if(res.msg = "Erro"){
                console.log('Este user Ja existe');
            }else{
                console.log('Houve um erro no servidor!');
            }
        }
        
    },'json');
}

function alterarDados(usuario){
    // console.log(usuario);
    if(usuario.genero == "Masculino") usuario.genero = "M";
    if(usuario.genero == "Feminino") usuario.genero = "F";

    $.get('controllers/alterar_dados.php',usuario,function(res){
        if(res.modificado == "sim"){
            informar({
                tipo:'certo',
                titulo:"Dados Alterados!",
                msg:'Seus dados foram alterados',
                tempo:2
            },function(){
                window.location.reload();
            });
        }else{
            informar({
                tipo:'erro',
                titulo:"Senha incorreta",
                msg:'Seus dados não foram alterados',
                tempo:2
            });
            console.log(res);
        }
    },'json')
}

function alterarSenha(dados){

    $.get('controllers/alterar_senha.php',dados,function(res){
        if(res.modificado == "sim"){
            informar({
                tipo:'certo',
                titulo:"Senha Modificada ",
                msg:'Sua senha foi alterada!<br/> <b>Nova Senha:</b>'+dados.novaSenha,
                tempo:3
            },function(){
                window.location.reload();
            });
        }else{
            informar({
                tipo:'erro',
                titulo:"Senha de confirmação incorreta",
                msg:'Sua senha não foi alterada!',
                tempo:2
            });
        }
    },'json')

}

const funcao = {
    mostrarView,
    mostrarLoading,
    inserirNameNosFormularios,
    ocultarView,
    usuarioValidado,
    informar,
    cadastrar,
    alterarDados,
    alterarSenha,
    ocultarLoading
}
