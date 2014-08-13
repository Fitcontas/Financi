<div ng-controller="FormClinteGridCtrl">
<form id="#grid_cliente" class="grid" data-control="Clientes" data-list="dt_cliente(true)">
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
                            <li><a href="/cliente/cadastro/pf" class="no">Cliente PF</a></li>
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
                    <h3>Relação de Clientes</h3>
                </div>
                <div class="content spacer0 process">
                    <div class="toobar">
                        <div class="pull-left">
                        <div class="btn-group pull-left" id="buttons-grid">
                            <div class="btn-group no-margin">    
                                <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle no-margin" action="no"> Novo&nbsp;<span class="caret"></span></button>    
                                <ul role="menu" class="dropdown-menu">    
                                    <li><a href="/cliente/cadastro/pf" class="no">Cliente PF</a></li>    
                                    <li><a href="/cliente/cadastro/pj" class="no">Cliente PJ</a></li>    
                                </ul>
                            </div>
                            <button type="button" class="btn btn-default " action="excluir"> Excluir</button>
                            <button type="button" class="btn btn-default " action="habilitar"> Habilitar</button>
                            <button type="button" class="btn btn-default " action="desabilitar"> Desabilitar</button></div>
                        </div>
                        <div class="pull-right">
                            <div class="input-group">
                              <input class="form-control" type="text" aria-controls="tb_cliente" placeholder="Pesquisar" style="width:250px"  ng-model="search">
                              <span class="input-group-btn">
                                <button class="btn btn-default" type="button" ng-click="start()">Buscar</button>
                              </span>
                            </div>
                            

                        </div>
                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover spacer2" id="tb_cliente">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="checkall" class="checkall"/></label>
                                        </div>
                                    </th>
                                    <th>Nome/Razão Social</th>
                                    <th>CPF/CNPJ</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="c in clientes">
                                    <td><input type="checkbox"></td>
                                    <td><a href="/cliente/edita/pf/{{c.id}}">{{c.nome}}</a></a></td>
                                    <td>{{c.cpf}}</td>
                                    <td>{{c.status == 1 ? 'Ativo' : 'Desabilitado'}}</td>
                                </tr>
                            </tbody>
                        </table>                            
                    </div>
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
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="cliente_modal"   role="dialog"></div>
</div>