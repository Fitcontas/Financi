<!DOCTYPE html>
<html lang="pt_BR" ng-app="Financi">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title><?php echo isset($title) ? $title : 'Untitle' ?></title>
	<?php if(isset($head_css)): ?>
	<?php foreach ($head_css as $key => $value): ?>
		<?php if(is_array($value)): ?>
		<link rel="stylesheet" href="<?php echo HOST . DS . $key ?>" media="<?php $value['media'] ?>">
		<?php else: ?>
		<link rel="stylesheet" href="<?php echo HOST . DS . $value ?>">
		<?php endif; ?>
	<?php endforeach ?>
	<?php endif; ?>

	<?php if(isset($head_js)): ?>
	<?php foreach ($head_js as $js): ?>
		<script type="text/javascript" src="<?php echo HOST . DS . $js ?>"></script>
	<?php endforeach ?>
	<?php endif; ?>
</head>
<body>
	
	<div class="loading">
	    <div class="modal-backdrop fade in"></div>
	    <div id="loader_centro">
	        <div id="loader_logo"></div>
	        <div id="loader_img"></div>
	    </div>
	</div>

	<div class="loading2">
	    <div class="modal-backdrop fade in"></div>
	    <div id="loader_centro">
	        <div id="loader_logo"></div>
	        <div id="loader_img"></div>
	    </div>
	</div>

	<div>

	<div ng-controller="ctrlMinhaConta">
	<!-- Fixed navbar -->
	<div id="head-nav" class="navbar navbar-default navbar-fixed-top">
	    <div class="container main-box">
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	                <span class="fa fa-gear"></span>
	            </button>
	            <a class="navbar-brand" href="#"><span> </span></a>
	        </div>
	        <div class="navbar-collapse collapse">
	            <?php if($user['grupo_id'] == 1): ?>
	            <?php echo \Financi\Menu::render('menunav') ?>
				<?php endif; ?>

	            <ul class="nav navbar-nav navbar-right user-nav">


					<!--<li class="button dropdown">
				        <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;"><i class="fa fa-globe"></i><span class="bubble">2</span></a>
				        <ul class="dropdown-menu">
				          <li>
				            <div class="nano nscroller has-scrollbar">
				              <div class="content" tabindex="0" style="right: -13px;">
				                <ul>
				                  <li><a href="#"><i class="fa fa-building-o info"></i><b>Lote</b> disponível <span class="date">2 minutos atrás.</span></a></li>
				                   <li><a href="#"><i class="fa fa-building-o info"></i><b>Lote</b> disponível <span class="date">3 minutos atrás.</span></a></li>
				                   <li><a href="#"><i class="fa fa-building-o info"></i><b>Lote</b> disponível <span class="date">10 minutos atrás.</span></a></li>
				                   
				                </ul>
				              </div>
				            <div class="pane" style="display: block;"><div class="slider" style="height: 163px; top: 0px;"></div></div></div>
				            <ul class="foot"><li><a href="#">Ver todas as atualizações </a></li></ul>           
				          </li>
				        </ul>
				    </li>-->

	                <li class="dropdown profile_menu">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-top: 15px; padding-bottom: 15px; text-transform: uppercase;"><?php echo $user['apelido'] ?> <b class="caret"></b></a>
	                    <ul class="dropdown-menu">
				            <li><a data-toggle="modal" href="#" ng-click="showForm()"><i class="glyphicon glyphicon-cog"></i>  Minha conta</a></li>
				            <li class="divider"></li>
				            <li><a href="/sair"><i class="glyphicon glyphicon-off"></i>  Sair</a></li>
				        </ul>
	                </li>
	            </ul>
	        </div>

	    </div>

	    <div class="page-head">
	        <div class="container main-box">
	            <ol class="breadcrumb">
	            	<?php if(isset($breadcrumb)): ?>
	            		<?php foreach ($breadcrumb as $b): ?>
	            			<li class="active"><?php echo $b ?></li>
	            		<?php endforeach ?>
	            	<?php else: ?>
                    <li class="active">Cadastro</li>
                    <li class="active">Dev</li>
                	<?php endif ?>
                </ol>
	        </div>
    	</div>
	</div>
	
	<div class="container main-box">
		<?php require_once $content ?>
	</div>

	<!-- Modal -->
	<div role="dialog" id="minha_conta_modal" class="modal fade in" aria-hidden="false"><!-- Modal -->
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
	</div>

	</div>
	<!-- fim ctrlMinhaConta -->

	<div class="new-msg"></div>

	<?php if(isset($foot_css)): ?>
	<?php foreach ($foot_css as $key => $value): ?>
		<?php if(is_array($value)): ?>
		<link rel="stylesheet" href="<?php echo HOST . DS . $key ?>" media="<?php $value['media'] ?>">
		<?php else: ?>
		<link rel="stylesheet" href="<?php echo HOST . DS . $value ?>">
		<?php endif; ?>
	<?php endforeach ?>
	<?php endif; ?>

	<?php if(isset($foot_js)): ?>
	<?php foreach ($foot_js as $js): ?>
		<script type="text/javascript" src="<?php echo HOST . DS . $js ?>"></script>
	<?php endforeach ?>
	<?php endif; ?>
	
		<script>
		var trocar_senha = <?php echo isset($trocar_senha) ? 1 : 0;  ?>;
		</script>
</body>
</html>