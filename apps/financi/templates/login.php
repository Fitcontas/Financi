<!DOCTYPE html>
<html lang="pt_BR">
<head>
	<meta charset="UTF-8">
	<title><?php echo isset($title) ? $title : 'Untitle' ?></title>
	<?php if(isset($head_css)): ?>
	<?php foreach ($head_css as $key => $value): ?>
		<?php if(is_array($value)): ?>
		<link rel="stylesheet" href="<?php echo $key ?>" media="<?php $value['media'] ?>">
		<?php else: ?>
		<link rel="stylesheet" href="<?php echo $value ?>">
		<?php endif; ?>
	<?php endforeach ?>
	<?php endif; ?>

	<?php if(isset($head_js)): ?>
	<?php foreach ($head_js as $js): ?>
		<script type="text/javascript" src="<?php echo $js ?>"></script>
	<?php endforeach ?>
	<?php endif; ?>
</head>
<body>
	<?php require_once $content ?>
</body>
</html>