'use strict';

AppFinanci.controller('FormClinteGridCtrl', function($scope, $http, Clientes) {
    
    $scope.cliente = {};

    $scope.check_ctrl = [];
    $scope.checkall = false;

    //Paginação
    $scope.pagina = 1;
    $scope.paginas = 0;
    $scope.search = '';

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
            
            var itens = $scope.check_ctrl.length > 0 ? $scope.check_ctrl : $scope.model.clientes;

            if(acao_name == 'excluir') {
                chamaMsg('20', true, false, {'id':'excluir-registro'});
                
                $('button[data-id="excluir-registro"]').click(function() {
                    $http({
                        'method': 'post',
                        'url': '/cliente/acoes/' + acao_name,
                        'data': itens,
                    }).success(function(data) {
                        console.log(data);
                        if(data.success) {
                            chamaMsg(data.msg, true);
                            $scope.start();
                            $scope.check_ctrl = [];
                        } else {
                            chamaMsg(data.msg, true);
                        }
                    })
                });
            } else {
                var itens = $scope.check_ctrl.length > 0 ? $scope.check_ctrl : $scope.model.clientes;

                $http({
                    'method': 'post',
                    'url': '/cliente/acoes/' + acao_name,
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
    }

    $scope.start = function(pagina, column_sort, sort) {

        if(pagina) {
            $scope.pagina = pagina;
        }

        if($scope.search.length > 0)
        {
            var termos = { pagina: $scope.pagina, query: $scope.search };
        } else {
            var termos = { pagina: $scope.pagina };
        }

        if(column_sort && sort) {
            termos.column = column_sort;
            termos.sort = sort;
        }

        Clientes.get(termos).$promise.then(function(data){
            $scope.model = data;
            $scope.paginas = new Array(data.paginas);
        });
    }

    $scope.start();
})