<div ng-controller="FormLoteCtrl" ng-cloak>
<form id="#grid_lote" class="grid">
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

            <div class="block-flat" ng-show="!model.lotes.length && model.$resolved && search.length == 0">
                <div class="header">
                    <h3>Lotes</h3>
                </div>

                <div class="content spacer0 process">
                    <p>Até o momento não existe nenhum lote cadastro. Para inserir um novo registro clique no botão adicionar.</p>
                    <p><button type="button" class="btn btn-default" ng-click="showForm(false)" style="margin:5px 0 0 0 !important">Adicionar</button></p>
                </div>
            </div>

            <div class="block-flat" ng-show="(model.lotes.length && model.$resolved) || model.busca">
                <div class="header">
                    <h3>Relação de Lotes</h3>
                </div>

                <div class="content spacer0 process">
                    <div class="toobar">
                        <div class="pull-left">
                            <div class="btn-group pull-left" id="buttons-grid">
                                <button type="button" class="btn btn-default" ng-click="imprimir()"> Imprimir</button>
                                <button type="button" class="btn btn-default" ng-click="pesquisa()"> Pesquisa</button>
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
                    <div class="table-responsive" ng-show="model.lotes.length>0">
                        <table class="table  table-bordered spacer2 table-hover">
                            <thead>
                                <tr>
                                    <th class="checkbox-control">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="checkall" ng-model="checkall" ng-check-all-test></label>
                                        </div>
                                    </th>
                                    <th class="sorting" data-column="lote.numero" data-sort="asc" ng-sort="">Lote</th>
                                    <th class="sorting" data-column="lote.quadra" data-sort="asc" ng-sort="">Quadra</th>
                                    <th class="sorting" data-column="empreendimento.empreendimento" data-sort="asc" ng-sort="">Empreendimento</th>
                                    <th class="sorting text-right" data-column="lote.valor" data-sort="asc" ng-sort="">Valor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th class="sorting" data-column="lote.area_total" data-sort="asc" ng-sort="">Área Total <small>(m²)</small></th>
                                    <th>Tipo</th>
                                    <th class="sorting" data-column="lote.situacao" data-sort="asc" ng-sort="">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="l in model.lotes">
                                    <td><input type="checkbox" ng-model="confirmed" ng-change="checkAll(l)" ng-checked="checkall" ng-check-test></td>
                                    <td width="8%">{{l.numero}}</td>
                                    <td width="8%">{{l.quadra}}</td>
                                    <td>{{l.empreendimento}}</td>
                                    <td width="10%" class="text-right">{{l.valor}}</td>
                                    <td width="12%">{{l.area_total}}</td>
                                    <td width="10%">{{ l.tipo == 1 ? 'Residencial' : 'Comercial' }}</td>
                                    <td width="10%">{{ l.situacao == null ? 'Disponível' : status[l.situacao] }}</td>
                                </tr>
                            </tbody>
                        </table>  

                        <!-- início da paginação -->
                        <div class="row-fluid" ng-show="paginas.length>1">
                          <div class="span12">
                             <div>
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
                    <div class="table-responsive" ng-show="!model.lotes.length && model.$resolved && model.busca">
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


</div>