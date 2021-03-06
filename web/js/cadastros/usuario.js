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

            if(acao_name == 'excluir') {
                chamaMsg('20', true, false, {'id':'excluir-registro'});
                
                $('button[data-id="excluir-registro"]').click(function() {
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
                    });
                });
            } else {

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
                });
            }
        }
    };

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

        $('.has-error').removeClass('has-error');

        $('#usuario_modal').modal({
            show: true,
            backdrop: 'static'
        });
    }

    $scope.salvar = function (usuario, add) {

        /*if(usuario.id) {
            $('#senha, #senha2').removeAttr('required');
        }*/

        
        
        if(required('#UsuarioForm', true)) {

            chamaMsg('11', true);
            
        } else {

            if($('#email').val().length > 0 && $('#email2').val().length > 0) {
                if($('#email').val() != $('#email2').val()) {
                    chamaMsg('165', true);
                    $('#email2').closest('div').addClass('has-error');
                    return false;
                }
            }

            if($('#senha').val().length > 0 || $('#senha2').val().length > 0) {

                if( $('#senha').val().length < 6 || $('#senha2').val().length < 6) {
                    chamaMsg('24', true);
                    $('#senha, #senha2').val('');
                    return false;
                } else if($('#senha').val() != $('#senha2').val()) {
                    chamaMsg('26', true);
                    $('#senha, #senha2').val('');
                    return false;
                }
            }

            UsuarioNovo.save(usuario).$promise.then(function(data) {
                if(data.success) {
                    $('#usuario_modal').modal('hide');
                    //chamaMsg('1', true);
                    $scope.start();

                    if(add) {
                        $scope.showForm();
                    } else {
                        chamaMsg('1', true);
                    }
                } else {
                    chamaMsg(data.msg, false);
                }
            });
        }

    };

    $scope.start();
})