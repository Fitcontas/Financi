'use strict';

var AppFinanci = angular.module('Financi', ['ngResource', 'ngMask', 'siyfion.sfTypeahead']);

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

$(function() {

    /**
     * Eventos dos botões das ações da grid - fechar mensagem
     */
    $('body').undelegate('.no-ask', 'click'); 
    $('body').delegate('.no-ask', 'click', function(event) {

        $(this).closest('.msg-modal-back').fadeOut('fast', function() {
           
        });
    });

})