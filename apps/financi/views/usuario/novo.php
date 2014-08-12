<form autocomplete="off" data-list="dt_usuario(true)" id="ajaxform" name="ajaxform" role="form" class="form-horizontal">
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
                        <input type="text" value="" name="name" req="" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="login">Login </label>
                    <div class="col-sm-18">
                        <input type="text" value="" maxlength="150" req="" name="login" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-6 control-label" for="senha">Senha </label>
                    <div class="col-sm-10">
                        <input type="password" maxlength="150" req="" minlength="6" name="password" class="form-control" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="senha2">Confirme a Senha </label>
                    <div class="col-sm-10">
                        <input type="password" maxlength="150" req="" minlength="6" name="confirm_password" class="form-control" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="id_grupo_usuarios">grupo </label>
                    <div class="col-sm-14">
                        <select class="form-control" req="" id="id_grupo_usuarios" name="user_group_id">
                            <option value=""></option>
                                <option value="1">Administrador</option>
                            </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label" for="email">E-mail </label>
                    <div class="col-sm-14">
                        <input type="text" value="" maxlength="150" placeholder="E-mail" req="" name="email" class="email form-control smail">
                    </div>
                </div>

                                <div class="form-group obs">
                    <input type="checkbox" checked="checked" value="1" id="change_password" name="change_password">
                    Solicitar alteração de senha no primeiro acesso.
                </div>
                
                <input type="hidden" value="Usuario" name="controle">
                <input type="hidden" value="manter" name="acao">
                                <input type="hidden" value="" name="id_usuario">
                <input type="hidden" value="" name="id">
                    
            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <button class="btn btn-primary" data-action="modal-save">Salvar</button>
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