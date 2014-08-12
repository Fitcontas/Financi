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
                    <h3>Relação de Clientes</h3>
                </div>
                <div class="content spacer0 process">
                    <div class="toobar">
                        <div class="pull-left">
                        <div class="btn-group pull-left" id="buttons-grid">
                            <button type="button" class="btn btn-default" ng-click="showForm(false)"> Novo</button>
                            <button type="button" class="btn btn-default " action="excluir"> Excluir</button>
                            <button type="button" class="btn btn-default " action="habilitar"> Habilitar</button>
                            <button type="button" class="btn btn-default " action="desabilitar"> Desabilitar</button></div>
                        </div>
                        <div class="pull-right">
                            <input class="form-control" type="text" aria-controls="tb_usuario" placeholder="Pesquisar" style="width:250px">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered spacer2 table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="checkall" class="checkall"/></label>
                                        </div>
                                    </th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="u in usuarios">
                                    <td><input type="checkbox" value="<?php echo $c->id ?>" name="check[]"></td>
                                    <td><a ng-click="showForm(u)">{{u.nome}}</a></td>
                                    <td>{{u.email}}</td>
                                    <td>{{u.grupo}}</td>
                                </tr>
                            </tbody>
                        </table>              
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div role="dialog" id="usuario_modal" class="modal fade in" aria-hidden="false"><!-- Modal -->
    <form autocomplete="off" name="UsuarioForm" id="UsuarioForm" class="form-horizontal" novalidate>
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
                    <label class="col-sm-6 control-label" for="id_grupo_usuarios">Tipo </label>
                    <div class="col-sm-14">
                        <select class="form-control" req="" id="grupo_id" name="grupo_id" ng-model="usuario.grupo_id" required>
                            <option value=""></option>
                                <option value="1">Administrador</option>
                            </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="nome">Nome  </label>
                    <div class="col-sm-18">
                        <input type="text" value="" name="nome" req="" class="form-control" ng-model="usuario.nome" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="nome">Apelido  </label>
                    <div class="col-sm-12">
                        <input type="text" value="" name="apelido" req="" class="form-control" ng-model="usuario.apelido" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="login">Login </label>
                    <div class="col-sm-12">
                        <input type="text" value="" maxlength="150" req="" name="usuario" class="form-control" ng-model="usuario.usuario" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="email">E-mail </label>
                    <div class="col-sm-14">
                        <input type="text" value="" maxlength="150" placeholder="E-mail" req="" name="email" class="email form-control smail" ng-model="usuario.email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="email">Repita o e-mail </label>
                    <div class="col-sm-14">
                        <input type="text" value="" maxlength="150" placeholder="E-mail" req="" name="email2" class="email form-control smail" ng-model="usuario.email2" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-6 control-label" for="senha">Senha </label>
                    <div class="col-sm-10">
                        <input type="password" maxlength="150" req="" minlength="6" name="senha" id="senha" class="form-control" value="" ng-model="usuario.senha" ng-non-bindable>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="senha2">Confirme a Senha </label>
                    <div class="col-sm-10">
                        <input type="password" maxlength="150" req="" minlength="6" name="senha2" id="senha2" class="form-control" value="" ng-model="usuario.senha2" ng-non-bindable>
                    </div>
                </div>

                <div class="form-group obs">
                    Obs.:
                    O sistema solicitará a alteração de senha no primeiro acesso.
                </div>
                
                <input type="hidden" value="Usuario" name="controle">
                <input type="hidden" value="manter" name="acao">
                                <input type="hidden" value="" name="id_usuario">
                <input type="hidden" value="" name="id">
                    
            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-primary" ng-click="salvar(usuario)">Salvar</button>
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="#" data-action="modal-add">Salvar e Adicionar novo</a></li>
                    </ul>
                </div>
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </form>
</div>
</div>