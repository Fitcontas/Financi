<?php require_once $content ?>
    
<?php if(isset($foot_js)): ?>
<?php foreach ($foot_js as $js): ?>
<script type="text/javascript" src="<?php echo HOST . DS . $js ?>"></script>
<?php endforeach ?>
<?php endif; ?>
