<!-- Modal -->
<div role="dialog" id="minha_conta_modal" class="modal fade in" aria-hidden="false">
    <form autocomplete="off" name="MinhaContaForm" id="MinhaContaForm" class="form-horizontal">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h3>Minha Conta</h3>
	                <span>Formulário de Cadastro</span>
	                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	            </div>
	            <div class="modal-body">
	                <div class="mensagem-modal">
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-6 control-label" for="nome">Nome  </label>
	                    <div class="col-sm-18">
	                        <input type="text" value="" name="nome" req="" class="form-control" ng-model="usuario.nome" disabled>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-6 control-label" for="nome">Apelido  </label>
	                    <div class="col-sm-18">
	                        <input type="text" value="" name="apelido" req class="form-control" ng-model="usuario.apelido" required>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-6 control-label" for="email">E-mail </label>
	                    <div class="col-sm-14">
	                        <input type="email" value="" maxlength="150" req name="email" id="email" class="form-control" required data-ng-model="usuario.email">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-6 control-label" for="email">Confirme o E-mail </label>
	                    <div class="col-sm-14">
	                        <input type="email" value="" maxlength="150" req="" name="email2" id="email2" class="form-control" ng-model="usuario.email2" required>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-6 control-label" for="senha">Senha Atual </label>
	                    <div class="col-sm-14">
	                        <input type="password" ng-minlength="6" ng-maxlength="15" name="senha_atual" id="minha_conta_senha_atual" class="form-control" data-ng-model="usuario.senha_atual">
	                    </div>
	                </div>
	                
	                <div class="form-group">
	                    <label class="col-sm-6 control-label" for="senha">Nova Senha </label>
	                    <div class="col-sm-14">
	                        <input type="password" ng-minlength="6" ng-maxlength="15" name="senha" id="minha_conta_senha" class="form-control" value="" data-ng-model="usuario.senha">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-sm-6 control-label" for="senha2">Confirme a Senha </label>
	                    <div class="col-sm-14">
	                        <input type="password" ng-minlength="6" ng-maxlength="15" name="senha2" id="minha_conta_senha2" class="form-control" value="" ng-model="usuario.senha2" data-password-verify="usuario.senha">
	                    </div>
	                </div>

	            </div>

	            <div class="modal-footer">
	                
	                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
	                <div class="btn-group">
	                    <button class="btn btn-primary" ng-click="salvar(usuario)" type="button">Salvar</button>
	                </div>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
    </form>
</div>