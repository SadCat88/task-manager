<main class="main">
	<div class="container">

		<? if (!empty($arResult['MESSAGES']['GLOBAL'])): ?>
			<div class="message --global">
				<button type="button" class="btn --close">╳</button>
				<p class="content">
					<?= $arResult['MESSAGES']['GLOBAL'] ?>
				</p>
			</div>
		<? endif; ?>


		<? include(_TEMPLATE_PATH_ . '/components/task-list.php') ?>

		<? include(_TEMPLATE_PATH_ . '/components/form.php') ?>


	</div>
</main>