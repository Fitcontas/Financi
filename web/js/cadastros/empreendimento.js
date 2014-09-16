'use strict';

AppFinanci.controller('FormEmpreendimentoCtrl', function($scope, $http, Empreendimentos, EmpreendimentoNovo, Estados, Cidades, Corretores) {
    
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
                    }
                });
            }
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
        
        if(item.uf) {
            $scope.cidades = Cidades.get({ uf: item.uf });
        }

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

    $scope.completaEndereco = function(endereco) {

        var cep = $scope.empreendimento.cep;
        if(cep != undefined) {
            $http({
                'method': 'get',
                'url': 'http://fitcontas.com.br/fitservices/logradouro/' + cep.replace('-', ''),
            }).success(function(data) {
                $scope.empreendimento.logradouro = data.logradouro;
                $scope.empreendimento.bairro = data.bairro;

                $scope.empreendimento.uf = data.uf;
                $scope.empreendimento.cidade = data.cidade;
                $scope.cidades = Cidades.get({ uf: data.uf });
            });
        }
    };

    $scope.getCidades = function(uf) {
        $scope.cidades = Cidades.get({uf: uf});
    }

    $scope.adicionarCorretor = function() {

        var test = _.find($scope.empreendimento.corretores, { 'id': $scope.corretor });

        if(!test) {

            var item = _.find($scope.corretores.corretores, { 'id': $scope.corretor });
            
            if(!$scope.empreendimento.corretores) {
                $scope.empreendimento.corretores = Array();
            }

            $scope.empreendimento.corretores.push(item);
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