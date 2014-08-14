'use strict';

AppFinanci.controller('FormEmpreendimentoCtrl', function($scope, $http, Empreendimentos, EmpreendimentoNovo) {
    
    $scope.empreendimento = {};
    $scope.empreendimentos = [];
    $scope.grupos = [{1: 'Administrador'}];
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

            var itens = $scope.check_ctrl.length > 0 ? $scope.check_ctrl : $scope.empreendimentos;

            $http({
                'method': 'post',
                'url': '/empreendimento/acoes/' + acao_name,
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

        Empreendimentos.get({ pagina: $scope.pagina }).$promise.then(function(data){
            $scope.empreendimentos = data.empreendimentos;
            $scope.paginas = new Array(data.paginas);
        });
    }

    $scope.getGrupo = function(grupo) {
        return $scope.grupos[grupo];
    }

    $scope.showForm = function(item) {
        $scope.empreendimento = item ? item : {};


        $('.modal').modal({
            show: true,
            backdrop: 'static'
        });
    }

    $scope.salvar = function (empreendimento) {

        /*if(empreendimento.id) {
            $('#senha, #senha2').removeAttr('required');
        }*/
        
        if(required('#EmpreendimentoForm', true)) {
            chamaMsg('11', true);
        } else {
            EmpreendimentoNovo.save(empreendimento).$promise.then(function(data) {
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