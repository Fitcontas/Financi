/**
 * Responsável por executar expressoes 
 * regulares em elementos input
 * 
 * @package FitContas/
 * @author Marcus Vinicius SS (MarcusMv)
 * @version 1.0
 *  
 * Camada - JavaScript/Geral
 * Diretório Pai - public/js/mask
 * Arquivo - mask.js
 * */
/*<input type="text" onkeyup="mascara(this, mvalor);" />*/
function mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}
function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}
function mcep(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/^(\d{5})(\d)/, "$1-$2") //Esse é tão fácil que não merece explicações
    return v
}
function mcel(v) {
   v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
   v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
   v = v.replace(/(\d)(\d{4})$/, "$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
   return v;
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
//    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function mcnpj(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/^(\d{2})(\d)/, "$1.$2") //Coloca ponto entre o segundo e o terceiro dígitos
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2") //Coloca uma barra entre o oitavo e o nono dígitos
    v = v.replace(/(\d{4})(\d)/, "$1-$2") //Coloca um hífen depois do bloco de quatro dígitos
    return v
}
function mcpf(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
//de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
    
}
//function mdata(v) {
//    v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
//    v = v.replace(/(\d{2})(\d)/, "$1/$2");
//    v = v.replace(/(\d{2})(\d)/, "$1/$2");
//
//    v = v.replace(/(\d{2})(\d{2})$/, "$1$2");
//    return v;
//}
function mtempo(v) {
    v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
    v = v.replace(/(\d{1})(\d{2})(\d{2})/, "$1:$2.$3");
    return v;
}
function mhora(v) {
    v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1h$2");
    return v;
}
function mrg(v) {
    v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
    v = v.replace(/(\d)(\d{7})$/, "$1.$2"); //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
    v = v.replace(/(\d)(\d{4})$/, "$1.$2"); //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
    v = v.replace(/(\d)(\d)$/, "$1-$2"); //Coloca o - antes do último dígito
    return v;
}
function mnum(v) {
    v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
    return v;
}
function mvalor(v) {
    v = v.replace(/\D/g, "");//Remove tudo o que não é dígito
    v = v.replace(/(\d)(\d{8})$/, "$1.$2");//coloca o ponto dos milhões
    v = v.replace(/(\d)(\d{5})$/, "$1.$2");//coloca o ponto dos milhares

    v = v.replace(/(\d)(\d{2})$/, "$1,$2");//coloca a virgula antes dos 2 últimos dígitos
    return v;
}

function showMoney(valor){ 
 
    var casas = 2;
    var separdor_decimal = ',';
    var separador_milhar = '.';

    var valor_total = parseInt(valor * (Math.pow(10,casas)));
    var inteiros =  parseInt(parseInt(valor * (Math.pow(10,casas))) / parseFloat(Math.pow(10,casas)));
    var centavos = parseInt(parseInt(valor * (Math.pow(10,casas))) % parseFloat(Math.pow(10,casas)));
 
    if ( centavos % 10 == 0 && centavos + "".length < 2 ) {
        centavos = centavos + "0";
    } else if(centavos < 10) {
        centavos = "0" + centavos;
    }
  
    var milhares = parseInt(inteiros/1000);
    inteiros = inteiros % 1000; 
 
    var retorno = "";
 
    if(milhares>0){

        var str = milhares.toString();

        if (str.length > 6) {
        var milhares = '';

        for (var i = 0; i < str.length; i++) {

            milhares += str.charAt(i);

            if ((i+1) % 3 == 0) {
                milhares += separador_milhar;
            };
        };

        retorno = milhares+""+retorno;
            
        } else {
            retorno = milhares+""+separador_milhar+""+retorno;
        };


        if(inteiros == 0){
            inteiros = "000";
        } else if(inteiros < 10){
            inteiros = "00"+inteiros; 
        } else if(inteiros < 100){
            inteiros = "0"+inteiros; 
        }
    }

    retorno += inteiros+""+separdor_decimal+""+centavos;
    
    return retorno;
}

/*Moeda  - onkeydown="mascara(this,mmoeda)" maxlength="18" */
function mmoeda(v, verNega) {
    var negativo = false;
    var inicio = /^[-]/;
    if (v.match(inicio)) {
        negativo = true;
    }
    v = v.replace(/\D/g, "");   /*permite digitar apenas números*/

    if (v.length >= 4) {
        v = v.replace(/^0/g, "");
    }
    switch (v.length) {
        case 1:
            {
                /*v = '0,0'+v;*/
                v = v.replace(/(\d{1})$/, "0,0$1");
                break;
            }
        case 2:
            {
                /*v = '0,'+v;*/
                v = v.replace(/(\d{2})$/, "0,$1");
                break;
            }
        default:
            {
                v = v.replace(/(\d{1})(\d{8})$/, "$1.$2");  	/*coloca ponto antes dos últimos 8 digitos*/
                v = v.replace(/(\d{1})(\d{5})$/, "$1.$2");  	/*coloca ponto antes dos últimos 5 digitos*/
                v = v.replace(/(\d{1})(\d{1,2})$/, "$1,$2");	/*coloca virgula antes dos últimos 2 digitos*/
            }

    }
    if (verNega == 1 && negativo) {
        return "-" + v;
    } else {
        return v;
    }
}
function mdata(v) {
    switch (v.length) {
        case 1:
            {
                v = v.replace(/[^0-3]/, "");
                break;
            }
        case 2:
            {
                /*if(v[0]!=0 & v[0]!=1 & v[0]!=2 & v[0]!=3){
                 v=v.replace(/[^0-3]/,"");
                 }*/
                if (v[0] == 3) {
                    v = v.replace(/[^0-1]$/, "");
                }
                if (v[0] == 0) {
                    v = v.replace(/0$/, "");
                }
                break;
            }
        case 3:
            {
                v = v.replace(/[^0-1]$/, "");
                break;
            }
        case 4:
            {
                v = v.replace(/[^0-1]$/, "");
                break;
            }
        case 5:
            {
                if (v[3] == 0) {
                    v = v.replace(/0$/, "");
                }
                if (v[3] == 1) {
                    v = v.replace(/[^0-2]$/, "");
                }
                break;
            }
        case 10:
            {
                if (v.substring(6) < 1) {
                    v = v.replace(/0$/, "");
                }
                break;
            }
    }
    v = v.replace(/\D/g, "");                           /*Remove tudo o que não é dígito*/
    v = v.replace(/^(\d{2})(\d)/, "$1/$2");            /*Coloca barra entre o segundo e o terceiro dígitos*/
    v = v.replace(/^(\d{2})\/(\d{2})(\d)/, "$1/$2/$3"); /*Coloca barra entre o quarto e o quinto*/
    return v;
}

$('body').delegate('.form-group input.cnpj', 'blur', function(event) {
    var value = $(this).val();
    if(value!=''){
        if(validaCnpj(value)==false){

            $(this).closest('div').addClass('has-error').find('input').focus();
            //$(this).closest('div').addClass('has-error');
            //$(this).addClass('error').focus();
            chamaMsg('29',false);
            $("form input.cpf, #clientes input.cnpj").focus();
        }else{
            $(this).closest('div').removeClass('has-error');
            //$(this).removeClass('error');
        }
    }else{
        $(this).closest('div').removeClass('has-error');
        //$(this).removeClass('error');
    }
   
});

//valida o CPF digitado
function validaCpf(icpf) {

    if (icpf.length > 0) {
        var cpf = icpf;
        exp = /\.|\-/g;
        cpf = cpf.toString().replace(exp, "");
        var digitoDigitado = eval(cpf.charAt(9) + cpf.charAt(10));
        var soma1 = 0, soma2 = 0;
        var vlr = 11;
        for (var i = 0; i < 9; i++) {
            soma1 += eval(cpf.charAt(i) * (vlr - 1));
            soma2 += eval(cpf.charAt(i) * vlr);
            vlr--;
        }
        dig01 = (soma1 % 11) < 2 ? 0 : 11 - (soma1 % 11);
        soma2 += dig01 * 2;
        dig02 = (soma2 % 11) < 2 ? 0 : 11 - (soma2 % 11);
        var digitoGerado = dig01.toString() + dig02.toString();
        if (digitoGerado != digitoDigitado ||
                cpf == '12345678909' ||
                cpf == '00000000000' ||
                cpf == '11111111111' ||
                cpf == '22222222222' ||
                cpf == '33333333333' ||
                cpf == '44444444444' ||
                cpf == '55555555555' ||
                cpf == '66666666666' ||
                cpf == '77777777777' ||
                cpf == '88888888888' ||
                cpf == '99999999999') {
            
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}
/*Valida CNPJ*/
function validaCnpj(ObjCnpj) {
    
    if (ObjCnpj.length > 0) {
        var cnpj = ObjCnpj;
        var valida = new Array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
        var dig1 = new Number;
        var dig2 = new Number;
        exp = /\.|\-|\//g;
        cnpj = cnpj.toString().replace(exp, "");
        var digito = new Number(eval(cnpj.charAt(12) + cnpj.charAt(13)));
        for (var i = 0; i < valida.length; i++) {
            dig1 += (i > 0 ? (cnpj.charAt(i - 1) * valida[i]) : 0);
            dig2 += cnpj.charAt(i) * valida[i];
        }
        dig1 = (((dig1 % 11) < 2) ? 0 : (11 - (dig1 % 11)));
        dig2 = (((dig2 % 11) < 2) ? 0 : (11 - (dig2 % 11)));
        if (((dig1 * 10) + dig2) != digito) {
            
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

/*Valida Data*/
function validaDataModal(ObjData) {
    ObjData.value = mdata(ObjData.value);
    var data = soNumeros(ObjData.value);
    if (data.length > 0) {
        var dia = parseInt(parseFloat(data.substring(0, 2)));
        var mes = parseInt(parseFloat(data.substring(2, 4)));
        var ano = parseInt(parseFloat(data.substring(4, 8)));
        if (data.length > 7) {
            var DataVal = new Date(ano, mes - 1, dia);
            if (DataVal.getDate() == dia) {
                if (DataVal.getMonth() + 1 == mes) {
                    if (DataVal.getFullYear() == ano) {
                        return true;
                    } else {
                        chamaAlertaModal('modal', 'Data inválida. Por favor faça o preenchimento correto!', data);
                        $('#mensagem #MsgFechar').focus();
                        return false;
                    }
                } else {
                    chamaAlertaModal('modal', 'Data inválida. Por favor faça o preenchimento correto!', data);
                    $('#mensagem #MsgFechar').focus();
                    return false;
                }
            } else {
                chamaAlertaModal('modal', 'Data inválida. Por favor faça o preenchimento correto!', data);
                $('#mensagem #MsgFechar').focus();
                return false;
            }
        } else {
            chamaAlertaModal('modal', 'Data inválida. Por favor faça o preenchimento correto!', data);
            $('#mensagem #MsgFechar').focus();
            return false;
        }
    } else {
        return true;
    }
}
/*Valida CEP */
function validaCep(cep) {
    if (cep.value.length > 0) {
        exp = /\d{2}\.\d{3}\-\d{3}/
        if (!exp.test(cep.value)) {
            chamaAlerta('CEP inválido. Favor informar um número válido!', cep);
            $('#mensagem #MsgFechar').focus();
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}
/*Valida email*/
function validaEmail(mail) {
    var obj = $(mail).val();
    var email = obj;
    if (email.length > 0) {
        var padrao = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
        if (!email.match(padrao)) {
            chamaAlerta('Email inválido. Favor informar um email válido!', mail);
            $('#mensagem #MsgFechar').focus();
            return false;
        } else {
            return true;
        }
    }
}
/*Valida Telefone */
function validaTel(tel) {
    if (tel.value.length > 0) {
        exp = /\d{4}\-\d{4}/
        if (!exp.test(tel.value)) {
            chamaAlerta('Telefone inválido. Favor informar um numero válido!', tel);
            $('#mensagem #MsgFechar').focus();
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}
/*Valida Telefone */
function validaNovoTel(tel) {
    if (tel.value.length > 0) {
        exp = /\d{5}\-\d{4}/
        if (!exp.test(tel.value)) {
            chamaAlerta('Telefone inválido. Favor informar um numero válido!', tel);
            $('#mensagem #MsgFechar').focus();
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}
/*Valida DDD Telefone */
function validaDDD(ddd) {
    ddd.value = soNumeros(ddd.value);
    if (ddd.value.length > 0) {
        if (ddd.value.length < 2 | ddd.value == '00') {
            chamaAlerta('DDD inválido. Favor informar um numero válido!', ddd);
            $('#mensagem #MsgFechar').focus();
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}
/*Valida CPF/CNPJ*/
function validaCPFCNPJ(ObjCpfCnpj) {
    if (soNumeros(ObjCpfCnpj.value).length <= 11) {
        return validaCpf(ObjCpfCnpj);
    } else {
        return validaCnpj(ObjCpfCnpj);
    }
}

String.prototype.cnpj = function() {
    var v = this.toString();
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/^(\d{2})(\d)/, "$1.$2") //Coloca ponto entre o segundo e o terceiro dígitos
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2") //Coloca uma barra entre o oitavo e o nono dígitos
    v = v.replace(/(\d{4})(\d)/, "$1-$2") //Coloca um hífen depois do bloco de quatro dígitos
    return v
};

String.prototype.cpf = function() {
    var v = this.toString();
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
//de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
};

String.prototype.phone = function() {
    var v = this.toString();
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{4})(\d)/, "$1-$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    return v;
};

Number.prototype.moneyFormat = function() {
    var v = this.toString();
    console.log(v);
}