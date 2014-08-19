'use strict';

AppFinanci.controller('FormCorretorGridCtrl', function($scope, $http, getCorretores) {
    
    $scope.corretor = {};

    $scope.check_ctrl = [];
    $scope.checkall = false;

    //Paginação
    $scope.pagina = 1;
    $scope.paginas = 0;
    $scope.search = '';

    $scope.showForm = function() {
        window.location = '/corretor/novo';
    }

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

            var itens = $scope.check_ctrl.length > 0 ? $scope.check_ctrl : $scope.model.corretores;

            $http({
                'method': 'post',
                'url': '/corretor/acoes/' + acao_name,
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

        if($scope.search.length > 0)
        {
            var termos = { pagina: $scope.pagina, query: $scope.search };
        } else {
            var termos = { pagina: $scope.pagina };
        }

        getCorretores.get(termos).$promise.then(function(data){
            $scope.model = data;
            $scope.paginas = new Array(data.paginas);
        });

        console.log($scope.model);
    }

    $scope.start();
})