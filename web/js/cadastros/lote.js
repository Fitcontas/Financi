'use strict';

AppFinanci.controller('FormLoteCtrl', function($scope, $http, Lotes, LoteNovo, Estados, Cidades, Corretores) {
    
    $scope.lote = {};
    $scope.grupos = [{1: 'Administrador'}];
    $scope.check_ctrl = [];
    $scope.checkall = false;
    $scope.status = {
        'R': 'Reservado',
        'V': 'Vendido'
    };

    //Paginação
    $scope.pagina = 1;
    $scope.paginas = 0;
    $scope.search = '';

    //Uf
    $scope.ufs = Estados.get();
    //$scope.cidades = Cidades.get();

    $scope.corretores = Corretores.get();

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

            var itens = $scope.check_ctrl.length > 0 ? $scope.check_ctrl : $scope.model.lotes;

            if(acao_name == 'excluir') {
                chamaMsg('20', true, false, {'id':'excluir-registro'});
                
                $('button[data-id="excluir-registro"]').click(function() {
                    $http({
                        'method': 'post',
                        'url': '/lote/acoes/' + acao_name,
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
                    });
                });
                
            } else {
                $http({
                    'method': 'post',
                    'url': '/lote/acoes/' + acao_name,
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

        Lotes.get(termos).$promise.then(function(data){
            $scope.model = data;
            $scope.paginas = new Array(data.paginas);
        });
    }

    $scope.getGrupo = function(grupo) {
        return $scope.grupos[grupo];
    }

    $scope.showForm = function(item) {
        console.log(item);
        if(item.uf) {
            $('select[name="lote[cidade]"]').select2('destroy');
            $scope.cidades = Cidades.get({ uf: item.uf }).$promise.then(function(data) {
                $scope.cidades = data;
                setTimeout('teste', 1000);
            });
        }
        
        $scope.lote = item ? item : {};
        
        $('.has-error').removeClass('has-error');
        
        $('#lote_modal').modal({
            show: true,
            backdrop: 'static'
        });

        $('.nav-tabs a:first').tab('show');
    }

    $scope.salvar = function (lote, add) {

        if(required('#LoteForm', true)) {
            chamaMsg('11', true);
        } else {
            $('.loading').show();
            LoteNovo.save(lote).$promise.then(function(data) {
                if(data.success) {
                    $('.loading').hide();
                    //$('#lote_modal').modal('hide');
                    
                    $scope.start();

                    if(add) {
                        $scope.showForm(false);
                        chamaMsg('1', true);
                    } else {
                        $('#lote_modal').modal('hide');
                        chamaMsg('1', true);
                    }

                    
                }
            });
        }

    };

    $scope.completaEndereco = function(endereco) {

        var cep = $scope.lote.cep;

        if(cep != undefined) {
            $('.loading').show();
            $http({
                'method': 'get',
                'url': 'http://fitcontas.com.br/fitservices/logradouro/' + cep.replace('-', ''),
            }).success(function(data) {

                if(data.cidade) {
                    $('.loading').hide();
                    $scope.lote.logradouro = data.logradouro;
                    $scope.lote.bairro = data.bairro;
                    $scope.lote.uf = data.uf;
                    $scope.lote.cidade = data.cidade;

                    var cidade_cep = [
                        { id: data.cidade_id, nome: data.cidade }
                    ];

                    var arr2 = [];
                    arr2['cidades'] = cidade_cep;
                    console.log(arr2);
                    $scope.cidades = arr2;

                    $('select[name="lote[uf]"], select[name="lote[cidade]"]').prop('disabled', true);
                } else {
                    $scope.zeraEndereco();
                }
            });
        } else {
            $scope.zeraEndereco();
        }
    };

    $scope.zeraEndereco = function() {
        $('select[name="lote[uf]"], select[name="lote[cidade]"]').prop('disabled', false);
        $scope.lote.cidade = '';
        $scope.cidades = [];
        $scope.lote.logradouro = '';
        $scope.lote.numero = '';
        $scope.lote.bairro = '';
        $scope.lote.uf = '';
        $scope.lote.complemento = '';
    }

    $scope.getCidades = function(uf) {
        if(uf) {
            $('.loading').show();
            $scope.cidades = Cidades.get({uf: uf}).$promise.then(function(data) {
                $scope.cidades = data;
                //$('select[name="lote[cidade]"]').select2('destroy').select2();
                $('.loading').hide();
            });
        }
    }

    $scope.adicionarCorretor = function() {

        var test = _.find($scope.lote.corretores, { 'id': $scope.corretor });

        if(!test) {

            var item = _.find($scope.corretores.corretores, { 'id': $scope.corretor });
            
            if(!$scope.lote.corretores) {
                $scope.lote.corretores = Array();
            }

            $scope.lote.corretores.push(item);
        }
    }

    $scope.removerCorretor = function(id) {
        _.remove($scope.lote.corretores, function(obj) {
            return obj.id == id;
        });
    }

    $scope.start();
})

$(function() {
    $('.mask-money').maskMoney({prefix:'', allowNegative: true, thousands:'.', decimal:',', affixesStay: false, allowZero:true});
})

function teste() {
    $('select[name="empreendimento[cidade]"]').select2();
}