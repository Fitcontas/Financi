<div ng-controller="ContratoCtrl" ng-cloak>
<form id="#grid_contrato" class="grid">
    <div class="row margin-top-50">
        <div id="no-reg" class="content" style="display: none">
            <div class="container">
                <h5>No momento não existe nenhum registro cadastrado. <?php echo true ? 'Para inserir um novo clique em “Adicionar”.' : '' ?></h5>
                <div class="table-responsive hide">
                        <button class="btn btn-default dropdown-toggle no-margin" data-toggle="dropdown" type="button">
                            Adicionar &nbsp; <span class="caret"></span>
                        </button>
                </div>
            </div>
        </div>
        <div id="si-reg" class="content" style="display: block">
            <div class="mensagem">
                <!-- Conteúdo da mensagem -->
            </div>

            <div class="block-flat" ng-show="model.total_geral == 0 && model.$resolved">
                <div class="header">
                    <h3>Contratos</h3>
                </div>

                <div class="content spacer0 process">
                    <p>Até o momento não existe nenhum contrato cadastro. Para inserir um novo registro clique no botão adicionar.</p>
                    <p><button type="button" class="btn btn-default" ng-click="showForm(false)" style="margin:5px 0 0 0 !important">Adicionar</button></p>
                </div>
            </div>

            <div class="block-flat" ng-show="(model.contratos.length && model.$resolved) || model.busca">
                <div class="header">
                    <h3>Relação de Contratos</h3>
                </div>
                <div class="content spacer0 process">
                    <div class="toobar">
                        <div class="pull-left">
                            <div class="btn-group pull-left" id="buttons-grid">
                                <button type="button" class="btn btn-default" ng-click="showForm(false)"> Novo</button>
                                <button type="button" class="btn btn-default" ng-click="acao('excluir')"> Excluir</button>
                                <button type="button" class="btn btn-default" ng-click="pesquisaAvancada()"> Pesquisa</button>
                            </div>
                        </div>
                        <div class="pull-right">
                            <div class="input-group search-group">
                              <input class="form-control" type="text" placeholder="Pesquisar" ng-model="search" ng-enter="start()">
                              <span class="input-group-btn">
                                <button class="btn btn-default btn-sm" type="button" ng-click="start()"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix tool"></div>

                    <!-- Início data table content -->
                    <div class="table-responsive" ng-show="model.contratos.length>0">
                        <table class="table table-bordered spacer2 table-hover">
                            <thead>
                                <tr>
                                    <th class="checkbox-control">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="checkall" ng-model="checkall" ng-check-all-test></label>
                                        </div>
                                    </th>
                                    <th class="sorting" data-column="data_emissao" data-sort="asc" ng-sort>Emissão</th>
                                    <th class="sorting" data-column="id" data-sort="asc" ng-sort>Contrato</th>
                                    <th class="sorting" data-column="data_emissao" data-sort="asc" ng-sort>Nome/Razão Social</th>
                                    <th class="sorting text-right" data-column="valor" data-sort="asc" ng-sort>Valor R$&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Imprimir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="c in model.contratos">
                                    <td><input type="checkbox" ng-model="confirmed" ng-change="checkAll(c)" ng-checked="checkall" ng-check-test></td>
                                    <td>{{ c.data_emissao }}</td>
                                    <td><a ng-click="showFormEdit(c.id)">{{ c.contrato }}</a></td>
                                    <td>{{ c.clientes.length == 1 ? c.clientes[0].nome : c.clientes[0].nome + ' e outros' }}</td>
                                    <td class="text-right">{{ c.valor }}</td>
                                    <td><a href="#"><i class="fa fa-print"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- início da paginação -->
                        <div class="row-fluid" ng-show="paginas.length>1">
                          <div class="span12">
                             <div>
                             <div class="pagination pull-left">
                                 Exibindo de {{pagination.inicio + 1}} a {{ pagination.inicio+pagination.limite > pagination.total_geral ? pagination.total_geral : pagination.inicio+pagination.limite }} de {{pagination.total_geral}} registros 
                             </div>
                              <ul class="pagination pull-right">
                                <li ng-repeat="i in paginas track by $index" ng-init="p=$index+1" ng-class="{'disabled':p==pagina}">
                                  <a ng-click="start($index+1)" href="javascript:void(0)">{{$index+1}}</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                        <!-- /fim da paginação -->              
                    </div>
                    <!-- /Fim data table content -->

                    <!-- Início da mensagem caso não haja registro -->
                    <div class="table-responsive" ng-show="!model.contratos.length && model.$resolved && model.busca">
                        <div class="alert alert-warning alert-white rounded">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <div class="icon"><i class="fa fa-warning"></i></div>
                            <strong>Opss!</strong> Nenhum registro encontrado!
                         </div>
                    </div>
                    <!-- /Fim da mensagem caso não haja registro -->
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div role="dialog" id="contrato_modal" class="modal fade in" aria-hidden="false"><!-- Modal -->
    <form autocomplete="off" name="ContratoForm" id="ContratoForm" class="form-horizontal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Contrato</h3>
                <span>Formulário de Cadastro</span>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            </div>
            <div class="modal-body">
                <div class="mensagem-modal">
                </div>

                <div ng-hide="aba == 3 || aba == 4" style="margin-top: -3px;" class="tab-container">
                    <ul class="nav nav-tabs" ng-hide="true">
                      <li ng-class="{ 'active' : aba == 1, 'disabled': aba != 1 }"><a data-toggle="" href="javascript://">Contrato</a></li>
                      <li ng-class="{ 'active' : aba == 2, 'disabled': aba != 2 }"><a data-toggle="" href="javascript://">Cliente</a></li>
                      <li ng-class="{ 'active' : aba == 6, 'disabled': aba != 6 }"><a data-toggle="" href="javascript://">Corretor</a></li>
                      <li ng-class="{ 'active' : aba == 5, 'disabled': aba != 5 }"><a data-toggle="" href="javascript://">Pagamento</a></li>
                    </ul>

                    <div class="stepwizard">
                        <div class="stepwizard-row">
                            <div class="stepwizard-step">
                            <p>Contrato</p>
                                <button type="button" class="btn btn-circle" ng-class="{ 'btn-primary' : aba == 1, 'btn-default' : aba != 1 }" ng-disabled="aba != 1">1</button>
                                
                            </div>
                            <div class="stepwizard-step">
                                <p>Cliente</p>
                                <button type="button" class="btn btn-circle" ng-class="{ 'btn-primary' : aba == 2, 'btn-default' : aba != 2 }" ng-disabled="aba != 2">2</button>
                                
                            </div>
                            <div class="stepwizard-step">
                                <p>Corretor</p>
                                <button type="button" class="btn btn-circle" ng-class="{ 'btn-primary' : aba == 6, 'btn-default' : aba != 6 }" ng-disabled="aba != 6">3</button>
                                
                            </div>
                            <div class="stepwizard-step">
                                <p>Pagamento</p>
                                <button type="button" class="btn btn-circle" ng-class="{ 'btn-primary' : aba == 5, 'btn-default' : aba != 5 }" ng-disabled="aba != 4">4</button>
                                
                            </div> 
                        </div>
                    </div>
                    
                    

                </div>

                <!-- Aba 1 -->
                <div ng-show="aba == 1" id="aba-1"  style="margin-top:25px">

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-5 control-label" for="contrato[emissao]">Emissão</label>
                        <div class="col-sm-6">
                            <div class="input-group date contrato-date">
                                <input type="text" ng-model="contrato.emissao" value="" id="contrato[emissao]" name="emissao" class="form-control" req required>
                                <span class="add-on input-group-btn"><button tabindex="2" type="button" class="btn btn-default"><i title="Calendário" class="fa fa-calendar"></i></button></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="nome">Empreendimento</label>
                        <div class="col-sm-14">
                            <select name="empreendimento_id" id="contrato[empreendimento_id]" ng-model="contrato.empreendimento_id" class="form-control" ng-change="getLotes(contrato.empreendimento_id)" req required>
                                <option value=""></option>
                                <?php foreach ($empreendimentos as $e): ?>
                                    <option value="<?php echo $e->id ?>"><?php echo $e->empreendimento ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="contrato[lote_id]">Lote  </label>
                        <div class="col-sm-14">
                            <select name="contrato[lote_id]" id="contrato[lote_id]" ng-model="contrato.lote_id" class="form-control" ng-options="lote.id as 'Lote ' + lote.numero + ' - Quadra ' + lote.quadra for lote in lotes" ng-change="setLote()" req required>
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="contrato[area_total]">Área Total <small>m²</small></label>
                        <div class="col-sm-6">
                            <input type="text" name="contrato[area_total]" class="form-control" required data-ng-model="contrato.area_total" ng-disabled="true" ng-money>
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-5 control-label" for="contrato[valor]">Valor do Lote</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="contrato[valor]" class="form-control" required ng-model="contrato.valor" ng-disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-5 control-label" for="desconto">Desconto </label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon" ng-show="contrato.tipo_desconto == 2" ng-click="alteraTipoDesconto(1)">R$</span>

                                <input type="text" name="contrato[desconto]" class="form-control mask-money" ng-model="contrato.desconto" ng-money ng-keyup="calcValorContrato(this)" maxlength="5" value="0,00">

                                <span class="input-group-addon" ng-show="contrato.tipo_desconto == 1" ng-click="alteraTipoDesconto(2)">%</span>
                            </div>
                        </div>


                        <label class="col-sm-8" ng-show="contrato.tipo_desconto == 1" for="">{{calculo_desconto}}</label>

                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-5 control-label" for="valor_contrato">Valor do Contrato </label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="text" class="form-control mask-money" req required ng-model="contrato.valor_contrato" ng-disabled="true">
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer" style="width:105.4%; margin-left:-20px; margin-bottom:-5px;">
                        <button class="btn btn-primary" type="button" ng-click="abaNext(2)">Avançar</button>
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                    </div>

                </div>
                <!-- Fim aba 1 -->

                <!-- Aba 2 -->
                <div ng-show="aba == 2" id="aba-2" style="margin-top:25px">

                    <!-- Compradores -->
                    <div class="form-group no-margin-bottom" ng-repeat="cliente in contrato.clientes">
                        <label class="col-sm-2 control-label" for="">Nome</label>
                        <div class="col-sm-15">
                            <div class="input-group">
                                
                                <select id="contrato-clientes" name="contrato[clientes][$index][cliente_id]" class="form-control" req required ng-selected="contrato.clientes[$index].cliente_id" ng-model="contrato.clientes[$index].cliente_id" ng-options="cliente.id as cliente.nome for cliente in lista_clientes">
                                  
                                </select>

                                <span class="add-on input-group-btn">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle no-margin" action="no"><i title="Calendário" class="fa fa-plus"></i></button>    
                                <ul role="menu" class="dropdown-menu">    
                                    <li><a href="" ng-click="clienteWindow()" class="no">Cliente PF</a></li>    
                                    <li><a href="" ng-click="clientePjWindow()" class="no">Cliente PJ</a></li>    
                                </ul>
                                </span>

                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" class="form-control" req required ng-model="contrato.clientes[$index].porcentagem" name="porcentagem" ng-money="" maxlength="6">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button tabindex="2" type="button" class="btn btn-default btn-sm pull-right" ng-click="removeCliente($index)">&nbsp;&nbsp;<i class="fa fa-trash-o"></i>&nbsp;&nbsp;</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8">
                            <label for="" class="col-sm-6 control-label"></label>
                            <button tabindex="2" style="margin-left:4px" type="button" class="btn btn-default" ng-click="addCliente()">Adicionar</button>
                        </div>
                    </div>

                    <div class="modal-footer" style="width:105.4%; margin-left:-20px; margin-bottom:-5px;">
                        <a href="javascript://" style="margin-top:8px;" class="pull-left" ng-click="abaNext(1)">Voltar</a>
                        
                        <button class="btn btn-primary" type="button" ng-click="abaNext(6)">Avançar</button>
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                    </div>

                    
                </div>
                <!-- Fim aba 2 -->
                
                <!-- Início ABA 6 -->
                <div ng-show="aba == 6" id="aba-6" style="margin-top:25px">
                    <!-- Corretores -->
                    <div class="form-group no-margin-bottom" ng-repeat="corretor in contrato.corretores">
                        <label class="col-sm-2 control-label" for="">Nome</label>
                        <div class="col-sm-15">

                                <select ng-model="contrato.corretores[$index].corretor_id" id="contrato[corretores][$index][corretor_id]" name="contrato[corretores][$index][corretor_id]" class="form-control" req required ng-options="corretor.id as corretor.nome for corretor in corretores">
                                </select>
                                
                          
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" class="form-control" req required ng-model="contrato.corretores[$index].comissao" name="comissao" ng-money="" maxlength="6">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button tabindex="2" type="button" class="btn btn-default btn-sm pull-right" ng-click="removeCorretor($index)">&nbsp;&nbsp;<i class="fa fa-trash-o"></i>&nbsp;&nbsp;</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8">
                            <label for="" class="col-sm-6 control-label"></label>
                            <button tabindex="2" style="margin-left:4px" type="button" class="btn btn-default" ng-click="addCorretor()">Adicionar</button>
                        </div>
                    </div>

                    <div class="modal-footer" style="width:105.4%; margin-left:-20px; margin-bottom:-5px;">
                        <a href="javascript://" style="margin-top:8px;" class="pull-left" ng-click="abaNext(2, 1)">Voltar</a>
                        
                        <button class="btn btn-primary" type="button" ng-click="abaNext(5)">Avançar</button>
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                    </div>

                </div>
                 <!-- Fim aba 4 -->
                
                 <!-- inicio aba 5 -->
                <div ng-show="aba == 5" id="aba-5" style="margin-top:25px">
                    
                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-5 control-label" for="valor">Valor do Contrato </label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="text" class="form-control mask-money" req required ng-model="contrato.valor_contrato" ng-disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-5 control-label" for="contrato.entrada">Entrada </label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon" ng-show="contrato.tipo_entrada == 2" ng-click="alteraTipoEntrada(1)">R$</span>

                                <input type="text" name="contrato[entrada]" class="form-control mask-money" req required ng-model="contrato.entrada" maxlength="6" ng-money ng-blur="validaEntrada()">
                                
                                <span class="input-group-addon" ng-show="contrato.tipo_entrada == 1" ng-click="alteraTipoEntrada(2)">%</span>
                            </div>
                        </div>
                        <label class="contral-form col-sm-8">
                           <small ng-show="contrato.tipo_entrada == 1">Mínima de {{min_entrada}}%</small>
                           <small ng-show="contrato.tipo_entrada == 2">Mínima de R$ {{min_entrada_valor}}</small>
                        </label>
                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-5 control-label" for="contrato.intermediarias">Intermediarias </label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon" ng-show="contrato.tipo_intermediarias == 2" ng-click="alteraTipoIntermediaria(1)">R$</span>

                                <input type="text" name="contrato[intermediarias]" class="form-control mask-money" req required ng-model="contrato.intermediarias" ng-money ng-blur="validaIntermediarias()" maxlength="6">

                                <span class="input-group-addon" ng-show="contrato.tipo_intermediarias == 1" ng-click="alteraTipoIntermediaria(2)">%</span>
                            </div>
                        </div>

                        <label class="contral-form col-sm-8">
                            <small ng-show="contrato.tipo_intermediarias == 1">Mínima de {{min_intermediarias}}%</small>
                            <small ng-show="contrato.tipo_intermediarias == 2">Mínima de R$ {{min_intermediaria_valor}}</small>
                        </label>
                        
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label">Periodicidade</label>
                        <div class="col-sm-6">
                            <select class="form-control" ng-model="contrato.periodo" req required ng-change="processaQtdParcelas()" name="contrato[periodo]">
                                <option ng-repeat="periodo in periodos" value="{{periodo.id}}" ng-disabled="periodo.id > max_periodo">{{periodo.descricao}}</option>
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="contrato.qtd_parcelas">Qtd. Parcelas </label>
                        <div class="col-sm-6">
                            <select class="form-control" name="contrato[parcelas]" id="parcelas" ng-model="contrato.parcelas" required req ng-options="parcela.qtd as parcela.qtd for parcela in parcelas"></select>
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-5 control-label" for="contrato[primeiro_vencimento]">1º Vencimento</label>
                        <div class="col-sm-6">
                            <div class="input-group date">
                                <input type="text" ng-model="contrato.primeiro_vencimento" value="" id="contrato[primeiro_vencimento]" name="contrato[primeiro_vencimento]" class="form-control" req required ng-blur="geraParcelas()">
                                <span class="add-on input-group-btn"><button tabindex="2" type="button" class="btn btn-default"><i title="Calendário" class="fa fa-calendar"></i></button></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-24" style="margin-bottom:20px;" ng-show="parcelas_geradas.length > 0">
                        <table class="table table-bordered  table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Parcela</th>
                                    <th>Vencimento</th>
                                    <th>Valor R$</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>001</td>
                                    <td><a href="#" ng-click="abaEntradaNext(contrato.entrada_config.entradas.length > 0 ? 2 : 1)">Entrada</a></td>
                                    <td>-</td>
                                    <td>{{entrada}}</td>
                                </tr>
                                <tr ng-repeat="p in parcelas_geradas">
                                    <td>{{p.num}}</td>
                                    <td>{{p.parcela}}</td>
                                    <td>{{p.vencimento}}</td>
                                    <td>{{p.valor}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>

                </div>
                <!-- Fim aba 5 -->

                <div class="clearfix"></div>


            </div>

            <div class="modal-footer" ng-show="aba == 5">
                <a href="javascript://" style="margin-top:8px;" class="pull-left" ng-click="abaNext(6)">Voltar</a>
                <button class="btn btn-primary" type="button" ng-disabled="false" ng-click="salveGeral()">Salvar</button>
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </form>
</div>

<!-- Modal -->
<div role="dialog" id="contrato_entrada_modal" class="modal fade in" aria-hidden="false"><!-- Modal -->
    <form autocomplete="off" name="ContratoEntradaForm" id="ContratoEntradaForm" class="form-horizontal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Inclusão de Entrada</h3>
                <span>Formulário de Cadastro</span>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            </div>
            <div class="modal-body">

                <!-- Aba 3 -->
                <div ng-show="aba_entrada == 1" id="aba-3" style="margin-top:10px">

                    <div class="form-group">
                        <label class="col-sm-7 control-label" for="valor">Meio de Pagamento </label>
                        <div class="col-sm-15">
                            <select name="contrato[entrada_config][meio_pagamento_id]" id="meio_pagamento_id" ng-model="contrato.entrada_config.meio_pagamento_id" class="form-control" ng-change="entradaMeioPagamento()" req required>
                                <option value="1">Dinherio</option>
                                <option value="2">Cheque</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" ng-show="contrato.entrada_config.meio_pagamento_id == 2">
                        <label class="col-sm-7 control-label" for="meio_forma_id">Forma </label>
                        <div class="col-sm-9">
                            <select name="contrato[entrada_config][meio_forma_id]" id="meio_forma_id" ng-model="contrato.entrada_config.meio_forma_id" class="form-control" ng-required="contrato.entrada_config.meio_pagamento_id == 2" req required>
                                <option value="1">À Vista</option>
                                <option value="2">À Prazo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" ng-show="contrato.entrada_config.meio_pagamento_id == 2 && contrato.entrada_config.meio_forma_id == 2">
                        <label class="col-sm-7 control-label" for="contrato[entrada_config][qtd_parcelas">Qtd. Parcelas</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" ng-model="contrato.entrada_config.qtd_parcelas" name="contrato[entrada_config][qtd_parcelas]" id="qtd_parcelas" ng-required="contrato.entrada_config.meio_pagamento_id == 2 && contrato.entrada_config.meio_forma_id == 2" req required ng-only-numbers="">
                        </div>
                    </div>

                    <div class="form-group" ng-show="contrato.entrada_config.meio_pagamento_id == 2">
                        <label class="col-sm-7 control-label" for="meio_forma_id">{{ contrato.entrada_config.meio_forma_id == 1 ? 'Número do Cheque' : 'Número 1º Cheque' }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" ng-model="contrato.entrada_config.numero_cheque" name="contrato[entrada_config][numero_cheque]" id="numero_cheque" ng-required="contrato.entrada_config.meio_pagamento_id == 2" req required>
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom" ng-show="contrato.entrada_config.meio_pagamento_id == 2">
                        <label class="col-sm-7 control-label" for="cheque_vencimento">{{ contrato.entrada_config.meio_forma_id == 1 ? 'Vencimento' : 'Vencimento 1º Cheque' }}</label>
                        <div class="col-sm-9">
                            <div class="input-group date">
                                <input type="text" ng-model="contrato.entrada_config.cheque_vencimento" value="" id="cheque_vencimento" name="contrato[entrada_config][cheque_vencimento]" class="form-control" ng-required="contrato.entrada_config.meio_pagamento_id == 2" req required>
                                <span class="add-on input-group-btn"><button tabindex="2" type="button" class="btn btn-default"><i title="Calendário" class="fa fa-calendar"></i></button></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" ng-show="contrato.entrada_config.meio_pagamento_id == 2 && contrato.entrada_config.meio_forma_id == 2">
                        <label class="col-sm-7 control-label" for="meio_forma_id">Periodicidade</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" ng-model="contrato.entrada_config.periodicidade" name="contrato[entrada_config][periodicidade]" id="periodicidade" ng-required="contrato.entrada_config.meio_pagamento_id == 2 && contrato.entrada_config.meio_forma_id == 2" req required ng-only-numbers="">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:0px;">
                        <label class="col-sm-7 control-label" for="contrato.entrada_config.valor">{{ contrato.entrada_config.meio_forma_id == 1 ? 'Valor' : 'Valor Parcelamento' }}</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="contrato[entrada_config][valor]" id="contrato_entrada_config_valor" class="form-control mask-money" ng-model="contrato.entrada_config.valor" ng-money ng-required="true" ng-keyup="gerarEntradasCheque()" req required>
                            </div>
                        </div>
                    </div>

                    <div ng-hide="contrato.entrada_config.parcelas.length > 0" style="height:15px;"></div>

                    <div class="row" ng-show="contrato.entrada_config.parcelas.length > 0" style="margin-bottom:25px;">
                        <hr style="margin-top: 10px;">
                        <table class="table  table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Linha</th>
                                    <th>Número</th>
                                    <th>Vencimeto</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="parcela in contrato.entrada_config.parcelas">
                                    <td>{{ parcela.linha }}</td>
                                    <td>{{ parcela.numero }}</td>
                                    <td>{{ parcela.vencimento }}</td>
                                    <td>{{ parcela.valor }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer" style="width:107.2%; margin-left:-20px; margin-bottom:-5px;">
                        <button class="btn btn-primary" ng-click="addEntrada()" type="button">Salvar</button>
                        <button class="btn btn-default" type="button" ng-click="abaEntradaNext(2)">Cancelar</button>
                    </div>

                </div>
                <!-- Fim aba 3 -->


                <div class="clearfix"></div>

                <!-- Aba 4 -->
                <div ng-show="aba_entrada == 2">

                    <div class="alert alert-info alert-white rounded">
                        <div class="icon"><i class="fa fa-info-circle"></i></div>
                        Valor da entrada R$ {{entrada}}.
                    </div>

                    <div style="height:37px;">
                        <div class="btn-group" id="buttons-grid">
                            <button type="button" class="btn btn-default" ng-click="abaEntradaNext(1)" ng-disabled="contrato.entrada_config.total ==  entrada_float"> Novo</button>
                            <button type="button" class="btn btn-default" ng-click="entradaRemove()"> Excluir</button>
                        </div>
                    </div>
                    
                    <table class="table  table-bordered table-hover" ng-show="contrato.entrada_config.entradas.length > 0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="entrada.checkall" ng-model="entrada_checkall"></th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Conta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="entrada in contrato.entrada_config.entradas">
                                <td><input type="checkbox" ng-model="confirmedEntrada" ng-checked="entrada_checkall" ng-change="checkAllEntrada($index)"></td>
                                <td>{{ entrada.tipo == 1 ? 'Dinherio' : 'Cheque' }}</td>
                                <td>{{ entrada.valor }}</td>
                                <td>Carteira</td>
                            </tr>
                            <tr>
                                <td colspan="2">Total</td>
                                <td>{{ contrato.entrada_config.total_formatado }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <br/>
                    

                    <div class="modal-footer" style="width:107.2%; margin-left:-20px; margin-bottom:-5px;">
                        <button class="btn btn-primary" type="button" ng-click="abaEntradaNext('close')">Salvar</button>
                        <button class="btn btn-default" type="button" ng-click="abaEntradaNext('clear')">Cancelar</button>
                    </div>
                </div>
                <!-- Fim aba 4 -->

            </div>
        </div>
    </div>
    </form>
</div>

<!-- Modal -->
<div role="dialog" id="contrato_pesquisa_modal" class="modal fade in" aria-hidden="false"><!-- Modal -->
    <form autocomplete="off" name="ContratoPesquisaForm" id="ContratoPesquisaForm" class="form-horizontal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Contrato</h3>
                <span>Formulário de Pesquisa</span>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">


                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="nome">Nº do Contrato</label>
                        <div class="col-sm-7">
                            <input type="text" name="search[numero_contrato]" ng-model="pesquisa.numero_contrato" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="search[dt_inicio]" class="col-sm-6 control-label">Emissão</label>

                            <div class="col-sm-7">
                                <div class="col-sm-24 input-group datepicker date no-margin-bottom">
                                    <input type="text" onkeydown="mascara(this, mdata)" maxlength="10" name="search[dt_inicio]" class="data_inicio text-left form-control" ng-model="pesquisa.emissao_inicio">
                                    <span class="add-on input-group-btn">
                                        <button type="button" class="btn btn-default">
                                            <i title="Calendário" class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <label for="search[dt_fim]" class="col-sm-2 control-label" style="margin-right: 16px; text-indent: -5px;">até</label>
                                <div class="col-sm-20">
                                    <div class="col-sm-24 input-group datepicker date no-margin-bottom">
                                        <input type="text" onkeydown="mascara(this, mdata)" maxlength="10" name="search[dt_fim]" class="data_fim text-left form-control" ng-model="pesquisa.emissao_fim">
                                        <span class="add-on input-group-btn">
                                            <button type="button" class="btn btn-default">
                                                <i title="Calendário" class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>    
                            </div>

                    </div>

                    <div class="form-group">
                        <label for="search[valor_min]" class="col-sm-6 control-label">Valor</label>
                        
                            <div class="col-sm-7">
                                <div class="input-group no-margin-bottom">
                                    <span class="input-group-addon">R$</span>
                                    <input type="text" maxlength="11" name="search[valor_min]" class="text-right form-control maskMoney" value="" ng-money ng-model="pesquisa.valor_inicio">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <label for="search[valor_max]" class="col-sm-2 control-label" style="margin-right: 16px; text-indent: -5px;">até</label>
                                <div class="col-sm-20">
                                    <div class="input-group no-margin-bottom">
                                        <span class="input-group-addon">R$</span>
                                        <input type="text" maxlength="11" name="search[valor_max]" class="text-right form-control maskMoney" value="" ng-money ng-model="pesquisa.valor_fim">
                                    </div>
                                </div>
                            </div>
                     
                    </div>


                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="nome">Empreendimento</label>
                        <div class="col-sm-18">
                            <select name="pesquisa_empreendimento_id" id="pesquisa[empreendimento_id]" ng-model="pesquisa.empreendimento_id" class="form-control" ng-select2>
                                <option value=""></option>
                                <?php foreach ($empreendimentos as $e): ?>
                                    <option value="<?php echo $e->id ?>"><?php echo $e->empreendimento ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Corretor</label>
                        <div class="col-sm-18">
                            <select ng-model="pesquisa.corretor_id" id="pesquisa[corretor_id]" name="pesquisa[corretor_id]" class="form-control" ng-select2>
                                <option value=""></option>
                                <?php foreach ($corretores as $c): ?>
                                    <option value="<?php echo $c->id ?>"><?php echo $c->nome ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label">Cliente</label>
                        <div class="col-sm-18">
                            <select ng-model="pesquisa.cliente_id" id="pesquisa[cliente_id]" name="pesquisa[cliente_id]" class="form-control" ng-select2 req required>
                                <option value=""></option>
                                <?php foreach ($clientes as $c): ?>
                                    <option value="<?php echo $c->id ?>"><?php echo $c->nome ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" type="button" ng-click="start(false, pesquisa)">Pesquisar</button>
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
            </div>
        </div>
    </div>
</form>

</div>