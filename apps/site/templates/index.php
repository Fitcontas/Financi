<!DOCTYPE html>
<html lang="pt_BR" ng-app="Village">
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
<body class="index">

    <!-- Static navbar -->
      <div class="navbar navbar-default nav-fixed-top" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="#" title="Loteamento Village dos Lagos">
                <img class="logo" src="img/logo.jpg" alt="">
            </a>

          </div>
          <div id="menu" class="navbar-collapse collapse">
            <ul class="nav navbar-nav" style="margin-left: 50px;">
              <li><a href="#/">Home</a></li>
              <li><a href="#/localizacao">Localização</a></li>
              <li><a href="#/contato">Fale Conosco</a></li>
            </ul>
            <div class="navbar-form navbar-right">
                <a href="http://sistema.financi.com.br" class="btn btn-info"><i class="glyphicon glyphicon-lock" title="Acesse a área restrita"></i> Corretor</a>
            </div>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
    
    <div class="conteiner-fluid main-box">
        <?php require_once $content ?>
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

</body>
</html>