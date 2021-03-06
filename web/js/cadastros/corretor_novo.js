'use strict';

AppFinanci.controller('FormCtrl', function($scope, $http, Cidades, $window) {
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
        } else {
            $('.loading').show();
            $http({
                'method': 'get',
                'url': '/corretor/cpf_cnpj/' + $scope.corretor.cpf,
                'data': $scope.corretor,
            }).success(function(data) {
                if(data.success) {

                    window.location = '/corretor/edita/'+data.id;
                    $('.loading').show();
                }
            })
        }
    }

    $scope.validaCnpj = function() {
        if($scope.corretor.cnpj && !validaCnpj($scope.corretor.cnpj)) {
            chamaMsg('29', true);
        }
    }

    $scope.get_cidade = function(id, destino) {
             
        
        if(destino == 'cidades_endereco_principal') {
            var uf = $scope.corretor.endereco[0].uf;
        } else if(destino == 'cidades_endereco_secundario') {
            var uf = $scope.corretor.endereco[1].uf;
        } else if(destino == 'cidades') {
            var uf = $scope.corretor.naturalidade_uf;
        }
        
        var destino = destino;
        if(uf != undefined && uf.length > 0) {
            $('.loading').show();  
            Cidades.get({'uf': uf }).$promise.then(function(data) {
                $('.loading').hide();

                if(destino == 'cidades') {
                    $scope.cidades = data.cidades;
                    //$('select[name="corretor[naturalidade]"]').select2();
                } else if(destino == 'cidades_endereco_principal') {
                    $scope.cidades_endereco_principal = data.cidades;
                    //$('select[name="corretor[endereco][0][cidade]"]').select2();
                } else if(destino == 'cidades_endereco_secundario') {
                    $scope.cidades_endereco_secundario = data.cidades;
                    //$('select[name="corretor[endereco][1][cidade]"]').select2();
                } 
                //$('select[name="corretor[naturalidade]"], select[name="corretor[endereco][0][cidade]"], select[name="corretor[endereco][1][cidade]"]').select2('val', '');
                
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
        
        if(cep != undefined) {
            $('.loading').show();
            $http({
                'method': 'get',
                'url': 'http://fitcontas.com.br/fitservices/logradouro/' + cep.replace('-', ''),
            }).success(function(data) {
                $('.loading').hide();

                if(data.cidade) {

                    $scope.corretor.endereco[indice].logradouro = data.logradouro;
                    $scope.corretor.endereco[indice].bairro = data.bairro;
                    $scope.corretor.endereco[indice].uf = data.uf;
                    $scope.corretor.endereco[indice].cidade = data.cidade_id;
            
                    var cidade_cep = [
                        { id: data.cidade_id, nome: data.cidade }
                    ];

                    var arr2 = [];
                    arr2['cidades'] = cidade_cep;
                    //$scope.cidades = arr2;
                    
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
