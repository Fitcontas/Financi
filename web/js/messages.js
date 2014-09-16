/**
 * Responsável por efetuar tradução de codigos em mensagens para exibição
 *
 * @package FitContas
 * @author Gilglécio Santos <gilglecio_765@hotmail.com>
 * @version 2.0
 *
 * Camada - JavaScript/Geral
 * Diretório Pai - public/js
 * Arquivo - messages.js
 *
 *
 * Função Traduz Mensagens
 */

var FitMessage = (function() {

    "use strict";

    var FitMessage = {};

    /**
     * Legenda
     *  t : success|info|warning|danger             Tipo da mensagen
     *  i : check|info-circle|warning|times-circle  Icone da mensagen
     *  b : body                                    Corpo da mensagem
     *  a : ask 1|0                                 Se é uma pergunta
     */
    FitMessage.list = function(code) {

        // b=body, t=type, tm=timer, a=ask
        var list = {

            0: {
                b: 'Codigo não reconhecido! #' + code,
                t: 'i',
                tm: false
            },

            1: {
                b: 'Cadastro realizado com sucesso!',
                t: 's'
            },
            2: {
                b: 'Registro(s) excluído(s) com sucesso!',
                t: 's'
            },
            3: {
                b: 'Registro(s) habilitado(s) com sucesso!',
                t: 's'
            },
            4: {
                b: 'Registro(s) desabilitado(s) com sucesso!',
                t: 's'
            },
            5: {
                b: 'Registro editado com sucesso!',
                t: 's'
            },
            6: {
                b: 'Limite de crédito atualizado com sucesso!',
                t: 's'
            },
            7: {
                b: 'Títulos em atraso atualizado com sucesso!',
                t: 's'
            },
            8: {
                b: 'Contato adicionado com sucesso!',
                t: 's'
            },

            9: {
                b: 'Existe(m) registro(s) selecionado(s) que não tem e-mail cadastrado(s). Favor cadastre o(s) e-mail(s) antes de enviar.',
                tm: 1,
                t: 'w'
            },

            10: {
                b: 'Selecione ao menos um registro!',
                tm: 0,
                t: 'w'
            },
            11: {
                b: 'Favor preencher o(s) campo(s) obrigatório(s).',
                tm: 0,
                t: 'd'
            },
            12: {
                b: 'O código informado já está em uso!',
                tm: 0,
                t: 'w'
            },
            13: {
                b: 'Grupo de clientes já existente!',
                tm: 0,
                t: 'w'
            },
            14: {
                b: 'Grupo de fornecedores já existente!',
                tm: 0,
                t: 'w'
            },
            15: {
                b: 'Grupo de usuários já existente!',
                tm: 0,
                t: 'w'
            },
            16: {
                b: 'Motivo de ajuste de saldo já existente!',
                tm: 0,
                t: 'w'
            },
            17: {
                b: 'Informe o CEP!',
                t: 'w'
            },
            18: {
                b: 'O CEP informado não foi encontrado. Favor verifique se o mesmo está correto!',
                t: 'w'
            },
            19: {
                b: 'O telefone informado é inválido!',
                t: 'd'
            },
            20: {
                b: 'Tem certeza que deseja excluir o(s) registro(s) selecionado(s)?',
                t: 'i',
                a: 1,
                tm: 0
            },
            21: {
                b: 'Tem certeza que deseja desabilitar o(s) registro(s) selecionado(s)?',
                t: 'i',
                a: 1,
                tm: 0
            },
            22: {
                b: 'O(s) registro(s) selecionado(s) não pode(m) ser habilitado(s).',
                t: 'd'
            },
            23: {
                b: 'Deseja confirmar a edição?',
                t: 'i',
                a: 1,
                tm: 0
            },
            24: {
                b: 'A senha deve conter no mínimo 6 caracteres.',
                t: 'd',
                tm: 0
            },
            25: {
                b: 'O e-mail informando é inválido.',
                t: 'd',
                f: 1
            },
            26: {
                b: 'A senhas não conferem, por favor digite novamete.',
                t: 'd',
                tm: 0
            },
            27: {
                b: 'CPF inválido. Favor informar um número válido!',
                t: 'd',
                f: 1
            },
            28: {
                b: 'Conta já existente!',
                t: 'd',
                tm: 0
            },
            29: {
                b: 'CNPJ inválido. Favor informar um número válido!',
                t: 'd'
            },
            30: {
                b: 'Já existe um cliente cadastrado com esse CPF. Deseja exibir os dados?',
                t: 'i',
                a: 1,
                tm: 0
            },
            31: {
                b: 'Já existe um cliente cadastrado com esse CNPJ. Deseja exibir os dados?',
                t: 'i',
                a: 1,
                tm: 0
            },
            32: {
                b: 'O CPF informado já está cadastrado para outra pessoa. Favor verificar o número!',
                t: 'd'
            },
            33: {
                b: 'O CNPJ informado já está cadastrado para outra pessoa. Favor verificar o número!',
                t: 'd'
            },
            34: {
                b: 'Deseja confirmar a edição do cliente?',
                t: 'i',
                a: 1,
                tm: 0
            },
            35: {
                b: 'O(s) registro(s) selecionado(s) já está(ão) em uso e por isso não pode(m) ser excluído(s) do sistema.',
                t: 'd'
            },
            36: {
                b: 'Configuração de Contas atualizado com sucesso!',
                t: 's'
            },
            37: {
                b: 'A soma dos percentuais de rateio devem ser igual a 100%.',
                t: 'd'
            },
            38: {
                b: 'Contas para rateio cadastrada com sucesso!',
                t: 's'
            },
            39: {
                b: 'Já existe uma pessoa cadastrada com esse CPF. Deseja exibir os dados?',
                t: 'i',
                a: 1,
                tm: 0
            },
            40: {
                b: 'Já existe uma pessoa cadastrada com esse CPF. Deseja exibir os dados?',
                t: 'i',
                a: 1,
                tm: 0
            },
            41: {
                b: 'Aguarde procesando...',
                t: 'i',
                tm: 0
            },
            42: {
                b: 'Cartão já existente!',
                t: 'd',
                tm: 0
            },
            43: {
                b: 'O tipo de Movimento Bancario já existe!',
                t: 'd',
                tm: 0
            },
            44: {
                b: 'Não é possível desabilitar o grupo de usuários ao qual você pertence!',
                t: 'd',
                tm: 0
            },
            45: {
                b: 'Você deve selecionar as contas para fazer o rateio!',
                t: 'd',
                tm: 0
            },
            46: {
                b: 'O usuário Master não pode ser excluído!',
                t: 'd',
                tm: 0
            },
            47: {
                b: 'O usuário Master não pode ser desabilitado!',
                t: 'd',
                tm: 0
            },
            48: {
                b: 'Já existe uma pessoa cadastrada com esse CNPJ. Deseja exibir os dados?',
                t: 'i',
                a: 1,
                tm: 0
            },
            49: {
                b: 'Já existe um fornecedor cadastrado com esse CPF. Deseja exibir os dados?',
                t: 'i',
                a: 1,
                tm: 0
            },
            50: {
                b: 'Já existe um fornecedor cadastrado com esse CNPJ. Deseja exibir os dados?',
                t: 'i',
                a: 1,
                tm: 0
            },
            51: {
                b: 'Tem certeza que deseja limpar o rateio?',
                t: 'i',
                a: 1,
                tm: 0
            },
            52: {
                b: 'Registro existe e está desabilitado, habilitá-lo?',
                t: 'i',
                tm: 0,
                a: 1
            },
            53: {
                b: 'Apenas um título por vez pode ser prorrogado.',
                t: 'd',
                tm: 1
            },
            54: {
                b: 'Antes de descontar um título é necessário informar a conta contábil onde o mesmo será apropriado. Deseja cadastrar agora?',
                t: 'i',
                a: 1,
                tm: 0
            },
            55: {
                b: 'Antes de prorrogar um título é necessário informar a conta contábil onde o mesmo será prorrogado. Deseja cadastrar agora?',
                t: 'i',
                a: 1,
                tm: 0
            },
            56: {
                b: 'Apenas um título por vez pode ser selecionado.',
                t: 'd',
                tm: 1
            },

            // Mensagens dos cancelamentos das ações de movimento de títulos

            57: {
                b: 'Cancelamento(s) realizado(s) com sucesso.',
                t: 's',
                tm: 1
            },

            // Mensagens das ações de movimento de títulos
            58: {
                b: 'Titulo(s) quitado(s) com sucesso.',
                t: 's',
                tm: 1
            },
            59: {
                b: 'Titulo(s) cancelado(s) com sucesso.',
                t: 's',
                tm: 1
            },
            60: {
                b: 'Titulo(s) refinanciado(s) com sucesso.',
                t: 's',
                tm: 1
            },
            61: {
                b: 'Titulo(s) prorrogado(s) com sucesso.',
                t: 's',
                tm: 1
            },
            62: {
                b: 'Titulo(s) descontado(s) com sucesso.',
                t: 's',
                tm: 1
            },
            63: {
                b: 'Titulo(s) devolvido(s) com sucesso.',
                t: 's',
                tm: 1
            },
            64: {
                b: 'Titulo(s) baixado(s) com sucesso.',
                t: 's',
                tm: 1
            },
            65: {
                b: 'Titulo(s) apropriado(s) como perda.',
                t: 's',
                tm: 1
            },
            66: {
                b: 'Titulo(s) negativado(s) como perda.',
                t: 's',
                tm: 1
            },

            67: {
                b: 'O número do convênio deve conter 4, 6 ou 7 caracteres.',
                t: 'd',
                tm: 1
            },
            68: {
                b: 'Favor informar pelo menos um endereço de e-mail para o(s) registro(s) destacado(s).',
                t: 'd',
                tm: 1
            },
            69: {
                b: 'E-mail(s) enviado(s) com sucesso.',
                t: 's',
                tm: 1
            },
            70: {
                b: 'Enviando boletos. Aguarde mensagem de confirmação',
                t: 'i',
                tm: 0
            },
            71: {
                b: 'Antes de quitar um título é necessário informar a conta contábil onde o mesmo será apropriado. Deseja cadastrar agora?',
                t: 'i',
                a: 1,
                tm: 0
            },
            72: {
                b: 'Deseja confirmar esta ação?',
                t: 'i',
                a: 1,
                tm: 0
            },
            82: {
                b: 'Código de ativação inválida.',
                t: 'd'
            },
            83: {
                b: 'As senhas devem ser iguais.',
                t: 'd'
            },
            84: {
                b: 'O E-mail informado é inválido.',
                t: 'd'
            },
            85: {
                b: 'O e-mail informado já esta cadastrado.',
                t: 'd'
            },
            86: {
                b: 'Redirecionando...',
                t: 's',
                tm: false
            },
            87: {
                b: 'Usuário não encontrado.',
                t: 'd'
            },
            88: {
                b: 'E-mail ou Senha inválidos.',
                t: 'd'
            },
            89: {
                b: 'Você precisa se autenticar.',
                t: 'd'
            },
            90: {
                b: 'Não foi possivel entrar no sistema, favor tentar novamente.',
                t: 'd'
            },
            91: {
                b: 'Favor informar e-mail e/ou senha.',
                t: 'd'
            },
            92: {
                b: 'Usuário inativo no sistema.',
                t: 'd'
            },
            93: {
                b: 'Usuário desabilitado no sistema.',
                t: 'd'
            },
            94: {
                b: 'A data informada não pode ser retroativa a data da criação da conta ou maior que a data atual.',
                t: 'd'
            },
            95: {
                b: 'Não foi possível completar a operação, por favor tente mais tarde.',
                t: 'd'
            },
            96: {
                b: 'Data incompatível com à(s) conta(s) selecionada(s)!',
                t: 'd'
            },
            97: {
                b: 'Saldo insuficiente para data informada!',
                t: 'd'
            },
            98: {
                b: 'Data incompatível com à(s) conta(s) selecionada(s)!',
                t: 'd'
            },
            99: {
                b: 'Saldo insuficiente para data informada!',
                t: 'd'
            },
            100: {
                b: 'As contas se coicidem.',
                t: 'd'
            },
            101: {
                b: 'Não foi possível incluir a natureza na busca.',
                t: 'd'
            },
            102: {
                b: 'A data inicial tem que ser menor que a data final.',
                t: 'd'
            },
            103: {
                b: 'Verifique, existe contas repetidas no rateio.',
                t: 'd'
            },
            104: {
                b: 'Módulo não encontrado.',
                t: 'd'
            },
            105: {
                b: 'A data de nascimento não pode ser maior que a data atual.',
                t: 'd'
            },
            106: {
                b: 'A data de expedição não pode ser maior que a data atual.',
                t: 'd'
            },
            107: {
                b: 'A data de fundação não pode ser maior que a data atual.',
                t: 'd'
            },
            108: {
                b: 'Sessão expirada, faça login e tente novamente.',
                t: 'd'
            },
            109: {
                b: 'A soma das parcelas não corresponde ao valor do parcelamento.',
                t: 'd'
            },
            110: {
                b: 'O valor digitado não confere com o valor total do documento. <br>Deseja que o sistema preencha o valor correto?',
                t: 'i',
                a: 1,
                tm: 0
            },
            111: {
                b: 'Não foi adicionado nenhum meio de pagamento.',
                t: 'd'
            },
            112: {
                b: 'A soma do valor das parcelas deve ser igual ao valor total do documento.',
                t: 'd'
            },
            113: {
                b: 'Desculpe, houve um erro interno no servidor, por favor entre em contato com o suporte.',
                t: 'd'
            },
            114: {
                b: 'Pessoa não informada/cadastrada.',
                t: 'd'
            },
            115: {
                b: 'Só pode ser selecionado títulos da mesma natureza.',
                t: 'd'
            },
            116: {
                b: 'Só pode ser selecionado títulos do mesmo sacado.',
                t: 'd'
            },
            117: {
                b: 'Este financeiro não pode ser editado, pois sofreu modificação.',
                t: 'd'
            },
            118: {
                b: 'Somente títulos de mesmo tipo de conta podem ser selecionados.',
                t: 'd'
            },
            119: {
                b: 'Somente títulos de mesma conta podem ser selecionados.',
                t: 'd'
            },

            120: {
                b: 'O(s) título(s) do tipo cartão não pode(m) ser selecionado(s).',
                t: 'd'
            },

            121: {
                b: 'Somente título(s) do tipo cartão pode(m) ser selecionado(s).',
                t: 'd'
            },

            122: {
                b: 'Os títulos marcados fazem partem de um borderô.',
                t: 'd'
            },

            123: {
                b: 'A imagem foi salva com sucesso.',
                t: 's'
            },
            124: {
                b: 'A senha atual está incorreta.',
                t: 'd',
                tm: 0
            },
            125: {
                b: 'Parabéns, seu perfil foi atualizado com sucesso!',
                t: 's'
            },
            126: {
                b: 'O(s) campo(s) a seguir são obrigatório(s) para alterar a senha: ',
                t: 'd',
                tm: 0
            },
            127: {
                b: 'O campo nome deve ter no mínimo 3 caracteres',
                t: 'd',
                tm: 0
            },
            128: {
                b: 'Sua conta foi atualizada com sucesso!',
                t: 's'
            },
            129: {
                b: 'A logomarca deve ter no máximo 1MB (1024kB)!',
                t: 'd',
                tm: 0
            },
            130: {
                b: 'O tipo de arquivo da logomarca é inválido, permitidos: JPEG, PNG e GIF!',
                t: 'd',
                tm: 0
            },
            131: {
                b: 'Pessoa cadastrada com sucesso!',
                t: 's',
                tm: 1
            },
            132: {
                b: 'Para a geração dos boletos é necessário preencher os dados da sua conta.',
                t: 'i',
                tm: 0
            },
            133: {
                b: 'Para o envio de boletos é necessário a configuração de email. Deseja configurar agora?',
                t: 'i',
                tm: 0,
                a: 1
            },
            134: {
                b: 'Data informada inválida.',
                t: 'd',
            },
            135: {
                b: 'Rascunho salvo com sucesso!',
                t: 's',
                tm: 1
            },
            136: {
                b: 'Relatório enviado com sucesso!',
                t: 's',
                tm: 1
            },
            137: {
                b: 'Desculpe, ocorreu uma falha no envio, verifique o(s) e-mail(s) digitado(s)!',
                t: 'd',
                tm: 0
            },
            138:  {
                b: 'Este cliente encontra-se desabilitado e não pode ser selecionado.',
                t: 'd',
                tm: 0
            },
            139:  {
                b: 'Este fornecedor encontra-se desabilitado e não pode ser selecionado.',
                t: 'd',
                tm: 0
            },
            140:  {
                b: 'A data de vencimento não pode ser menor que a data de emissão do documento.',
                t: 'd',
                tm: 0
            },
            141:  {
                b: 'A data de emissão não pode ser maior que a data de vencimento do documento.',
                t: 'd',
                tm: 0
            },
            142:  {
                b: 'A data de pagamento não pode ser menor que a data de emissão do documento.',
                t: 'd',
                tm: 0
            },
            143:  {
                b: 'Não foi adicionado valor ao documento.',
                t: 'd',
                tm: 0
            },
            144:  {
                b: 'Favor gerar as parcelas antes de salvar.',
                t: 'd',
                tm: 0
            },
            145:  {
                b: 'O quantidade de parcelas informada é diferente da quantidade de parcelas geradas.',
                t: 'd',
                tm: 0
            },
            146:  {
                b: 'O valor do desconto não poder maior que o valor do documento.',
                t: 'd',
                tm: 0
            },
            147:  {
                b: 'A soma das parcelas não podem ser diferente do valor do documento.',
                t: 'd',
                tm: 0
            },
            148:  {
                b: 'A soma das parcelas dos cheques está menor que o valor.',
                t: 'd',
                tm: 0
            },
            149:  {
                b: 'A soma das parcelas dos cheques está maior que o valor.',
                t: 'd',
                tm: 0
            },
            150: {
                b: 'O valor da entrada está abaixo do mínimo permitido',
                t: 'd',
                tm: false
            },
            
            500: {
                b: 'Erro no processamento no servidor...',
                t: 'd'
            },
            502: {
                b: 'Você não tem a permissão necessária para acessar esta página.',
                t: 'd'
            },


        };

        return list[code] ? list[code] : list[0]; // caso n existe a key mande a 0
    };

    /**
     * Tipos de mensagens
     */
    FitMessage.types = function(type) {

        // c=class, t=icon, t=title
        return {
            s: {
                c: 'success',
                i: 'check',
                t: 'Ok!'
            },
            w: {
                c: 'warning',
                i: 'warning',
                t: 'Ops!'
            },
            d: {
                c: 'danger',
                i: 'times-circle',
                t: 'Ops!'
            },
            i: {
                c: 'info',
                i: 'question-circle',
                t: 'Ops!'
            }
        }[type];
    };

    /**
     * Gera um timout da mensagem de acorodo com a quantidade de caracteres
     *
     * @param {string} Mensagem
     * @return {integer} Tempo em milissegundo da mensagem
     */
    FitMessage.timer = function(body) {
        var strLen = body.length;
        var timer = (strLen / 70) * 2000;
        return timer;
    };

    /**
     * Exibe a mensagem
     *
     * @param  {numeric} code      Código da mensagem corresponde a FitMessage.list()
     * @param  {Boolean} is_modal  Se a mensagem será exibida em um modal ou não
     * @param  {string}  action    Quando for uma pergunta, você pode passar uma acação personalizada nos bottões
     * @param  {object}  paramns   Podem ser recuperados depois na mensagem, $(this).attr('data-param0');
     * @return {void}
     */
    FitMessage.show = function(code, is_modal, action, paramns, custom_message) {

        if (typeof action == 'undefined')
            action = 'excluir';

        var str_paramns = '';

        if (typeof(paramns) == 'object') {
            $.each(paramns, function(key, value) {
                str_paramns += ' data-' + key + '="' + value + '" ';
            });
        };

        var find = FitMessage.list(code, custom_message) // selecionando a mensagem pelo codigo
            ,
            type = FitMessage.types(find.t) // selecionando a configurações do tipo, pelo tipo da mensagem selecionada
            ,
            tm = FitMessage.timer(find.b) // timer da mensagem proporcional a quantidade de caracteres
            ,
            el = $('.new-msg' + (is_modal ? '' : '')); // selecioanndo o elemento para prontar a mensagem a ser criada


        var cm = custom_message ? custom_message : '';


        // mensagem pronta para ser exibida
        var m = {
            class: type.c,
            icon: type.i,
            title: type.t,
            body: find.b + cm,
            focus: find.f,
            ask: false,
            timer: true
        };

        // verificando se a mensagem é uma pergunta
        if (find.a)
            m.ask = true;

        // verificando se a mensagem terá um fadeOut
        if (find.tm == 0)
            m.timer = false;

            var some_html  = '<div class="boot-htop ' + m.class + '"></div>';
                some_html += '<div class="text-center msg-body">';
                some_html += '<div class="i-circle ' + m.class + '"><i class="fa fa-' + m.icon + '"></i></div>';
                some_html += '<h4>' + m.title + '</h4>';
                some_html += '<p>' + m.body + '</p>';
                some_html += '</div>';

            var html = '<div class="msg-modal-back"><div class="msg-modal alert alert-' + m.class + ' alert-white rounded">';
          
            html += some_html; 
            
            // se for uma pergunta exiba os botões de ações
            if (m.ask) {
                html += '<div class="text-right">';
                html += '<button class="btn btn-primary btn-flat  " ' + str_paramns + ' action="' + action + '" type="button">Sim</button>';
                html += '<button class="btn btn-default btn-flat no-ask" type="button">Não</button>';
                html += '</div>';
            }else{
                html += '<div class="text-right">';
                html += '<button class="btn btn-default btn-flat no-ask" type="button">Fechar</button>';
                html += '</div>';
            }

        html += '</div>';
        html += '</div>';

        el.finish().html('').fadeIn(0).html(html);

        if (type.c == 'success')

        el.delay(tm).fadeOut('fast');

    }
    /**
     * Exibe a mensagem
     *
     * @param  {numeric} code      Código da mensagem corresponde a FitMessage.list()
     * @param  {Boolean} is_modal  Se a mensagem será exibida em um modal ou não
     * @param  {string}  action    Quando for uma pergunta, você pode passar uma acação personalizada nos bottões
     * @param  {object}  paramns   Podem ser recuperados depois na mensagem, $(this).attr('data-param0');
     * @return {void}
     */
    FitMessage.alert = function(code) {

        var find = FitMessage.list(code, false),
            type = FitMessage.types(find.t),
            tm = FitMessage.timer(find.b);   

        var m = {
            class: type.c,
            icon: type.i,
            title: type.t,
            body: find.b,
            ask: false,
            timer: true
        };

        $("#alertdiv").remove();

        $('.login-msg').append('<div id="alertdiv" class="alert alert-'+ m.class + '"><a class="close" data-dismiss="alert">×</a><span>'+m.body+'</span></div>')

        setTimeout(function() { 
            $("#alertdiv").remove();
        }, 5000);
    }

    /**
     * Remove Mensagem
     * @param {Boolean} is_modal Informa qual mensagem sera removida do modal ou tela
     */
    FitMessage.remove = function(is_modal) {
        var el = $('.mensagem' + (is_modal ? '' : ''));
        el.finish().html('').fadeOut(500);
    };

    return {
        show: FitMessage.show,
        alert: FitMessage.alert,
        remove: FitMessage.remove,
        get: FitMessage.list,
        timer: FitMessage.timer
    };


}());

function chamaMsg(code, is_modal, action, paramn, custom_message) {
    FitMessage.show(code, is_modal, action, paramn, custom_message);
    $('.msg-modal').find('button:first').focus();
}
function chamaMsgAlert(code) {

    FitMessage.show(code, true, false, false, false);
}

function show_alert(code) {

    FitMessage.alert(code);

}

function removeMsg(is_modal) {
    FitMessage.remove(is_modal);
}

var Example = (function() {
    "use strict";

    var elem,
        hideHandler,
        that = {};

    that.init = function(options) {
        elem = $(options.selector);
    };

    that.show = function(text) {
        clearTimeout(hideHandler);

        elem.find("span").html(text);
        elem.delay(200).fadeIn().delay(4000).fadeOut();
    };

    return that;
}());