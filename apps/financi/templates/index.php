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
                    <li class="active">Mural</li>
                    <li class="active">Dashboard</li>
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