'use strict';

AppFinanci.controller('FormCtrl', function($scope, $http, Cidades, $window) {
    $scope.endereco = 1;
    $scope.corretor = {
        'telefones': [
            {},
        ],
        'emails': [
            {},
        ]
    };

    $scope.selectedCbo = null;

    $scope.changeEndereco = function() {
        $scope.endereco = $scope.endereco ? 0 : 1;
    }

    $scope.cidades = [];
    $scope.cidades_endereco_principal = [];
    $scope.cidades_endereco_secundario = [];

    $scope.salvar = function(form, add) {
        
        if($scope.corretor.cpf && !validaCpf($scope.corretor.cpf)) {
            chamaMsg('27', true);
            return false;
        }

        if($scope.corretor.cnpj && !validaCnpj($scope.corretor.cnpj)) {
            chamaMsg('29', true);
            return false;
        }

        if($(CorretorForm).hasClass('ng-invalid')) {
            required('#CorretorForm', false);
            chamaMsg('11', true);
        } else {
            $http({
                'method': 'post',
                'url': '/corretor/salvar',
                'data': $scope.corretor,
            }).success(function(data) {
                console.log(data);
                if(data.success) {
                    chamaMsg('1', true);
                    $window.location = !add ? '/corretor' : '/corretor/novo';
                }
            })
        }

    }

    $scope.validaCpf = function() {
        if($scope.corretor.cpf && !validaCpf($scope.corretor.cpf)) {
            chamaMsg('27', true);
        }
    }

    $scope.validaCnpj = function() {
        if($scope.corretor.cnpj && !validaCnpj($scope.corretor.cnpj)) {
            chamaMsg('29', true);
        }
    }

    $scope.get_cidade = function(id, destino) {
        $('.loading').show();        
        
        var uf = $('#'+id).val();
        
        var destino = destino;

        Cidades.get({'uf': uf }).$promise.then(function(data) {
            $('.loading').hide();
            
            if(destino == 'cidades') {
                $scope.cidades = data.cidades;
            } else if(destino == 'cidades_endereco_principal') {
                $scope.cidades_endereco_principal = data.cidades;
            } else if(destino == 'cidades_endereco_secundario') {
                $scope.cidades_endereco_secundario = data.cidades;
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
        $scope.corretor.cbo = datum.cbo;
    });

    $scope.completaEndereco = function(endereco) {

        var cep = endereco ? $scope.corretor.endereco[0].cep : $scope.corretor.endereco[1].cep;
        var indice = endereco ? 0 : 1;
        $('.loading').show();
        $http({
            'method': 'get',
            'url': 'http://fitcontas.com.br/fitservices/logradouro/' + cep.replace('-', ''),
        }).success(function(data) {
            $('.loading').hide();
            $scope.corretor.endereco[indice].logradouro = data.logradouro;
            $scope.corretor.endereco[indice].bairro = data.bairro;
            
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

    $scope.addTelefone = function() {
        $scope.corretor.telefones.push({});
        console.log($scope.corretor.telefones);
    }

    $scope.removeTelefone = function(index) {
        if($scope.corretor.telefones.length > 1) {
            $scope.corretor.telefones.splice(index, 1);
        }
    }

    $scope.addEmail = function() {
        $scope.corretor.emails.push({});
        console.log($scope.corretor.emails);
    }

    $scope.removeEmail = function(index) {
        if($scope.corretor.emails.length > 1) {
            $scope.corretor.emails.splice(index, 1);
        }
    }

});
