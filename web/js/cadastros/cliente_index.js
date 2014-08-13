'use strict';

AppFinanci.controller('FormClinteGridCtrl', function($scope, $http, Clientes) {
    
    $scope.cliente = {};
    $scope.clientes = [];

    $scope.check_ctrl = [];
    $scope.checkall = false;

    //Paginação
    $scope.pagina = 1;
    $scope.paginas = 0;

    $scope.checkAll = function(item) {

        var existe = _.remove($scope.check_ctrl, function(obj) {
            return obj.id == item.id;
        });

        if(!existe.length) {
            $scope.check_ctrl.push(item);
        }
        
        console.log($scope.check_ctrl);

    }

    $scope.acao = function(acao_name) {
        if(!$scope.check_ctrl.length && !$scope.checkall) {
            chamaMsg('10', false);
        } else {

            var itens = $scope.check_ctrl.length > 0 ? $scope.check_ctrl : $scope.usuarios;

            $http({
                'method': 'post',
                'url': '/usuario/acoes/' + acao_name,
                'data': itens,
            }).success(function(data) {
                console.log(data);
                if(data.success) {
                    chamaMsg(data.msg, true);
                    $scope.start();
                    $scope.check_ctrl = [];
                }
            })
        }
    }

    $scope.start = function(pagina) {

        if(pagina) {
            $scope.pagina = pagina;
        }

        Clientes.get({ pagina: $scope.pagina }).$promise.then(function(data){
            $scope.clientes = data.clientes;
            $scope.paginas = new Array(data.paginas);
        });
    }

    $scope.start();
})