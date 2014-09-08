'use strict';

var AppFinanci = angular.module('Financi', [ 'ngResource', 'ngMask', 'siyfion.sfTypeahead', 'angular-loading-bar']);

function required(idForm, modal) {

    $(idForm + " input:not([type=hidden]), " + idForm + " select, " + idForm + " textarea").each(function() {
        if ($(this).attr('req') != null) {


            if ($.trim($(this).val()) == '' || $.trim($(this).val()) == '? undefined:undefined ?') {


                if ($(this).attr('name')) {

                    $(this).closest('div').addClass('has-error');

                    if (modal == true) {
                        chamaMsg('11', true);
                    } else {
                        chamaMsg('11', false);
                    }
                };

            } else {
                $(this).closest('div').removeClass('has-error');
            }
        }
    });

    var error = $(idForm).find('.has-error').length;
    return error;

}

function multiplos(numero, limite) {
    console.log('Numero: '+numero+' Limite: '+limite)
    var multiplos = [];
    var i = 1;

    while( (numero * i) <= limite ) {
        multiplos.push({ 'qtd': numero * i });
        i++;
    }

    return multiplos;
}

//Retorna um numro float 
function toFloat(str, toFixed){

     if(str){
        str = parseFloat(str.replace('.', '').replace('.', '').replace('.', '').replace(',', '.'));
     }else{
        str = parseFloat('0');
     }

     if(toFixed){
        str.toFixed(2);
     }

     return str;
}


$(function() {

    /**
     * Eventos dos botões das ações da grid - fechar mensagem
     */
    $('body').undelegate('.no-ask', 'click'); 
    $('body').delegate('.no-ask', 'click', function(event) {

        $(this).closest('.msg-modal-back').fadeOut('fast', function() {
           
        });
    });

    $("body").delegate(".buscar-cep", "click", function(event) {

        var url = "http://m.correios.com.br/movel/buscaCepConfirma.do";
        var width = 330;
        var height = 350;
        var left = parseInt((screen.availWidth / 2) - (width / 2));
        var top = parseInt((screen.availHeight / 2) - (height / 2));
        var windowFeatures = "width=" + width + ",height=" + height + ",status,resizable,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top;
        var NewWindow = window.open(url, "subWind", windowFeatures);

        event.preventDefault();
    });
})