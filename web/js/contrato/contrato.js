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

    $scope.abaNext = function(aba) {
        if(aba == 2) {
            if(required('#aba-1', false)) {
                return false;
            }

            if($scope.validaCorretorComissao()) {
                chamaMsg('151', false);
                return false;
            }

            if($scope.validaClientePct()) {
                chamaMsg('152', false);
                return false;
            }
        } else if(aba == 3) {

        }

        $scope.aba = aba;
    };

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

    $scope.start = function(pagina) {
        if(pagina) {
            $scope.pagina = pagina;
        }

        if($scope.search.length > 0)
        {
            var termos = { pagina: $scope.pagina, query: $scope.search };
        } else {
            var termos = { pagina: $scope.pagina };
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

        $scope.parcelas_geradas = [];

        $('.has-error').removeClass('has-error');

        $('select[name="empreendimento_id"], select[name="contrato[lote_id]"]').select2('destroy');

        $('#contrato_modal').modal({
            show: true,
            backdrop: 'static'
        });

        $('select[name="empreendimento_id"], select[name="contrato[lote_id]"]').select2();
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
            $('input[name="contrato[desconto]"]').attr({ maxLength: 6 }).val('');
        } else {
            $('input[name="contrato[desconto]"]').attr({ maxLength: 11 }).val('');
        }

        $scope.contrato.tipo_desconto = num;
    };

    $scope.getLotes = function(empreendimento_id) {
        LotesEmpreendimento.get({id: empreendimento_id}).$promise.then(function(data) {     
            $scope.lotes = data.lotes;
            $scope.min_entrada = data.empreendimento.entrada;
            $scope.min_intermediarias = data.empreendimento.min_intermediarias;
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
        $scope.contrato.area_total = lote.area_total;
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
        } else {
            var valor_desconto = toFloat($('input[name="contrato[desconto]"]').val());
        }


        var valor_contrato = valor_lote - valor_desconto;
        $scope.contrato.valor_contrato = showMoney(valor_contrato);
    }

    $scope.validaEntrada = function() {
        if($scope.contrato.tipo_entrada == 1) {
            if(toFloat($('input[name="contrato[entrada]"]').val()) < $scope.min_entrada) {
                chamaMsg('150', false);
            }
        } else if($scope.contrato.tipo_entrada == 2) {
            var pct = (toFloat($('input[name="contrato[entrada]"]').val()) * 100) / toFloat($scope.contrato.valor_contrato);
            
            if(pct < $scope.min_entrada) {
                chamaMsg('150', false);
            }
        }

        var entrada = $scope.contrato.tipo_entrada == 1 ? ((toFloat($('input[name="contrato[entrada]"]').val()) / 100) * toFloat($scope.contrato.valor_contrato) ) : toFloat($('input[name="contrato[entrada]"]').val());

        $scope.entrada = accounting.formatMoney(entrada, "", 2, ".", ",");
        $scope.entrada_float = entrada;
    };

    $scope.validaIntermediarias = function() {
        if(toFloat($('input[name="contrato[intermediarias]"]').val()) < $scope.min_intermediarias)
        {
            chamaMsg('150', false);
            $('input[name="contrato[intermediarias]"]').val('');
        }

        if($scope.contrato.tipo_intermediarias == 2) {
            var valor_intermediarias = toFloat($('input[name="contrato[intermediarias]"]').val());
        } else {
            var valor_intermediarias = (toFloat($('input[name="contrato[intermediarias]"]').val()) * toFloat($scope.contrato.valor_contrato)) / 100;
        }

        if( valor_intermediarias > (toFloat($scope.contrato.valor_contrato) - $scope.entrada_float) ) {
            chamaMsg('153', false);
            console.log(valor_intermediarias, toFloat($scope.contrato.valor_contrato), $scope.entrada_float);
            $('input[name="contrato[intermediarias]"]').val('');
        }
    };

    $scope.processaQtdParcelas = function() {
        var periodo = _.find($scope.periodos, function(periodo) {
            return periodo.id == $scope.contrato.periodo;
        });

        $scope.parcelas = multiplos(periodo.qtd, $scope.max_parcelas);

        console.log(multiplos(periodo.qtd, $scope.max_parcelas));
    };

    $scope.geraParcelas = function() {
        if(
            parseInt($scope.contrato.parcelas) > 0 &&
            $scope.contrato.primeiro_vencimento != undefined &&
            toFloat($scope.contrato.intermediarias) > 0 &&
            toFloat($scope.contrato.entrada) > 0 &&
            parseInt($scope.contrato.periodo) > 0 &&
            toFloat($scope.contrato.valor_contrato) > 0 &&
            toFloat($scope.contrato.desconto) > 0
            ) {
            $http({
                method: 'POST',
                url: '/contrato/parcelas',
                data: $scope.contrato,
            }).success(function(data) {
                $scope.parcelas_geradas = data;
            });
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

        if(required('#ContratoForm', false)) {
            return false;
        }
        
        $http({
            method: 'POST',
            url: '/contrato/novo',
            data: $scope.contrato,
        }).success(function(data) {
            if(data.success) {
                chamaMsg('1', true);
                $('#contrato_modal').modal('hide');
                $scope.start();
            }
        });
    };

    $scope.start();

})

$(function() {
    $('.mask-money').maskMoney({prefix:'', allowNegative: false, thousands:'.', decimal:',', affixesStay: false, allowZero:true});

    $('.modal-dialog').css({ width: 800 });
})