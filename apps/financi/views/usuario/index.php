<div ng-controller="FormUsuarioCtrl">
<form id="#grid_usuario" class="grid" data-control="Clientes" data-list="dt_usuario(true)">
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
                    <h3>Relação de Usuários</h3>
                </div>
                <div class="content spacer0 process">
                    <div class="toobar">
                        <div class="pull-left">
                            <default:actions:buttons/>
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
                    <div class="table-responsive" ng-show="model.usuarios.length>0">
                        <table class="table  table-bordered spacer2 table-hover">
                            <thead>
                                <tr>
                                    <th class="checkbox-control">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="checkall" ng-model="checkall" ng-check-all-test></label>
                                        </div>
                                    </th>
                                    <th class="sorting" data-column="nome" data-sort="asc" ng-sort="">Nome</th>
                                    <th width="25%">E-mail</th>
                                    <th width="20%" class="sorting" data-column="grupo" data-sort="asc" ng-sort="">Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="u in model.usuarios" ng-class="u.status == 2 ? 'desabilitado' : 'habilitado'">
                                    <td><input type="checkbox" ng-model="confirmed" ng-change="checkAll(u)" ng-checked="checkall" ng-check-test></td>
                                    <td><a ng-click="showForm(u)">{{u.nome}}</a></td>
                                    <td>{{u.email}}</td>
                                    <td>{{u.grupo}}</td>
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
                    <div class="table-responsive" ng-show="!model.usuarios.length && model.$resolved">
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
<div role="dialog" id="usuario_modal" class="modal fade in" aria-hidden="false"><!-- Modal -->
    <form autocomplete="off" name="UsuarioForm" id="UsuarioForm" class="form-horizontal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Usuário</h3>
                <span>Formulário de Cadastro</span>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            </div>
            <div class="modal-body">
                <div class="mensagem-modal">
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="nome">Nome  </label>
                    <div class="col-sm-18">
                        <input type="text" value="" name="nome" req="" class="form-control" ng-model="usuario.nome" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="nome">Apelido  </label>
                    <div class="col-sm-18">
                        <input type="text" value="" name="apelido" req="" class="form-control" ng-model="usuario.apelido" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="email">E-mail </label>
                    <div class="col-sm-14">
                        <input type="email" value="" maxlength="150" req="" name="email" class="form-control" required data-ng-model="usuario.email">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="email">Confirme o E-mail </label>
                    <div class="col-sm-14">
                        <input type="email" value="" maxlength="150" req="" name="email2" class="form-control" ng-model="usuario.email2" required data-password-verify="usuario.email">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-6 control-label" for="senha">Senha </label>
                    <div class="col-sm-14">
                        <input type="password" req ng-minlength="6" ng-maxlength="15" name="senha" id="senha" class="form-control" value="" data-ng-model="usuario.senha">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="senha2">Confirme a Senha </label>
                    <div class="col-sm-14">
                        <input type="password" req ng-minlength="6" ng-maxlength="15" name="senha2" id="senha2" class="form-control" value="" ng-model="usuario.senha2" data-password-verify="usuario.senha">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="id_grupo_usuarios">Grupo </label>
                    <div class="col-sm-14">
                        <select class="form-control" req="" id="grupo_id" name="grupo_id" ng-model="usuario.grupo_id" required ng-options="grupo.id as grupo.descricao for grupo in grupos.grupos">
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label">&nbsp;</label>
                    <div class="col-sm-18">
                        <input type="checkbox" checked="checked" value="1" id="change_password" name="change_password" ng-model="usuario.trocar_senha" ng-checked="usuario.trocar_senha">
                        Solicitar alteração de senha no primeiro acesso.
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-primary" ng-click="salvar(usuario)" type="button">Salvar</button>
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="#" data-action="modal-add" ng-click="salvar(usuario, true)">Salvar e Adicionar novo</a></li>
                    </ul>
                </div>
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </form>
</div>
</div>