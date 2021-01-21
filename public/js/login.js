$(function(){
    funcao.mostrarView('main > .row',0.6);
    funcao.mostrarView('footer',1.3);
    
    const $numId = $('#numId');
    const $senha = $('#senha');

    //$numId.val('111111111');
    //$senha.val('111111');

    $('form').submit(function(e){
        e.preventDefault();

        if((/^\d{9}$/).test($numId.val())){
            if($senha.val().length >= 6){
                //tudo certo
                var dados = {
                    numId:$numId.val(),
                    senha:$senha.val()
                }

                $.get('./controllers/logar.php',dados,function(res){
                    console.log(res);
                    if(res.msg == ""){ //nada aconteceu entao nao existe!
                        funcao.informar({
                            msg:'A <b>senha e/ou número de identificação</b> incorretos!<br> Cadastre-se se ainda não tiveres uma conta!',
                            titulo:'Senha | Num. de identificação',
                            tipo:'erro',
                            tempo:9
                        });
                    }else{ //tudo bem
                        funcao.informar({
                            msg:'Senha e Número de identificação correspondem!',
                            titulo:'Dados Corretos',
                            tipo:'',
                            tempo:3
                        },function(){ //valida se ele esta permitido
                            if(res.msg == "Acesso negado"){
                                funcao.informar({
                                    msg:'Por algum motivo você foi bloqueado pelo Administrador',
                                    titulo:'Acesso bloqueado',
                                    tipo:'erro',
                                    tempo:15
                                },function(){
                                    //redirecione ele para uma area onde irao
                                    // ficar todos os prof nao admitidos
                                });
                            }else{
                                if(res.msg == "OK"){
                                    window.location.href = "index.php";
                                }
                            }
                        });
                    }
                },'json');


            }else{
                funcao.informar({
                    msg:'A senha tem de ter 6 digitos no mínimo',
                    titulo:'Senha inválida',
                    tipo:'erro',
                    tempo:5
                });
            }
        }else{ //numId invalido
            funcao.informar({
                msg:'O número de identificação tem de ter exatamente 9 caracteres!',
                titulo:'Num. de identificação inválido',
                tipo:'erro',
                tempo:5
            });
        }
    });

})