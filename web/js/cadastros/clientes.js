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

        if(required('#ClienteForm', false) > 0) {
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
                    if( $('#origem').val() == 1 ) {
                        $(window.opener.document.getElementById('contrato-clientes')).append('<option value"'+data.obj.id+'">'+data.obj.nome+'</option>');
                        setTimeout(function() {
                            window.close();
                        }, 500);
                    } else {
                        $window.location = !add ? '/cliente' : '/cliente/cadastro/pf';
                    }
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

                    window.location = '/cliente/edita/pf/'+data.id;
                    $('.loading').show();
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
        
        console.log(destino);     
        
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

                if(destino == 'cidades') {
                    $scope.cidades = data.cidades;
                    //$('select[name="cliente[naturalidade]"]').select2();
                } else if(destino == 'cidades_endereco_principal') {
                    $scope.cidades_endereco_principal = data.cidades;
                    //$('select[name="cliente[endereco][0][cidade]"]').select2();
                } else if(destino == 'cidades_endereco_secundario') {
                    $scope.cidades_endereco_secundario = data.cidades;
                    //$('select[name="cliente[endereco][1][cidade]"]').select2();
                } else if(destino == 'cidades_conjuge') {
                    $scope.cidades_conjuge = data.cidades;
                    $scope.cliente.conjuge.naturalidade = parseInt($scope.cliente.conjuge.naturalidade);
                    //$('select[name="cliente[conjuge][naturalidade]"]').select2();
                }
                //$('select[name="cliente[naturalidade]"], select[name="cliente[endereco][0][cidade]"], select[name="cliente[endereco][1][cidade]"], select[name="cliente[conjuge][naturalidade]"]').select2('val', '');
                
            });
        }
        
    }

    $scope.verificaCasado = function() {
        
        if($scope.cliente.estado_civil == 2) {
            console.log('Casado');
            $('input[name="cliente[conjuge][cpf]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][nome]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][data_nascimento]"]').attr('required', true).attr('req', true);
            $('select[name="cliente[conjuge][naturalidade]"]').attr('required', true).attr('req', true);
            $('input[name="cliente[conjuge][nacionalidade]"]').attr('required', true).attr('req', true);
            $('select[name="cliente[conjuge][naturalidade_uf]"]').attr('required', true).attr('req', true);
        } else {
            console.log('Solteiro');
            $('input[name="cliente[conjuge][cpf]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
            $('input[name="cliente[conjuge][nome]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
            $('input[name="cliente[conjuge][data_nascimento]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
            $('select[name="cliente[conjuge][naturalidade]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
            $('input[name="cliente[conjuge][nacionalidade]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
            $('select[name="cliente[conjuge][naturalidade_uf]"]').removeAttr('required').removeAttr('req').closest('div').removeClass('has-error');;
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
                    //$scope.cidades = arr2;
                    
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

function teste() {
    alert('teste');
    //$('select[name="cliente[naturalidade]"]').select2();
};