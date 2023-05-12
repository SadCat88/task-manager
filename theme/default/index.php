<!DOCTYPE html>
<html lang="ru">

	<head>
		<? //--- Meta tags ?>
		<? include(_TEMPLATE_PATH_ . '/includes/meta.php') ?>
				
		<? //--- Top CSS and JS ?>
		<? include(_TEMPLATE_PATH_ . '/includes/styles-header.php') ?>
		<? include(_TEMPLATE_PATH_ . '/includes/scripts-header.php') ?>
	</head>
	
	<body>
		<? //--- Header part ?>
		<? include(_TEMPLATE_PATH_ . '/header.php') ?>
		
		<? //--- Main part ?>
		<? include(_TEMPLATE_PATH_ . "/pages/{$arView['MAIN']}.php") ?>
		
		<? //--- Footer part ?>
		<? include(_TEMPLATE_PATH_ . '/footer.php') ?>
		
		<? //--- Bottom CSS and JS ?>
		<? include(_TEMPLATE_PATH_ . '/includes/styles-footer.php') ?>
		<? include(_TEMPLATE_PATH_ . '/includes/scripts-footer.php') ?>
		
		<? //-- Core CSS ?>
		<?= getCoreStyle() ?>
	</body>
	
</html>
