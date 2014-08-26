'use strict';

AppFinanci.controller('FormUsuarioCtrl', function($scope, $http, Usuarios, UsuarioNovo, Grupos) {

    $scope.usuario = {};
    $scope.grupos = [{1: 'Administrador'}];
    $scope.check_ctrl = [];
    $scope.checkall = false;

    //Paginação
    $scope.pagina = 1;
    $scope.paginas = 0;
    $scope.search = '';
    $scope.grupos = Grupos.get();

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

            var itens = $scope.check_ctrl.length > 0 ? $scope.check_ctrl : $scope.model.usuarios;

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

        if($scope.search.length > 0)
        {
            var termos = { pagina: $scope.pagina, query: $scope.search };
        } else {
            var termos = { pagina: $scope.pagina };
        }

        Usuarios.get(termos).$promise.then(function(data){
            $scope.model = data;
            $scope.paginas = new Array(data.pagination.paginas);
            $scope.pagination = data.pagination;
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