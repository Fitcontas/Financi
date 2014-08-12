'use strict';

AppFinanci.controller('FormUsuarioCtrl', function($scope, $http, Usuarios, UsuarioNovo) {
    
    $scope.usuario = {};
    $scope.usuarios = [];
    $scope.grupos = [{1: 'Administrador'}];

    $scope.start = function() {
        Usuarios.get().$promise.then(function(data){
            $scope.usuarios = data.usuarios;
        });
    }

    $scope.getGrupo = function(grupo) {
        return $scope.grupos[grupo];
    }

    $scope.showForm = function(item) {
        $scope.usuario = item ? item : {};

        if(item) {
            $('#senha, #senha2').removeAttr('req');
        } else {
            $('#senha, #senha2').prop('req');
        }

        $('.modal').modal({
            show: true,
            backdrop: 'static'
        });
    }

    $scope.salvar = function (usuario) {

        /*if(usuario.id) {
            $('#senha, #senha2').removeAttr('required');
        }*/
        
        if(required('#UsuarioForm', true)) {
            chamaMsg('11', true);
        } else {
            UsuarioNovo.save(usuario).$promise.then(function(data) {
                if(data.success) {
                    $('.modal').modal('hide');
                    chamaMsg('1', true);
                    $scope.start();
                }
            });
        }

    };

    $scope.start();
})