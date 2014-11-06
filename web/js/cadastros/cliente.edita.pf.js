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
        $scope.verificaCasado();
        if(data.cliente.telefones.length == 0) {
            $scope.cliente.telefones = [{}];
        }

        if(data.cliente.emails.length == 0) {
            $scope.cliente.emails = [{}];
        }

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
        }
    }

    $scope.validaCnpj = function() {
        if($scope.cliente.cnpj && !validaCnpj($scope.cliente.cnpj)) {
            chamaMsg('29', true);
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
            var uf = $scope.cliente.conjuge ? $scope.cliente.conjuge.naturalidade_uf : false;
        }

        console.log(destino)

        var destino = destino;
        console.log('('+uf, destino + ')');
        if(uf && uf.length > 0) {
            $('.loading').show();  
            Cidades.get({'uf': uf }).$promise.then(function(data) {
                $('.loading').hide();
                
                if(destino == 'cidades') {
                    $scope.cidades = data.cidades;
                    $scope.cliente.naturalidade = parseInt($scope.cliente.naturalidade);
                    $('select[name="cliente[naturalidade]"]').select2();
                } else if(destino == 'cidades_endereco_principal') {
                    $scope.cidades_endereco_principal = data.cidades;
                    $scope.cliente.endereco[0].cidade = parseInt($scope.cliente.endereco[0].cidade);
                    $('select[name="cliente[endereco][0][cidade]"]').select2();
                } else if(destino == 'cidades_endereco_secundario') {
                    $scope.cidades_endereco_secundario = data.cidades;
                    $scope.cliente.endereco[1].cidade = parseInt($scope.cliente.endereco[1].cidade);
                    $('select[name="cliente[endereco][1][cidade]"]').select2();
                } else if(destino == 'cidades_conjuge') {
                    $scope.cidades_conjuge = data.cidades;
                    $scope.cliente.conjuge.naturalidade = parseInt($scope.cliente.conjuge.naturalidade);
                    $('select[name="cliente[conjuge][naturalidade]"]').select2();
                }

                $('select[name="cliente[naturalidade]"], select[name="cliente[endereco][0][cidade]"], select[name="cliente[endereco][1][cidade]"], select[name="cliente[conjuge][naturalidade]"]').select2();
                
            });
        }
        
    }

    $scope.verificaCasado = function() {
        console.log('Estado civil: ' + $scope.cliente.estado_civil);

        if($scope.cliente.estado_civil == 2) {
            $('input[name="cliente[conjuge][cpf]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][nome]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][data_nascimento]"]').attr('required', true).attr('req', true);
            $('select[name="cliente[conjuge][naturalidade]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][nacionalidade]"]').attr('required', true).attr('req', true);
            $('select[name="cliente[conjuge][naturalidade_uf]"]').attr('required', true).attr('req', true);
        } else {
            $('input[name="cliente[conjuge][cpf]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
            $('input[name="cliente[conjuge][nome]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
            $('input[name="cliente[conjuge][data_nascimento]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
            $('select[name="cliente[conjuge][naturalidade]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
            $('input[name="cliente[conjuge][nacionalidade]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
            $('select[name="cliente[conjuge][naturalidade_uf]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
        };
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
        $('.loading').show();
        $http({
            'method': 'get',
            'url': 'http://fitcontas.com.br/fitservices/logradouro/' + cep.replace('-', ''),
        }).success(function(data) {
            $('.loading').hide();
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
