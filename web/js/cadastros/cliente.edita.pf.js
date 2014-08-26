'use strict';

AppFinanci.controller('FormCtrl', function($scope, $http, Cidades, ClientesBusca, $window) {
    $scope.endereco = 1;
    $scope.cliente = {
        'telefones': [
            {},
        ],
        'emails': [
            {},
        ]
    };

    $scope.selectedCbo = null;

    ClientesBusca.get({ id: $('#cliente-id').val() }).$promise.then(function(data) {
        $scope.cliente = data.cliente;

        $scope.get_cidade('uf_endereco_principal', 'cidades_endereco_principal');
        $scope.get_cidade('uf_endereco_secundario', 'cidades_endereco_secundario');
        $scope.get_cidade('naturalidade_uf', 'cidades');
        $scope.get_cidade('conjuge_naturalidade_uf', 'cidades_conjuge');

        $http({
            'method': 'get',
            'url': 'http://fitcontas.com.br/fitservices/cbo/' + data.cliente.cbo,
        }).success(function(data) {
            if(data.result) {
                $('#cbo_descricao').val(data.rows.profissao);
            }
        });

    });

    $scope.changeEndereco = function() {
        $scope.endereco = $scope.endereco ? 0 : 1;
    }

    $scope.cidades = [];
    $scope.cidades_conjuge = [];
    $scope.cidades_endereco_principal = [];
    $scope.cidades_endereco_secundario = [];

    $scope.salvar = function(form, add) {
        if($(ClienteForm).hasClass('ng-invalid')) {
            required('#ClienteForm', false);
            chamaMsg('11', true);
        } else {
            $http({
                'method': 'post',
                'url': '/cliente/pf/salvar',
                'data': $scope.cliente,
            }).success(function(data) {
                console.log(data);
                if(data.success) {
                    chamaMsg('1', true);
                    $window.location = !add ? '/cliente' : '/cliente/cadastro/pf';
                }
            })
        }

    }

    $scope.get_cidade = function(id, destino, cidade = false) {
             
        
        if(destino == 'cidades_endereco_principal') {
            var uf = $scope.cliente.endereco[0].uf;
        } else if(destino == 'cidades_endereco_secundario') {
            var uf = $scope.cliente.endereco[1].uf;
        } else if(destino == 'cidades') {
            var uf = $scope.cliente.naturalidade_uf;
        } else if(destino == 'cidades_conjuge') {
            var uf = $scope.cliente.conjuge.naturalidade_uf;
        }

        console.log(destino)

        var destino = destino;
        if(uf.length > 0) {
            $('.loading').show();  
            Cidades.get({'uf': uf }).$promise.then(function(data) {
                $('.loading').hide();
                
                if(destino == 'cidades') {
                    $scope.cidades = data.cidades;
                    $scope.cliente.naturalidade = parseInt($scope.cliente.naturalidade);
                } else if(destino == 'cidades_endereco_principal') {
                    $scope.cidades_endereco_principal = data.cidades;
                    $scope.cliente.endereco[0].cidade = parseInt(cidade = $scope.cliente.endereco[0].cidade);
                } else if(destino == 'cidades_endereco_secundario') {
                    $scope.cidades_endereco_secundario = data.cidades;
                    $scope.cliente.endereco[1].cidade = parseInt(cidade = $scope.cliente.endereco[1].cidade);
                } else if(destino == 'cidades_conjuge') {
                    $scope.cidades_conjuge = data.cidades;
                    $scope.cliente.conjuge.naturalidade = parseInt($scope.cliente.conjuge.naturalidade);
                }
                
            });
        }
        
    }

    var cbo = new Bloodhound({
        datumTokenizer: function(d) {
            return Bloodhound.tokenizers.whitespace(d.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        limit: 10,
        remote: 'http://fitcontas.com.br/fitservices/cbo/search/%QUERY',
    });

    cbo.initialize();

    // Typeahead options object
    $scope.cboOptions = {
        highlight: true
    };

    $scope.cboDataset = {
        displayKey: 'profissao',
        minLength: 3,
        source: cbo.ttAdapter(),
        templates: {
            suggestion: Handlebars.compile(
                '<p><strong>{{cbo}}</strong> – {{profissao}}</p>'
            )
        }
    };

    $('.typeahead').on('typeahead:selected', function($e, datum) {
        $scope.cliente.cbo = datum.cbo;
    });

    $scope.completaEndereco = function(endereco) {

        var cep = endereco ? $scope.cliente.endereco[0].cep : $scope.cliente.endereco[1].cep;
        var indice = endereco ? 0 : 1;
        $http({
            'method': 'get',
            'url': 'http://fitcontas.com.br/fitservices/logradouro/' + cep.replace('-', ''),
        }).success(function(data) {
            $scope.cliente.endereco[indice].logradouro = data.logradouro;
            $scope.cliente.endereco[indice].bairro = data.bairro;
            $scope.cliente.endereco[indice].uf = data.uf;
            $scope.cliente.endereco[indice].cidade = data.cidades_endereco_principal;
            
            if(!indice) {
                $scope.get_cidade('uf_endereco_principal', 'cidades_endereco_principal', data.uf);
            } else {
                $scope.get_cidade('uf_endereco_secundario', 'cidades_endereco_secundario', data.uf);
            }

        });
    }

    $scope.addTelefone = function() {
        $scope.cliente.telefones.push({});
        console.log($scope.cliente.telefones);
    }

    $scope.removeTelefone = function(index) {
        if($scope.cliente.telefones.length > 1) {
            $scope.cliente.telefones.splice(index, 1);
        }
    }

    $scope.addEmail = function() {
        $scope.cliente.emails.push({});
        console.log($scope.cliente.emails);
    }

    $scope.removeEmail = function(index) {
        if($scope.cliente.emails.length > 1) {
            $scope.cliente.emails.splice(index, 1);
        }
    }

});
