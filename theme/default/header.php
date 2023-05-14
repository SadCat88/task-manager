<header class="header">
	<div class="container">
		<div class="wrapper --line-2">

			<div class="w-heading">
				<h1>Task manager</h1>
				<p>Сегодня:
					<?= date('d.m.Y г.'); ?>
				</p>
			</div>

			<div class="w-login">
				<? if( $arResult['USER']['LOGIN'] ): ?>
					<a href="/logout.php" class="login">
						<img class="img" src="/<?=_TEMPLATE_PATH_ . '/img/login.png' ?>" alt="login">
						<span class="content">Выйти</span>
					</a>
				<? else: ?>
					<a href="/login" class="login">
						<img class="img" src="/<?=_TEMPLATE_PATH_ . '/img/login.png' ?>" alt="login">
						<span class="content">Войти</span>
					</a>
				<? endif; ?>
			</div>

		</div>
	</div>
</header>