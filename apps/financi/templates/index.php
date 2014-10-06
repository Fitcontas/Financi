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
	            
	            <?php echo \Financi\Menu::render('menunav') ?>

	            <ul class="nav navbar-nav navbar-right user-nav">


					<li class="button dropdown">
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
				    </li>

	                <li class="dropdown profile_menu">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img alt="Avatar" width="30px" height="30px" src="<?php echo HOST . DS ?>images/avatar2.jpg" /><?php echo $user['usuario'] ?> <b class="caret"></b></a>
	                    <ul class="dropdown-menu">
	                        <li><a href="/sair"><i class="glyphicon glyphicon-cog">Sair</i></a></li>
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
</body>
</html>