'use strict';

AppFinanci.controller('FormCtrl', function($scope, $http, Cidades, CorretoresBusca, $window) {
    $scope.endereco = 1;
    $scope.corretor = {
        'endereco': [{}, {}],
        'telefones': [
            {},
        ],
        'emails': [
            {},
        ]
    };

    $scope.selectedCbo = null;

    CorretoresBusca.get({ id: $('#corretor-id').val() }).$promise.then(function(data) {
        $scope.corretor = data.corretor;

        if(data.corretor.telefones.length == 0) {
            $scope.corretor.telefones = [{}];
        }

        if(data.corretor.emails.length == 0) {
            $scope.corretor.emails = [{}];
        }

        $scope.get_cidade('uf_endereco_principal', 'cidades_endereco_principal');
        $scope.get_cidade('uf_endereco_secundario', 'cidades_endereco_secundario');
        $scope.get_cidade('naturalidade_uf', 'cidades');

        $http({
            'method': 'get',
            'url': 'http://fitcontas.com.br/fitservices/cbo/' + data.corretor.cbo,
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
    $scope.cidades_endereco_principal = [];
    $scope.cidades_endereco_secundario = [];

    $scope.salvar = function(form, add) {
        console.log($scope.corretor);
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

    $scope.get_cidade = function(id, destino) {
        var uf = false;
        if(destino == 'cidades_endereco_principal') {
            var uf = $scope.corretor.endereco[0].uf;
        } else if(destino == 'cidades_endereco_secundario') {
            var uf = $scope.corretor.endereco[1] ? $scope.corretor.endereco[1].uf: false;
        } else if(destino == 'cidades') {
            var uf = $scope.corretor.naturalidade_uf;
        }

        var destino = destino;

        if(uf && uf.length > 0) {
            $('.loading').show();  
            Cidades.get({'uf': uf }).$promise.then(function(data) {
                $('.loading').hide();
                
                if(destino == 'cidades') {
                    $scope.cidades = data.cidades;
                    $scope.corretor.naturalidade = parseInt($scope.corretor.naturalidade);
                } else if(destino == 'cidades_endereco_principal') {
                    $scope.cidades_endereco_principal = data.cidades;
                    $scope.corretor.endereco[0].cidade = parseInt($scope.corretor.endereco[0].cidade);
                } else if(destino == 'cidades_endereco_secundario') {
                    $scope.cidades_endereco_secundario = data.cidades;
                    $scope.corretor.endereco[1].cidade = parseInt($scope.corretor.endereco[1].cidade);
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
        $scope.corretor.cbo = datum.cbo;
    });

    $scope.completaEndereco = function(endereco) {

        var cep = endereco ? $scope.corretor.endereco[0].cep : $scope.corretor.endereco[1].cep;
        var indice = endereco ? 0 : 1;
        if(cep != undefined && cep.length >= 8) {
            $('.loading').show();
            $http({
                'method': 'get',
                'url': 'http://fitcontas.com.br/fitservices/logradouro/' + cep.replace('-', ''),
            }).success(function(data) {
                $('.loading').hide();

                if(data.cidade) {
                    $scope.corretor.endereco[indice].logradouro = data.logradouro;
                    $scope.corretor.endereco[indice].bairro = data.bairro;
                    
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

                    $('select[name="corretor[endereco]['+indice+'][uf]"], select[name="corretor[endereco]['+indice+'][cidade]"]').prop('disabled', true);
                } else {
                    $scope.zeraEndereco(indice);
                }

            });
        } else {
            $scope.zeraEndereco(indice);
        }
    }

    $scope.zeraEndereco = function(indice) {
        $('select[name="corretor[endereco]['+indice+'][uf]"], select[name="corretor[endereco]['+indice+'][cidade]"]').prop('disabled', false);
        $scope.corretor.endereco[indice].cidade = '';
        $scope.cidades = [];
        $scope.corretor.endereco[indice].logradouro = '';
        $scope.corretor.endereco[indice].numero = '';
        $scope.corretor.endereco[indice].bairro = '';
        $scope.corretor.endereco[indice].uf = '';
        $scope.corretor.endereco[indice].complemento = '';
    }

    $scope.addTelefone = function() {
        $scope.corretor.telefones.push({});
        console.log($scope.corretor.telefones);
    }

    $scope.removeTelefone = function(index) {
        if($scope.corretor.telefones.length > 1) {
            $scope.corretor.telefones.splice(index, 1);
        }

        if($scope.corretor.telefones.length == 1) {
            $scope.corretor.telefones = [{}];
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

        if($scope.corretor.emails.length == 1) {
            $scope.corretor.emails = [{}];
        }
    }

});
