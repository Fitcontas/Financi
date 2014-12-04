'use strict';

AppFinanci.controller('FormEmpreendimentoCtrl', function($scope, $http, Empreendimentos, EmpreendimentoNovo, EmpreendimentosOne, Estados, Cidades, Corretores) {
    
    $scope.empreendimento = {};
    $scope.grupos = [{1: 'Administrador'}];
    $scope.check_ctrl = [];
    $scope.checkall = false;

    //Paginação
    $scope.pagina = 1;
    $scope.paginas = 0;
    $scope.search = '';

    //Uf
    $scope.ufs = Estados.get();
    //$scope.cidades = Cidades.get();

    $scope.onlyNumbers = /^\d+$/;

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

            var itens = $scope.check_ctrl.length > 0 ? $scope.check_ctrl : $scope.model.empreendimentos;

            if(acao_name == 'excluir') {
                chamaMsg('20', true, false, {'id':'excluir-registro'});
                
                $('button[data-id="excluir-registro"]').click(function() {
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
                        } else {
                            chamaMsg(data.msg, true);
                        }
                    });
                });
                
            } else {

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
                    } else {
                        chamaMsg(data.msg, true);
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

        Empreendimentos.get(termos).$promise.then(function(data){
            $scope.model = data;
            $scope.paginas = new Array(data.paginas);
        });
    }

    $scope.getGrupo = function(grupo) {
        return $scope.grupos[grupo];
    }

    $scope.showForm = function(item) {

        $('#scrolling').slimScroll({
            height: '200px',
            wheelStep: 10
        });
        
        $scope.empreendimento = item ? item : {};

        if(item && item.uf) {

            //$('select[name="empreendimento[cidade]"]').select2('destroy');
            $scope.cidades = Cidades.get({ uf: item.uf }).$promise.then(function(data) {
                $scope.cidades = data;
                //$('select[name="empreendimento[cidade]"]').select2();
                //setTimeout('teste', 1000);
            });
        }

        //$scope.$apply();

        $('.has-error').removeClass('has-error');

        $('#empreendimento_modal').modal({
            show: true,
            backdrop: 'static'
        });
        $('select[name="empreendimento[corretores]"]').val('').select2('destroy').select2();
        $('.nav-tabs a:first').tab('show');
    }

    $scope.salvar = function (empreendimento, add) {
        /*if(empreendimento.id) {
            $('#senha, #senha2').removeAttr('required');
        }*/
        
        if(required('#EmpreendimentoForm', true)) {
            chamaMsg('11', true);
        } else {
            $('.loading').show();
            EmpreendimentoNovo.save(empreendimento).$promise.then(function(data) {
                if(data.success) {
                    $('.loading').hide();
                    //$('#empreendimento_modal').modal('hide');
                    
                    $scope.start();
                    if(add) {
                        $scope.showForm();
                        $('select[name="empreendimento[uf]"], select[name="empreendimento[cidade]"]').prop('disabled', false);
                        chamaMsg('1', true);
                    } else {
                        $('#empreendimento_modal').modal('hide');
                        chamaMsg('1', true);
                    }
                }
            });
        }

    };

    $scope.completaEndereco = function(endereco) {

        var cep = $scope.empreendimento.cep;
        if(cep != undefined) {
            $('.loading').show();
            $http({
                'method': 'get',
                'url': 'http://fitcontas.com.br/fitservices/logradouro/' + cep.replace('-', ''),
            }).success(function(data) {
                
                if(data.cidade) {
                    console.log(data);
                    $scope.empreendimento.logradouro = data.logradouro;
                    $scope.empreendimento.bairro = data.bairro;

                    $scope.empreendimento.uf = data.uf;
                    $scope.empreendimento.cidade = data.cidade;
                    
                    var cidade_cep = [
                        { id: data.cidade_id, nome: data.cidade }
                    ];

                    var arr2 = [];
                    arr2['cidades'] = cidade_cep;
                    $scope.cidades = arr2;

                    $('select[name="empreendimento[uf]"], select[name="empreendimento[cidade]"]').prop('disabled', true);
                } else {
                    $scope.zeraEndereco();
                }
            });
        } else {
            $scope.zeraEndereco();
        }
    };

    $scope.zeraEndereco = function() {
        $('select[name="empreendimento[uf]"], select[name="empreendimento[cidade]"]').prop('disabled', false);
        $scope.empreendimento.cidade = '';
        $scope.cidades = [];
        $scope.empreendimento.logradouro = '';
        $scope.empreendimento.numero = '';
        $scope.empreendimento.bairro = '';
        $scope.empreendimento.uf = '';
        $scope.empreendimento.complemento = '';
    }

    $scope.getCidades = function(uf) {
        $('.loading').show();
        $scope.cidades = Cidades.get({uf: uf}).$promise.then(function(data) {
            $scope.cidades = data;
            //$('select[name="empreendimento[cidade]"]').select2('destroy').select2();
            $('.loading').hide();
        });
    }

    $scope.adicionarCorretor = function() {

        var test = _.find($scope.empreendimento.corretores, { 'id': $scope.corretor });

        if(!test) {

            var item = _.find($scope.corretores.corretores, { 'id': $scope.corretor });
            
            if(!$scope.empreendimento.corretores) {
                $scope.empreendimento.corretores = Array();
            }
            
            if(item != undefined) {
                $scope.empreendimento.corretores.push(item);
                $('select[name="empreendimento[corretores]"]').val('').select2('destroy').select2();
            }
        } else {
            chamaMsg('164', true);
            $('select[name="empreendimento[corretores]"]').val('').select2('destroy').select2();
        }
    }

    $scope.verificaIntermediaria = function() {
        if($('input[name="empreendimento[intermediarias]"]').val() == '0,00') {
            $('select[name="empreendimento[periodo]"]').removeAttr('req').removeAttr('required').val('');
        } else {
            $('select[name="empreendimento[periodo]"]').attr('req', true).attr('required', true);
        }
    }

    $scope.removerCorretor = function(id) {
        _.remove($scope.empreendimento.corretores, function(obj) {
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