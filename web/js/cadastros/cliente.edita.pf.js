'use strict';

AppFinanci.controller('FormCtrl', function($scope, $http, Cidades, ClientesBusca, $window) {
    $scope.endereco = 1;
    $scope.cliente = {};

    $scope.selectedCbo = null;

    ClientesBusca.get({ id: $('#cliente-id').val() }).$promise.then(function(data) {
        $scope.cliente = data.cliente;
    });

    $scope.changeEndereco = function() {
        $scope.endereco = $scope.endereco ? 0 : 1;
    }

    $scope.cidades = [{"id":null,"nome":null}];
    $scope.cidades_endereco_principal = [{"id":null,"nome":null}];
    $scope.cidades_endereco_secundario = [{"id":null,"nome":null}];

    $scope.salvar = function(form, add) {
        console.log($scope.cliente);
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
        $('.loading').show();        
        
        var uf = $('#'+id).val();
        
        var destino = destino;

        Cidades.get({'uf': uf }).$promise.then(function(data) {
            $('.loading').hide();
            
            if(destino == 'cidades') {
                $scope.cidades = data.rows;
            } else if(destino == 'cidades_endereco_principal') {
                $scope.cidades_endereco_principal = data.rows;
            } else if(destino == 'cidades_endereco_secundario') {
                $scope.cidades_endereco_secundario = data.rows;
            }

        });
        
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
        $('#cbo_id').val(datum.cbo);
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
            
            if(!indice) {
                $('#uf_endereco_principal').val(data.uf);
                $scope.cidades_endereco_principal = [{'id':data.cidade_id, 'nome':data.cidade, 'selected':true}];
                //$scope.get_cidade('uf_endereco_principal', 'cidades_endereco_principal', data.cidade_id);
            } else {
                $('#uf_endereco_secundario').val(data.uf);
                $scope.cidades_endereco_secundario = [{'id':data.cidade_id, 'nome':data.cidade, 'selected':true}];
                //$scope.get_cidade('uf_endereco_secundario', 'cidades_endereco_secundario', data.cidade_id);
            }

        });
    }

});
