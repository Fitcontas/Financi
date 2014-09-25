'use strict';

AppFinanci.controller('FormCtrl', function($scope, $http, Cidades, $window) {
    $scope.endereco = 1;
    $scope.cliente = {
        'endereco': [{}, {}],
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
    $scope.cidades_conjuge = [];

    $scope.salvar = function(form, add) {
        if($scope.cliente.cpf && !validaCpf($scope.cliente.cpf)) {
            chamaMsg('27', true);
            return false;
        }

        if($scope.cliente.cnpj && !validaCnpj($scope.cliente.cnpj)) {
            chamaMsg('29', true);
            return false;
        }

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

    $scope.validaCpf = function() {
        if($scope.cliente.cpf && !validaCpf($scope.cliente.cpf)) {
            chamaMsg('27', true);
        } else {
            $('.loading').show();
            $http({
                'method': 'get',
                'url': '/cliente/cpf_cnpj/' + $scope.cliente.cpf,
                'data': $scope.cliente,
            }).success(function(data) {
                $('.loading').hide();
                if(data.success) {
                    window.location = '/cliente/edita/pf/'+data.id;
                }
            })
        }
    }

    $scope.validaCnpj = function() {
        if($scope.cliente.cnpj && !validaCnpj($scope.cliente.cnpj)) {
            chamaMsg('29', true);
        } else {
            $('.loading').show();
            $http({
                'method': 'get',
                'url': '/cliente/cpf_cnpj/' + $scope.cliente.cnpj,
                'data': $scope.cliente,
            }).success(function(data) {
                $('.loading').hide();
                if(data.success) {
                    window.location = '/cliente/edita/pj/'+data.id;
                }
            })
        }
    }

    $scope.get_cidade = function(id, destino) {
             
        
        if(destino == 'cidades_endereco_principal') {
            var uf = $scope.cliente.endereco[0].uf;
        } else if(destino == 'cidades_endereco_secundario') {
            var uf = $scope.cliente.endereco[1].uf;
        } else if(destino == 'cidades') {
            var uf = $scope.cliente.naturalidade_uf;
        } else if(destino == 'cidades_conjuge') {
            var uf = $scope.cliente.conjuge.naturalidade_uf;
        }
        
        var destino = destino;
        if(uf != undefined && uf.length > 0) {
            $('.loading').show();  
            Cidades.get({'uf': uf }).$promise.then(function(data) {
                $('.loading').hide();
                console.log($scope.cliente.endereco[0].cidade);
                if(destino == 'cidades') {
                    $scope.cidades = data.cidades;
                } else if(destino == 'cidades_endereco_principal') {
                    $scope.cidades_endereco_principal = data.cidades;
                    console.log(data.cidades);
                } else if(destino == 'cidades_endereco_secundario') {
                    $scope.cidades_endereco_secundario = data.cidades;
                } else if(destino == 'cidades_conjuge') {
                    $scope.cidades_conjuge = data.cidades;
                    $scope.cliente.conjuge.naturalidade = parseInt($scope.cliente.conjuge.naturalidade);
                }

            });
        }
        
    }

    $scope.verificaCasado = function() {
        console.log($scope.cliente.estado_civil);
        if($scope.cliente.estado_civil == 2) {
            $('input[name="cliente[conjuge][cpf]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][nome]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][data_nascimento]"]').attr('required', true).attr('req', true);
            $('select[name="cliente[conjuge][naturalidade]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][nacionalidade]"]').attr('required', true).attr('req', true);
            $('select[name="cliente[conjuge][naturalidade_uf]"]').attr('required', true).attr('req', true);
        } else {
            $('input[name="cliente[conjuge][cpf]"]').removeAttr('required').removeAttr('req');
            $('input[name="cliente[conjuge][nome]"]').removeAttr('required').removeAttr('req');
            $('input[name="cliente[conjuge][data_nascimento]"]').removeAttr('required').removeAttr('req');
            $('select[name="cliente[conjuge][naturalidade]"]').removeAttr('required').removeAttr('req');
            $('input[name="cliente[conjuge][nacionalidade]"]').removeAttr('required').removeAttr('req');
            $('select[name="cliente[conjuge][naturalidade_uf]"]').removeAttr('required').removeAttr('req');
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
        if(cep != undefined && cep.length >= 8) {
            $('.loading').show();  
            $http({
                'method': 'get',
                'url': 'http://fitcontas.com.br/fitservices/logradouro/' + cep.replace('-', ''),
            }).success(function(data) {
                $('.loading').hide();  
                $scope.cliente.endereco[indice].logradouro = data.logradouro;
                $scope.cliente.endereco[indice].bairro = data.bairro;
                $scope.cliente.endereco[indice].uf = data.uf;
                $scope.cliente.endereco[indice].cidade = data.cidade_id;
                if(!indice) {
                    $scope.get_cidade('uf_endereco_principal', 'cidades_endereco_principal', data.uf);
                } else {
                    $scope.get_cidade('uf_endereco_secundario', 'cidades_endereco_secundario', data.uf);
                }

            });
        }
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
