'use strict';

AppFinanci.controller('ctrlMinhaConta', function($scope, $http, Usuarios, UsuarioNovo, Grupos) {

    $scope.usuario = {};

    $scope.showForm = function() {
        //$scope.usuario = item ? item : {};

        $http({
            'method': 'get',
            'url': '/minha-conta',
        }).success(function(data) {
            if(data.success) {
                $scope.usuario = data.usuario;
            }
        });

        if($scope.usuario) {
            $('#senha, #senha2').removeAttr('req');
        } else {
            $('#senha, #senha2').prop('req');
        }

        $('.has-error').removeClass('has-error');

        $('#minha_conta_modal').modal({
            show: true,
            backdrop: 'static'
        });
    }

    $scope.salvar = function (usuario, add) {

        /*if(usuario.id) {
            $('#senha, #senha2').removeAttr('required');
        }*/
        
        if(required('#MinhaContaForm', true)) {

            chamaMsg('11', true);
            
        } else {

            if($('#email').val().length > 0 && $('#email2').val().length > 0) {
                if($('#email').val() != $('#email2').val()) {
                    chamaMsg('165', true);
                    $('#email2').closest('div').addClass('has-error');
                    return false;
                }
            }

            if($('#minha_conta_senha_atual').val().length > 0 || $('#minha_conta_senha2').val().length > 0 || $('#minha_conta_senha').val().length > 0) {
                
                if($('#minha_conta_senha_atual').val().length < 6 || $('#minha_conta_senha_atual').val().length > 15) {
                    chamaMsg('24', false);
                    $('#minha_conta_senha_atual').val('').focus();
                    return false;
                }

                if($('#minha_conta_senha').val().length < 6 || $('#minha_conta_senha').val().length > 15) {
                    chamaMsg('24', false);
                    $('#minha_conta_senha').val('').focus();
                    return false;
                }

                if($('#minha_conta_senha2').val().length < 6 || $('#minha_conta_senha2').val().length > 15) {
                    chamaMsg('24', false);
                    $('#minha_conta_senha2').val('').focus();
                    return false;
                }

                if($('#minha_conta_senha').val() != $('#minha_conta_senha2').val()) {
                    chamaMsg('26', false);
                    $('#minha_conta_senha').val('').focus();
                    $('#minha_conta_senha2').val('');
                    return false;
                }

            }

            $http({
                'method': 'post',
                'url': '/minha-conta/update',
                'data': $scope.usuario
            }).success(function(data) {
                if(data.success) {
                    chamaMsg(data.msg, false);
                    $('#minha_conta_modal').modal('hide');
                } else {
                    chamaMsg(data.msg, false);

                    if(data.msg == '158') {
                        $('#minha_conta_senha_atual').val('').focus();
                    }
                }
                //$('#minha_conta_modal').modal('hide');
            });

        }

    };

    if(trocar_senha == 1) {
        chamaMsg('160', false);
        $scope.showForm();
    }

})