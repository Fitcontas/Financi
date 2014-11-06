'use strict'

AppFinanci.controller('ContratoCtrl', function($scope, $http, LotesEmpreendimento, Contratos) {

    $scope.check_ctrl = [];
    $scope.checkall = false;

    $scope.entrada_check_ctrl = [];
    $scope.entrada_checkall = false;

    //Paginação
    $scope.pagina = 1;
    $scope.paginas = 0;
    $scope.search = '';
    $scope.lotes = [];

    $scope.selectedCorretores = null;
    $scope.selectedClientes = null;

    $scope.aba = 1;

    $scope.periodos = [
        { 'id': 1, 'descricao': 'Mensal', 'qtd': 1 },
        { 'id': 2, 'descricao': 'Bimestral', 'qtd': 2 },
        { 'id': 3, 'descricao': 'Trimestral', 'qtd': 3 },
        { 'id': 4, 'descricao': 'Quadrimestral', 'qtd': 4 },
        { 'id': 5, 'descricao': 'Semestral', 'qtd': 6 },
        { 'id': 6, 'descricao': 'Anual', 'qtd': 12 },
    ];

    $scope.parcelas = [];
    $scope.parcelas_geradas = [];
    $scope.entrada = null;
    $scope.entrada_float = null;

    $scope.abaNext = function(aba, back) {
        if(aba == 2) {

            if(!back) {
                if(required('#aba-1', false)) {
                    return false;
                }
            }

            /*if($scope.validaCorretorComissao()) {
                chamaMsg('151', false);
                return false;
            }

            if($scope.validaClientePct()) {
                chamaMsg('152', false);
                return false;
            }*/
        } else if(aba == 6) {
            //Verifica se todos os campos foram preenchidos.
            if(required('#aba-2', false)) {
                return false;
            }

            //para verificar clientes
            var test_clientes = false;

            //testando se um cliente foi selecionando 2 vezes
            _($scope.contrato.clientes).forEach(function(cliente, chave) {
                _($scope.contrato.clientes).forEach(function(cliente2, chave2) {
                    if(cliente.cliente_id == cliente2.cliente_id && chave != chave2) {
                        chamaMsg('162', false);
                        test_clientes = true;
                    }
                })
            });

            //se um cliente foi selecionando 2 vezes
            if(test_clientes) {
                test_clientes = false;
                return false;
            }


            //Verifica se a pct total é igual a 100%
            if($scope.validaClientePct()) {
                chamaMsg('152', false);
                return false;
            }
        } else if(aba == 5) {
            if(required('#aba-6', false)) {
                return false;
            }

            //para verificar corretores
            var test_corretores = false;

            //testando se um corretor foi selecionando 2 vezes
            _($scope.contrato.corretores).forEach(function(corretor, chave) {
                _($scope.contrato.corretores).forEach(function(corretor2, chave2) {
                    if(corretor.corretor_id == corretor2.corretor_id && chave != chave2) {
                        chamaMsg('163', false);
                        test_corretores = true;
                    }
                });
            });

            //se um corretor foi selecionando 2 vezes
            if(test_corretores) {
                test_corretores = false;
                return false;
            }

            if($scope.validaCorretorComissao()) {
                chamaMsg('151', false);
                return false;
            }
        } else if(aba == 3) {
            if($scope.contrato.tipo_entrada == 1) {
                if(toFloat($('input[name="contrato[entrada]"]').val()) < $scope.min_entrada) {
                    chamaMsg('150', false);
                    return false;                
                }
            } else if($scope.contrato.tipo_entrada == 2) {
                var pct = (toFloat($('input[name="contrato[entrada]"]').val()) * 100) / toFloat($scope.contrato.valor_contrato);
                
                if(pct < $scope.min_entrada) {
                    chamaMsg('150', false);
                    return false;
                }
            }
        }

        $scope.aba = aba;
    };

    $scope.setAba = function(aba) {
        return aba == $scope.aba;
    }

    $scope.validaCorretorComissao = function() {
        var total = 0;

        _($scope.contrato.corretores).forEach(function(obj) {
            total += toFloat(obj.comissao);
        });

        if(total != 100.00) {
            return true;
        }

        return false;
    }

    $scope.validaClientePct = function() {
        var total = 0;

        _($scope.contrato.clientes).forEach(function(obj) {
            total += toFloat(obj.porcentagem);
        });

        if(total != 100.00) {
            return true;
        }

        return false;
    }

    $scope.start = function(pagina, column_sort, sort, filtro) {
        console.log(filtro)
        if(pagina) {
            $scope.pagina = pagina;
        }

        if($scope.search.length > 0)
        {
            var termos = { pagina: $scope.pagina, query: $scope.search, filtro: filtro };
        } else {
            var termos = { pagina: $scope.pagina, filtro: filtro };
        }

        if(column_sort && sort) {
            termos.column = column_sort;
            termos.sort = sort;
        }

        Contratos.get(termos).$promise.then(function(data){
            $scope.model = data;
            $scope.paginas = new Array(data.pagination.paginas);
            $scope.pagination = data.pagination;
        });
    };

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

            var itens = $scope.check_ctrl.length > 0 ? $scope.check_ctrl : $scope.model.usuarios;
            
            chamaMsg('20', true, false, {'id':'excluir-registro'});
            
            $('button[data-id="excluir-registro"]').click(function() {
                $http({
                    'method': 'post',
                    'url': '/contrato/acoes/' + acao_name,
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
          
        }
    }

    $scope.showForm = function(item) {
        
        $scope.aba = 1;
        $scope.contrato = {
            corretores: [{}],
            clientes: [{}],
            desconto: '',
            tipo_intermediarias: 1,
            tipo_entrada: 1,
            tipo_desconto: 1,
            entrada_config: {
                meio_pagamento_id: 1,
                entradas: [],
                total: 0
            }
        };

        $scope.lotes = [];
        $('select[name="contrato[lote_id]"]').select2('destroy').select2();

        $scope.parcelas_geradas = [];

        $('.has-error').removeClass('has-error');

        $('select[name="empreendimento_id"], select[name="contrato[lote_id]"]').select2('destroy').select2();

        $('#contrato_modal').modal({
            show: true,
            backdrop: 'static'
        }).on('hidden.bs.modal', function() {
            $scope.lotes = [];
            console.log($scope.lotes);
            $('select[name="empreendimento_id"], select[name="contrato[lote_id]"]').select2('destroy').select2();
        }).on('show.bs.modal', function() {
            $scope.lotes = [];
            console.log($scope.lotes);
            //$('select[name="empreendimento_id"], select[name="contrato[lote_id]"]').select2('destroy').select2('val', '');
        });
    };

    $scope.alteraTipoIntermediaria = function(num) {
        if(num == 1) {
            $('input[name="contrato[intermediarias]"]').attr({ maxLength: 6 }).val('');
        } else {
            $('input[name="contrato[intermediarias]"]').attr({ maxLength: 11 }).val('');
        }

        $scope.contrato.tipo_intermediarias = num;
    };

    $scope.alteraTipoEntrada = function(num) {
        if(num == 1) {
            $('input[name="contrato[entrada]"]').attr({ maxLength: 6 }).val('');
        } else {
            $('input[name="contrato[entrada]"]').attr({ maxLength: 11 }).val('');
        }

        $scope.contrato.tipo_entrada = num;
    };

    $scope.alteraTipoDesconto = function(num) {
        if(num == 1) {
            $('input[name="contrato[desconto]"]').attr({ maxLength: 5 }).val('');
        } else {
            $('input[name="contrato[desconto]"]').attr({ maxLength: 11 }).val('');
        }

        $scope.contrato.tipo_desconto = num;
    };

    $scope.getLotes = function(empreendimento_id) {
        LotesEmpreendimento.get({id: empreendimento_id}).$promise.then(function(data) {     
            $scope.lotes = data.lotes;
            $scope.corretores = data.corretores;
            $scope.min_entrada = data.empreendimento.entrada;

            $scope.min_intermediarias = data.empreendimento.intermediarias;
            $scope.max_periodo = data.empreendimento.periodo;
            $scope.max_parcelas = data.empreendimento.qtd_parcelas;
        });
    }

    $scope.setLote = function() {
        var lote = _.find($scope.lotes, function(lote) {
            return lote.id == $scope.contrato.lote_id;
        });
        console.log(lote);
        $scope.contrato.valor = showMoney(lote.valor);
        $scope.contrato.area_total = showMoney(lote.area_total);

        $scope.contrato.desconto = '0,00';
        $scope.calcValorContrato('this');
    }

    $scope.addCorretor = function() {
        $scope.contrato.corretores.push({});
    }

    $scope.removeCorretor = function(index) {
        if($scope.contrato.corretores.length > 1) {
            $scope.contrato.corretores.splice(index, 1);
        }
    }

    $scope.addCliente = function() {
        $scope.contrato.clientes.push({});
    }

    $scope.removeCliente = function(index) {
        if($scope.contrato.clientes.length > 1) {
            $scope.contrato.clientes.splice(index, 1);
        }
    }

    /**
     * Validações
     */
    $scope.validaPrimeiraAba = function() {
        if(ContratoForm.empreendimento_id.$invalid || ContratoForm.emissao.$invalid) {
            return false;
        }

        return true;
    }

    $scope.calcValorContrato = function(that) {

        var valor_lote = toFloat($scope.contrato.valor);
        
        //Se tipo de desconto for em %
        if($scope.contrato.tipo_desconto == 1) {
            var porcentagem_desconto = toFloat($('input[name="contrato[desconto]"]').val());
            var valor_desconto = (porcentagem_desconto * valor_lote) / 100;
            $scope.calculo_desconto = 'R$ ' + showMoney(valor_desconto);
        } else {
            var valor_desconto = toFloat($('input[name="contrato[desconto]"]').val());
        }


        var valor_contrato = valor_lote - valor_desconto;
        $scope.contrato.valor_contrato = showMoney(valor_contrato);
        
        var valor_min_entrada = valor_contrato * ($scope.min_entrada / 100);
        var valor_min_intermediaria = valor_contrato * ($scope.min_intermediarias / 100);
        console.log($scope.min_intermediarias);
        $scope.min_entrada_valor = showMoney(valor_min_entrada);
        $scope.min_intermediaria_valor = showMoney(valor_min_intermediaria);
    }

    $scope.validaEntrada = function() {
        /*if($scope.contrato.tipo_entrada == 1) {
            if(toFloat($('input[name="contrato[entrada]"]').val()) < $scope.min_entrada) {
                chamaMsg('150', false);
            }
        } else if($scope.contrato.tipo_entrada == 2) {
            var pct = (toFloat($('input[name="contrato[entrada]"]').val()) * 100) / toFloat($scope.contrato.valor_contrato);
            
            if(pct < $scope.min_entrada) {
                chamaMsg('150', false);
            }
        }*/

        var entrada = $scope.contrato.tipo_entrada == 1 ? ((toFloat($('input[name="contrato[entrada]"]').val()) / 100) * toFloat($scope.contrato.valor_contrato) ) : toFloat($('input[name="contrato[entrada]"]').val());

        $scope.entrada = accounting.formatMoney(entrada, "", 2, ".", ",");
        $scope.entrada_float = entrada;
    };

    $scope.validaIntermediarias = function() {
        /*if(toFloat($('input[name="contrato[intermediarias]"]').val()) < $scope.min_intermediarias)
        {
            chamaMsg('150', false);
            $('input[name="contrato[intermediarias]"]').val('');
        }*/

        if($scope.contrato.tipo_intermediarias == 2) {
            var valor_intermediarias = toFloat($('input[name="contrato[intermediarias]"]').val());
        } else {
            var valor_intermediarias = (toFloat($('input[name="contrato[intermediarias]"]').val()) * toFloat($scope.contrato.valor_contrato)) / 100;
        }

        console.log('fdsfsd:' + valor_intermediarias)
        if(valor_intermediarias == 0) {
            $scope.parcelas = multiplos(1, $scope.max_parcelas);
            $('select[name="contrato[periodo]"').prop('disabled', true);
        } else {
            $('select[name="contrato[periodo]"').prop('disabled', false);
        }

        /*if( valor_intermediarias > (toFloat($scope.contrato.valor_contrato) - $scope.entrada_float) ) {
            chamaMsg('153', false);
            console.log(valor_intermediarias, toFloat($scope.contrato.valor_contrato), $scope.entrada_float);
            $('input[name="contrato[intermediarias]"]').val('');
        }*/
    };

    $scope.processaQtdParcelas = function() {
        var periodo = _.find($scope.periodos, function(periodo) {
            return periodo.id == $scope.contrato.periodo;
        });

        if($('input[name="contrato[intermediarias]"]').val() == '0,00') {
            $scope.parcelas = multiplos(1, $scope.max_parcelas);
            $('select[name="contrato[periodo]"').prop('disabled', true);
        } else {
            $scope.parcelas = multiplos(periodo.qtd, $scope.max_parcelas);
            $('select[name="contrato[periodo]"').prop('disabled', false);
        }

        console.log(multiplos(periodo.qtd, $scope.max_parcelas));
    };

    //Gera as parcelas
    $scope.geraParcelas = function() {
        if(
            parseInt($scope.contrato.parcelas) > 0 &&
            $scope.contrato.primeiro_vencimento != undefined &&
            toFloat($scope.contrato.intermediarias) >= 0 &&
            toFloat($scope.contrato.entrada) > 0 &&
            toFloat($scope.contrato.valor_contrato) > 0 &&
            toFloat($scope.contrato.desconto) >= 0
            ) {

            //Valida a entrada no momento de gerar as parcelas
            if($scope.contrato.tipo_entrada == 1) {
                if(toFloat($('input[name="contrato[entrada]"]').val()) < $scope.min_entrada) {
                    chamaMsg('150', false);
                    return false;
                }
            } else if($scope.contrato.tipo_entrada == 2) {
                var pct = (toFloat($('input[name="contrato[entrada]"]').val()) * 100) / toFloat($scope.contrato.valor_contrato);
                
                if(pct < $scope.min_entrada) {
                    chamaMsg('150', false);
                    return false;
                }
            }

            //Valor da intermediária
            if($scope.contrato.tipo_intermediarias == 2) {
                var valor_intermediarias = toFloat($('input[name="contrato[intermediarias]"]').val());
            } else {
                var valor_intermediarias = (toFloat($('input[name="contrato[intermediarias]"]').val()) * toFloat($scope.contrato.valor_contrato)) / 100;
            }

            //Valida se a intermediária está abaixo mínimo permitido.
            if(toFloat($('input[name="contrato[intermediarias]"]').val()) < $scope.min_intermediarias)
            {
                chamaMsg('161', false);
                $('input[name="contrato[intermediarias]"]').val('');
                return false;
            }

            //Valida se a intermediária está acima do máximo permitido.
            if( valor_intermediarias > (toFloat($scope.contrato.valor_contrato) - $scope.entrada_float) ) {
                chamaMsg('153', false);
                console.log(valor_intermediarias, toFloat($scope.contrato.valor_contrato), $scope.entrada_float);
                $('input[name="contrato[intermediarias]"]').val('');
            }

            //Faz a requisição para gerar as parcelas.
            $http({
                method: 'POST',
                url: '/contrato/parcelas',
                data: $scope.contrato,
            }).success(function(data) {
                $scope.parcelas_geradas = data;
            });
        } else {
            console.log($scope.contrato);
        }

        
    };

    $scope.$watch('contrato.primeiro_vencimento', function(vl) {
        if(vl != undefined) {
            $scope.geraParcelas();
        }
    });

    $scope.$watch('contrato.parcelas', function(vl) {
        if(vl != undefined) {
            $scope.geraParcelas();
        }
    });

    $scope.$watch('contrato.intermediarias', function(vl) {
        if(vl != undefined) {
            $scope.geraParcelas();
        }
    });

    $scope.$watch('contrato.entrada', function(vl) {
        if(vl != undefined) {
            $scope.geraParcelas();
        }
    });

    $scope.$watch('contrato.desconto', function(vl) {
        if(vl != undefined) {
            $scope.geraParcelas();
        }
    });

    $scope.$watch('contrato.periodo', function(vl) {
        if(vl != undefined) {
            $scope.geraParcelas();
        }
    });

    $scope.gerarEntradasCheque = function() {

        var valor = angular.element('input[name="contrato[entrada_config][valor]"]').val();

        if($scope.contrato.entrada_config.meio_pagamento_id == 2 
            && $scope.contrato.entrada_config.meio_forma_id == 2
            && valor.length > 3
            && valor != '00,00') {

            var parcela = toFloat(valor) / toFloat($scope.contrato.entrada_config.qtd_parcelas);

            $scope.contrato.entrada_config.parcelas = [];
            var numero = 0;
            var date, i;
            for(i = 0; i<parseInt($scope.contrato.entrada_config.qtd_parcelas); i++) {

                numero = numero == 0 ? parseInt($scope.contrato.entrada_config.numero_cheque) : numero+1;

                var data_inicial = $scope.contrato.entrada_config.cheque_vencimento;

                var nova_data_inicial = data_inicial.split("/")[2] + '-' + data_inicial.split("/")[1] + '-' + data_inicial.split("/")[0];

                date = moment(nova_data_inicial).add(parseInt($scope.contrato.entrada_config.periodicidade) * i, 'days');

                console.log(date);

                $scope.contrato.entrada_config.parcelas.push({
                    linha: i+1,
                    numero: numero,
                    vencimento: date.format('DD/MM/YYYY'),
                    valor: accounting.formatMoney(parcela, "", 2, ".", ",")
                });
            }

            console.log($scope.contrato.entrada_config.parcelas);

        }
    };

    $scope.addEntrada = function() {

        if(required('#aba-3', false)) {
            return false;
        }
        console.log('teste');
        $scope.aba = 4;

        var itens = {
            meio_form_id: $scope.contrato.entrada_config.meio_form_id,
            meio_pagamento_id: $scope.contrato.entrada_config.meio_pagamento_id,
            numero_cheque: $scope.contrato.entrada_config.numero_cheque,
            cheque_vencimento: $scope.contrato.entrada_config.cheque_vencimento,
            qtd_parcelas: $scope.contrato.entrada_config.qtd_parcelas,
            periodicidade: $scope.contrato.entrada_config.periodicidade,
            valor: $scope.contrato.entrada_config.valor,
            parcelas: $scope.contrato.entrada_config.parcelas
        };

        $scope.contrato.entrada_config.entradas.push({
            tipo: $scope.contrato.entrada_config.meio_pagamento_id,
            valor: $scope.contrato.entrada_config.valor,
            itens: itens
        });

        $scope.contrato.entrada_config.total += toFloat($scope.contrato.entrada_config.valor);

        $scope.contrato.entrada_config.meio_form_id = 1;
        $scope.contrato.entrada_config.meio_pagamento_id = 1;
        $scope.contrato.entrada_config.cheque_vencimento = '';
        $scope.contrato.entrada_config.qtd_parcelas = '';
        $scope.contrato.entrada_config.numero_cheque = '';
        $scope.contrato.entrada_config.periodicidade =  '';
        $scope.contrato.entrada_config.valor = '';
        $scope.contrato.entrada_config.parcelas = [];
    };

    $scope.entradaRemove = function() {
        var i;
        console.log($scope.entrada_check_ctrl);
        
        for(i = 0; i < $scope.entrada_check_ctrl.length; i++) {
            console.log(toFloat($scope.contrato.entrada_config.entradas[$scope.entrada_check_ctrl[i].id].valor));
            $scope.contrato.entrada_config.total -= toFloat($scope.contrato.entrada_config.entradas[$scope.entrada_check_ctrl[i].id].valor);
            
            $scope.contrato.entrada_config.entradas.splice($scope.entrada_check_ctrl[i].id, 1);

        }

        if($scope.entrada_checkall) {
            $scope.contrato.entrada_config.total = 0;
             $scope.contrato.entrada_config.entradas = [];
        }

        $scope.entrada_check_ctrl = [];
    };

    $scope.checkAllEntrada = function(index) {
        var existe = _.remove($scope.entrada_check_ctrl, function(obj) {
            return obj.id == index;
        });

        if(!existe.length) {
            $scope.entrada_check_ctrl.push({id: index});
        }

        console.log($scope.entrada_check_ctrl);
    };

    $scope.salveGeral = function() {
        console.log($scope.contrato);

        if(required('#aba-4', false)) {
            return false;
        }

        if($scope.parcelas_geradas == undefined) {
            chamaMsg('154' , false);
            return false;
        } else if($scope.parcelas_geradas.length == 0) {
            chamaMsg('154' , false);
            return false;
        }

        var entrada = $scope.contrato.tipo_entrada == 1 ? ((toFloat($('input[name="contrato[entrada]"]').val()) / 100) * toFloat($scope.contrato.valor_contrato) ) : toFloat($('input[name="contrato[entrada]"]').val());

        if($scope.contrato.entrada_config.total != entrada) {
            chamaMsg('155', false);
            return false;
        }
        
        $http({
            method: 'POST',
            url: '/contrato/novo',
            data: { contrato: $scope.contrato, parcelas: $scope.parcelas_geradas },
        }).success(function(data) {
            if(data.success) {
                chamaMsg('1', true);
                $('#contrato_modal').modal('hide');
                $scope.start();
            }
        });
    };

    $scope.pesquisaAvancada = function() {
        $('#contrato_pesquisa_modal').modal({
            show: true,
            backdrop: 'static'
        });
    }

    $scope.clienteWindow = function() {
        window.open('/cliente/cadastro/pf?origem=1', '_parant', 'top=50, right=50, toolbar=no');
    }

    $scope.showFormEdit = function(id) {
        console.log('Editando: '+ id + ' | ' + typeof id);

        if(id) {
            $http({
                'method': 'GET',
                'url': 'contrato/get/'+id,
            }).success(function(data) {
                if(data.success) {
                    $scope.contrato = data.contrato;
                    $('#contrato_modal').modal({
                        show: true,
                        backdrop: 'static'
                    });
                }

            })
        }

    }

    $scope.start();

})

$(function() {
    $('.mask-money').maskMoney({prefix:'', allowNegative: false, thousands:'.', decimal:',', affixesStay: false, allowZero:true});

    $('#contrato_modal .modal-dialog').css({ width: 800 });

    
})