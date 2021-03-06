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
        
        $('input[name="cliente[cnae]"]').select2("data", data.cnae);

        if(data.cliente.telefones.length == 0) {
            $scope.cliente.telefones = [{}];
        }

        if(data.cliente.emails.length == 0) {
            $scope.cliente.emails = [{}];
        }

        $scope.get_cidade('uf_endereco_principal', 'cidades_endereco_principal');
        $scope.get_cidade('uf_endereco_secundario', 'cidades_endereco_secundario');
        //$scope.get_cidade('naturalidade_uf', 'cidades');
        
        $scope.cliente.naturalidade = parseInt($scope.cliente.naturalidade);
        $scope.cidades = data.cidade_naturalidade;
        
        $scope.get_cidade('conjuge_naturalidade_uf', 'cidades_conjuge');

        $http({
            'method': 'get',
            'url': 'http://fitcontas.com.br/fitservices/cbo/' + data.cliente.cbo,
        }).success(function(data) {
            if($('#tipo').val() == 'cpf') {
                $scope.verificaCasado();
            }
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

        if($(ClienteForm).hasClass('ng-invalid') || required('#ClienteForm', false) > 0) {
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
                if(data.success) {
                    if(data.id != $('#cliente-id').val()) {
                        window.location = '/cliente/edita/pf/'+data.id;
                        $('.loading').show();
                    }
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
                    if(data.id != $('#cliente-id').val()) {
                        window.location = '/cliente/edita/pj/'+data.id;
                        $('.loading').show();
                    }
                }
            })
        }
    }

    $scope.get_cidade = function(id, destino) {
        var cidade = 0;
        if(destino == 'cidades_endereco_principal') {
            var uf = $scope.cliente.endereco[0].uf;
            cidade = $scope.cliente.endereco[0].cidade;
        } else if(destino == 'cidades_endereco_secundario') {
            var uf = $scope.cliente.endereco[1].uf;
            cidade = $scope.cliente.endereco[1].cidade;
        } else if(destino == 'cidades') {
            var uf = $scope.cliente.naturalidade_uf;
            cidade = $scope.cliente.naturalidade;
        } else if(destino == 'cidades_conjuge') {
            var uf = $scope.cliente.conjuge ? $scope.cliente.conjuge.naturalidade_uf : false;
            cidade = uf ? $scope.cliente.conjuge.naturalidade : false;
        }

        console.log(destino)

        var destino = destino;
        console.log('('+uf, destino + ')');

        if(uf && uf.length > 0) {
            $('.loading').show();  
            Cidades.get({'uf': uf, 'cidade': cidade }).$promise.then(function(data) {
                $('.loading').hide();
                
                if(destino == 'cidades') {
                    $scope.cidades = data.cidades;
                    $scope.cliente.naturalidade = parseInt($scope.cliente.naturalidade);
                    //$('select[name="cliente[naturalidade]"]').select2();
                } else if(destino == 'cidades_endereco_principal') {
                    $scope.cidades_endereco_principal = data.cidades;
                    $scope.cliente.endereco[0].cidade = parseInt($scope.cliente.endereco[0].cidade);
                    //$('select[name="cliente[endereco][0][cidade]"]').select2();
                } else if(destino == 'cidades_endereco_secundario') {
                    $scope.cidades_endereco_secundario = data.cidades;
                    $scope.cliente.endereco[1].cidade = parseInt($scope.cliente.endereco[1].cidade);
                    //$('select[name="cliente[endereco][1][cidade]"]').select2();
                } else if(destino == 'cidades_conjuge') {
                    $scope.cidades_conjuge = data.cidades;
                    $scope.cliente.conjuge.naturalidade = parseInt($scope.cliente.conjuge.naturalidade);
                    //$('select[name="cliente[conjuge][naturalidade]"]').select2();
                }

                //$('select[name="cliente[naturalidade]"], select[name="cliente[endereco][0][cidade]"], select[name="cliente[endereco][1][cidade]"], select[name="cliente[conjuge][naturalidade]"]').select2();
                
            });
        }
        
    }

    $scope.verificaCasado = function() {
        if($scope.cliente.estado_civil == 2) {
            console.log('Estado civil: Casado');
            $('input[name="cliente[conjuge][cpf]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][nome]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][data_nascimento]"]').attr('required', true).attr('req', true);
            $('select[name="cliente[conjuge][naturalidade]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][nacionalidade]"]').attr('required', true).attr('req', true);
            $('select[name="cliente[conjuge][naturalidade_uf]"]').attr('required', true).attr('req', true);
        } else {
            delete $scope.cliente.conjuge;
            console.log('Estado civil: Solteiro');
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
        
        if(cep != undefined && cep.length >= 8) {
            $('.loading').show();
            $http({
                'method': 'get',
                'url': 'http://fitcontas.com.br/fitservices/logradouro/' + cep.replace('-', ''),
            }).success(function(data) {
                $('.loading').hide();

                if(data.cidade) {
                    $scope.cliente.endereco[indice].logradouro = data.logradouro;
                    $scope.cliente.endereco[indice].bairro = data.bairro;
                    $scope.cliente.endereco[indice].uf = data.uf;
                    $scope.cliente.endereco[indice].cidade = data.cidade_id;

                    var cidade_cep = [
                        { id: data.cidade_id, nome: data.cidade }
                    ];

                    var arr2 = [];
                    arr2['cidades'] = cidade_cep;
                    
                    if(!indice) {
                        $scope.cidades_endereco_principal = cidade_cep;                    
                    } else {
                        $scope.cidades_endereco_secundario = cidade_cep;                    
                    }

                    $('select[name="cliente[endereco]['+indice+'][uf]"], select[name="cliente[endereco]['+indice+'][cidade]"]').prop('disabled', true);
                } else {
                    $scope.zeraEndereco(indice);
                }

            });
        } else {
            $scope.zeraEndereco(indice);
        }
    }

    $scope.zeraEndereco = function(indice) {
        $('select[name="cliente[endereco]['+indice+'][uf]"], select[name="cliente[endereco]['+indice+'][cidade]"]').prop('disabled', false);
        $scope.cliente.endereco[indice].cidade = '';
        $scope.cidades = [];
        $scope.cliente.endereco[indice].logradouro = '';
        $scope.cliente.endereco[indice].numero = '';
        $scope.cliente.endereco[indice].bairro = '';
        $scope.cliente.endereco[indice].uf = '';
        $scope.cliente.endereco[indice].complemento = '';
    }

    $scope.addTelefone = function() {
        $scope.cliente.telefones.push({});
        console.log($scope.cliente.telefones);
    }

    $scope.removeTelefone = function(index) {
        if($scope.cliente.telefones.length > 1) {
            $scope.cliente.telefones.splice(index, 1);
        }

        if($scope.cliente.telefones.length == 1) {
            $scope.cliente.telefones = [{}];
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

        if($scope.cliente.emails.length == 1) {
            $scope.cliente.emails = [{}];
        }
    }

});
