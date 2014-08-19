<div ng-controller="FormCorretorGridCtrl">
<form id="#grid_corretor" class="grid">
    <div class="row margin-top-50">
        <div id="no-reg" class="content" style="display: none">
            <div class="container">
                <h5>No momento não existe nenhum registro cadastrado. <?php echo true ? 'Para inserir um novo clique em “Adicionar”.' : '' ?></h5>
                <div class="table-responsive hide">
                    <div class="btn-group">
                        <button class="btn btn-default dropdown-toggle no-margin" data-toggle="dropdown" type="button">
                            Adicionar &nbsp; <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="?controle=Clientes&acao=manter&tipo=PF" class="pointer"> Cliente PF </a></li>
                            <li><a href="?controle=Clientes&acao=manter&tipo=PJ" class="pointer"> Cliente PJ </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="si-reg" class="content" style="display: block">
            <div class="mensagem">
                <!-- Conteúdo da mensagem -->
            </div>
            <div class="block-flat">
                <div class="header">
                    <h3>Relação de Corretores</h3>
                </div>
                <div class="content spacer0 process">
                    <div class="toobar">
                        <div class="pull-left">
                            <default:actions:buttons/>
                        </div>
                       <div class="pull-right">
                            <div class="input-group">
                              <input class="form-control" type="text" placeholder="Pesquisar" style="width:250px"  ng-model="search">
                              <span class="input-group-btn">
                                <button class="btn btn-default btn-sm" type="button" ng-click="start()"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="table-responsive" ng-show="model.corretores.length>0">
                        <table class="table table-striped table-bordered table-hover spacer2" id="tb_corretor">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="checkall" ng-model="checkall"></label>
                                        </div>
                                    </th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Telefones</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="c in model.corretores">
                                    <td><input type="checkbox" ng-model="confirmed" ng-change="checkAll(c)" ng-checked="checkall"></td>
                                    <td><a href="/corretor/edita/{{c.id}}">{{c.nome}}</a></a></td>
                                    <td>{{ c.cpf }}</td>
                                    <td>
                                        <span ng-repeat="telefone in c.telefones">
                                            <i class="fa {{ telefone.tipo == 1 ? 'fa-mobile-phone' : 'fa-phone-square' }}"></i> {{ telefone.ddd }} {{ telefone.numero }}
                                        </span>
                                    </td>
                                    <td>{{c.status == 1 ? 'Ativo' : 'Desabilitado'}}</td>
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

                    <!-- Início da mensagem caso não haja registro -->
                    <div class="table-responsive" ng-show="!model.corretores.length && model.$resolved">
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
<div class="modal fade" id="corretor_modal"   role="dialog"></div>
</div>