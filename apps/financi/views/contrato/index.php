<div ng-controller="ContratoCtrl">
<?php echo sha1('123456'); ?>
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
            <div class="block-flat">
                <div class="header">
                    <h3>Relação de Contratos</h3>
                </div>
                <div class="content spacer0 process">
                    <div class="toobar">
                        <div class="pull-left">
                            <default:actions:buttons/>
                        </div>
                        <div class="pull-right">
                            <div class="input-group">
                              <input class="form-control" type="text" placeholder="Pesquisar" ng-model="search" ng-enter="start()">
                              <span class="input-group-btn">
                                <button class="btn btn-default btn-sm" type="button" ng-click="start()"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <!-- Início data table content -->
                    <div class="table-responsive" ng-show="model.contratos.length>0">
                        <table class="table table-striped table-bordered spacer2 table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="checkall" ng-model="checkall"></label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="u in model.contratos">
                                    <td><input type="checkbox" ng-model="confirmed" ng-change="checkAll(u)" ng-checked="checkall" x-ng-click="{cursor:pointer}"/></td>
                                   
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
                    <div class="table-responsive" ng-show="!model.contratos.length && model.$resolved">
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

                <!-- Aba 1 -->
                <div ng-show="aba == 1">

                    <div class="header">
                        <h4>Cadastro de Contrato</h4>
                    </div>
                    <hr>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-6 control-label" for="contrato[emissao]">Emissão</label>
                        <div class="col-sm-9">
                            <div class="input-group date">
                                <input type="text" ng-model="contrato.emissao" value="" id="contrato[emissao]" name="emissao" class="form-control" req required>
                                <span class="add-on input-group-btn"><button tabindex="2" type="button" class="btn btn-default"><i title="Calendário" class="fa fa-calendar"></i></button></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="nome">Empreendimento  </label>
                        <div class="col-sm-18">
                            <select name="empreendimento_id" id="contrato[empreendimento_id]" ng-model="contrato.empreendimento_id" class="form-control" ng-change="getLotes(contrato.empreendimento_id)" req required>
                                <option value=""></option>
                                <?php foreach ($empreendimentos as $e): ?>
                                    <option value="<?php echo $e->id ?>"><?php echo $e->empreendimento ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="contrato[lote_id]">Lote  </label>
                        <div class="col-sm-18">
                            <select name="contrato[lote_id]" id="contrato[lote_id]" ng-model="contrato.lote_id" class="form-control" ng-options="lote.id as 'Lote ' + lote.numero + ' - Quadra ' + lote.quadra for lote in lotes" ng-change="setLote()" ng-money>
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="contrato[area_total]">Área Total </label>
                        <div class="col-sm-9">
                            <input type="text" name="contrato[area_total]" class="form-control" required data-ng-model="contrato.area_total" ng-disabled="true" ng-money>
                        </div>
                        <div class="col-sm-1">
                            m²
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="contrato[valor]">Valor </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="contrato[valor]" class="form-control" required ng-model="contrato.valor" ng-disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="header">
                        <h4>Corretor(es)</h4>
                    </div>
                    <hr>
                    
                    <!-- Corretores -->
                    <div class="form-group no-margin-bottom" ng-repeat="corretor in contrato.corretores">
                        <label class="col-sm-6 control-label" for="">Nome</label>
                        <div class="col-sm-11">
                            <div class="input-group">


                                <select ng-model="contrato.corretores[$index].corretor_id" id="contrato[corretores][$index][corretor_id]" name="contrato[corretores][$index][corretor_id]" class="form-control" ng-select2 req required>
                                    <option value=""></option>
                                    <?php foreach ($corretores as $c): ?>
                                        <option value="<?php echo $c->id ?>"><?php echo $c->nome ?></option>
                                    <?php endforeach ?>
                                </select>
                                
                                <span class="add-on input-group-btn"><button tabindex="2" type="button" class="btn btn-default"><i title="Calendário" class="fa fa-plus"></i></button></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" class="form-control" req required ng-model="contrato.corretores[$index].comissao" name="comissao" ng-money="" maxlength="6">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button tabindex="2" type="button" class="btn btn-default btn-sm" ng-click="removeCorretor($index)"><i class="fa fa-trash-o"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <button tabindex="2" type="button" class="btn btn-default btn-sm" ng-click="addCorretor()">Adicionar</button>
                        </div>
                    </div>

                    <div class="header">
                        <h4>Comprador(es)</h4>
                    </div>

                     <!-- Compradores -->
                    <div class="form-group no-margin-bottom" ng-repeat="cliente in contrato.clientes">
                        <label class="col-sm-6 control-label" for="">Nome</label>
                        <div class="col-sm-11">
                            <div class="input-group">
                                
                                <select ng-model="contrato.clientes[$index].cliente_id" id="contrato[clientes][$index][cliente_id]" name="contrato[clientes][$index][cliente_id]" class="form-control" ng-select2 req required>
                                    <option value=""></option>
                                    <?php foreach ($clientes as $c): ?>
                                        <option value="<?php echo $c->id ?>"><?php echo $c->nome ?></option>
                                    <?php endforeach ?>
                                </select>
                                
                                <span class="add-on input-group-btn"><button tabindex="2" type="button" class="btn btn-default"><i title="Calendário" class="fa fa-plus"></i></button></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" class="form-control" req required ng-model="contrato.clientes[$index].porcentagem" name="porcentagem" ng-money="" maxlength="6">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button tabindex="2" type="button" class="btn btn-default btn-sm" ng-click="removeCliente($index)"><i class="fa fa-trash-o"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <button tabindex="2" type="button" class="btn btn-default btn-sm" ng-click="addCliente()">Adicionar</button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" ng-disabled="ContratoForm.emissao.$invalid || ContratoForm.empreendimento_id.$invalid || ContratoForm.lote_id.$invalid || ContratoForm.corretor_id.$invalid || ContratoForm.cliente_id.$invalid || ContratoForm.comissao.$invalid || ContratoForm.porcentagem.$invalid" ng-click="abaNext(2)">Avançar</button>
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                    </div>

                </div>
                <!-- Fim aba 1 -->

                <!-- Aba 2 -->
                <div ng-show="aba == 2">

                    <div class="header">
                        <h4>Cadastro de Contrato</h4>
                    </div>
                    <hr>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-6 control-label" for="valor">Valor </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="text" class="form-control mask-money" required ng-model="contrato.valor" ng-disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-6 control-label" for="desconto">Desconto </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                
                                <input type="text" name="contrato[desconto]" class="form-control mask-money" required ng-model="contrato.desconto" ng-money ng-keyup="calcValorContrato(this)">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-6 control-label" for="valor_contrato">Valor do Contrato </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="text" class="form-control mask-money" required ng-model="contrato.valor_contrato" ng-disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-6 control-label" for="contrato.entrada">Entrada </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                
                                <input type="text" name="contrato[entrada]" class="form-control mask-money" required ng-model="contrato.entrada" ng-money ng-blur="validaEntrada()">
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            Entrada Mínima de {{min_entrada}}%
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-6 control-label" for="contrato.intermediarias">Intermediarias </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" name="contrato[intermediarias]" class="form-control mask-money" required ng-model="contrato.intermediarias" ng-money ng-blur="validaIntermediarias()">

                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <select class="form-control" ng-model="contrato.periodo" req required ng-change="processaQtdParcelas()">
                                <option ng-repeat="periodo in periodos" value="{{periodo.id}}" ng-disabled="periodo.id > max_periodo">{{periodo.descricao}}</option>
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="contrato.qtd_parcelas">Qtd. Parcelas </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="contrato[parcelas]" id="parcelas" ng-model="contrato.parcelas" required req ng-options="parcela.qtd as parcela.qtd for parcela in parcelas"></select>
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom">
                        <label class="col-sm-6 control-label" for="contrato[primeiro_vencimento]">1º Vencimento</label>
                        <div class="col-sm-9">
                            <div class="input-group date">
                                <input type="text" ng-model="contrato.primeiro_vencimento" value="" id="contrato[primeiro_vencimento]" name="contrato[primeiro_vencimento]" class="form-control" req required ng-blur="geraParcelas()">
                                <span class="add-on input-group-btn"><button tabindex="2" type="button" class="btn btn-default"><i title="Calendário" class="fa fa-calendar"></i></button></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-24">
                        <table class="table table-bordered table-striped table-hover" ng-show="parcelas_geradas.length > 0">
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
                                    <td><a href="#" ng-click="abaNext(3)">Entrada</a></td>
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
                <!-- Fim aba 2 -->

                <!-- Aba 3 -->
                <div ng-show="aba == 3">

                    <div class="header">
                        <h4>Entrada</h4>
                    </div>
                    <hr>

                    <div class="form-group">
                        <label class="col-sm-7 control-label" for="valor">Meio de Pagamento </label>
                        <div class="col-sm-15">
                            <select name="contrato[entrada_config][meio_pagamento_id]" id="meio_pagamento_id" ng-model="contrato.entrada_config.meio_pagamento_id" class="form-control" ng-change="entradaMeioPagamento()">
                                <option value="1">Dinherio</option>
                                <option value="2">Cheque</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" ng-show="contrato.entrada_config.meio_pagamento_id == 2">
                        <label class="col-sm-7 control-label" for="meio_forma_id">Forma </label>
                        <div class="col-sm-9">
                            <select name="contrato[entrada_config][meio_forma_id]" id="meio_forma_id" ng-model="contrato.entrada_config.meio_forma_id" class="form-control" ng-required="contrato.entrada_config.meio_pagamento_id == 2">
                                <option value="1">À Vista</option>
                                <option value="2">À Prazo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" ng-show="contrato.entrada_config.meio_pagamento_id == 2 && contrato.entrada_config.meio_forma_id == 2">
                        <label class="col-sm-7 control-label" for="contrato[entrada_config][qtd_parcelas">Qtd. Parcelas</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" ng-model="contrato.entrada_config.qtd_parcelas" name="contrato[entrada_config][qtd_parcelas]" id="qtd_parcelas" ng-required="contrato.entrada_config.meio_pagamento_id == 2 && contrato.entrada_config.meio_forma_id == 2">
                        </div>
                    </div>

                    <div class="form-group" ng-show="contrato.entrada_config.meio_pagamento_id == 2">
                        <label class="col-sm-7 control-label" for="meio_forma_id">{{ contrato.entrada_config.meio_forma_id == 1 ? 'Número do Cheque' : 'Número 1º Cheque' }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" ng-model="contrato.entrada_config.numero_cheque" name="contrato[entrada_config][numero_cheque]" id="numero_cheque" ng-required="contrato.entrada_config.meio_pagamento_id == 2">
                        </div>
                    </div>

                    <div class="form-group no-margin-bottom" ng-show="contrato.entrada_config.meio_pagamento_id == 2">
                        <label class="col-sm-7 control-label" for="cheque_vencimento">{{ contrato.entrada_config.meio_forma_id == 1 ? 'Vencimento' : 'Vencimento 1º Cheque' }}</label>
                        <div class="col-sm-9">
                            <div class="input-group date">
                                <input type="text" ng-model="contrato.entrada_config.cheque_vencimento" value="" id="cheque_vencimento" name="contrato[entrada_config][cheque_vencimento]" class="form-control" ng-required="contrato.entrada_config.meio_pagamento_id == 2">
                                <span class="add-on input-group-btn"><button tabindex="2" type="button" class="btn btn-default"><i title="Calendário" class="fa fa-calendar"></i></button></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" ng-show="contrato.entrada_config.meio_pagamento_id == 2 && contrato.entrada_config.meio_forma_id == 2">
                        <label class="col-sm-7 control-label" for="meio_forma_id">Periodicidade</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" ng-model="contrato.entrada_config.periodicidade" name="contrato[entrada_config][periodicidade]" id="periodicidade" ng-required="contrato.entrada_config.meio_pagamento_id == 2 && contrato.entrada_config.meio_forma_id == 2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-7 control-label" for="contrato.entrada_config.valor">{{ contrato.entrada_config.meio_forma_id == 1 ? 'Valor' : 'Valor Parcelamento' }}</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="contrato[entrada_config][valor]" id="contrato_entrada_config_valor" class="form-control mask-money" ng-model="contrato.entrada_config.valor" ng-money ng-required="true" ng-keyup="gerarEntradasCheque()">
                            </div>
                        </div>
                    </div>

                    <div class="row" ng-show="contrato.entrada_config.parcelas.length > 0">
                        <hr>
                        <table class="table table-striped table-bordered table-hover">
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

                    <div class="modal-footer">
                        <button class="btn btn-primary" ng-disabled="ContratoForm.$invalid" ng-click="addEntrada()">Salvar</button>
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                    </div>

                </div>
                <!-- Fim aba 3 -->
                <div class="clearfix"></div>

                <!-- Aba 4 -->
                <div ng-show="aba == 4">

                    <div class="header">
                        <h4>Entrada</h4>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="btn-group" id="buttons-grid">
                            <button type="button" class="btn btn-default" ng-click="abaNext(3)"> Novo</button>
                            <button type="button" class="btn btn-default" ng-disabled=""> Excluir</button>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox"></th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Conta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="entrada in contrato.entrada_config.entradas">
                                <td><input type="checkbox"></td>
                                <td>{{ entrada.tipo == 1 ? 'Dinherio' : 'Cheque' }}</td>
                                <td>{{ entrada.valor }}</td>
                                <td>Carteira</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Fim aba 4 -->
                <div class="clearfix"></div>


            </div>

            <div class="modal-footer" ng-show="aba == 2">
                <button class="btn btn-primary" ng-disabled="ContratoForm.$invalid" ng-click="abaNext()">Salvar</button>
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </form>
</div>
</div>