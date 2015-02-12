<!DOCTYPE html>
<html lang="pt_BR" ng-app="Financi">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title><?php echo isset($title) ? $title : 'Untitle' ?></title>

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
	
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

	<div ng-controller="ctrlMinhaConta">
		<?php include APP_PATH . DS . 'templates' . DS . 'navbar.php' ?>
		<?php include APP_PATH . DS . 'views' . DS . 'usuario' . DS . 'minha_conta_modal.php' ?>
	</div>

	<div id="cl-wrapper">
            
        <div class="cl-sidebar">
          
            <div class="cl-toggle">
                <i class="fa fa-bars"></i>
            </div>

            <div class="cl-navblock">
                <div class="menu-space">
                    <div class="content">
                        <ul class="cl-vnavigation">
							<?php if($user['grupo_id'] == 1): ?>
				            <?php echo \Financi\Menu::render('menunav') ?>
							<?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid" id="pcont">
            <div class="page-head">
				<h2>Empreendimentos</h2>
				<ol class="breadcrumb">
				  <li><a href="/">Home</a></li>
				  <li class="active">Cadastro</li>
				  <li class="active">Empreendimentos</li>
				</ol>
			</div>
          
            <div class="cl-mcont" ng-cloak>
                <div class="no-margin-top">
                    <div class="col-sm-24">
                		<div class="new-msg"></div>
                    </div> 
                </div>


                <?php require_once $content ?>
            </div>
        </div>
    </div>
    

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