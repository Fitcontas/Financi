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