<section class="s_login-form">

	<h2>Авторизация</h2>

	<form class="form form-login" method="POST" action="/login/">

		<div class="w-form --line-2 --vert">

			<input type="hidden" name="LOGIN_SIGNIN" value="true">

			<? $item = $arResult['form__login']['ITEMS']['LOGIN_USERNAME'] ?>
			<label class="form-item form-item-label <?= ($item['ERROR']) ? '--error' : '' ?>">
				<p class="form-item-title">Username:</p>
				<input type="text" class="form-item-input --text --input" name="LOGIN_USERNAME" placeholder="Enter login"
					autocomplete="off" 
					readonly
       		onfocus="setTimeout(() => { this.removeAttribute('readonly') }, 100);"

					value="<?= $item['VALUE'] ?>">
				<p class="form-item-error">
					<?= $item['ERROR'] ?>
				</p>
			</label>

			<? $item = $arResult['form__login']['ITEMS']['LOGIN_PASSWORD'] ?>
			<label class="form-item form-item-label <?= ($item['ERROR']) ? '--error' : '' ?>">
				<p class="form-item-title">Password:</p>
				<input type="password" class="form-item-input --text --input" name="LOGIN_PASSWORD" placeholder="Enter password"
					autocomplete="new-password"
					autocomplete="off" 
					readonly
       		onfocus="setTimeout(() => { this.removeAttribute('readonly') }, 100);"
					
					value="<?= $item['VALUE'] ?>">
				<p class="form-item-error">
					<?= $item['ERROR'] ?>
				</p>
			</label>

		</div>


		<div class="w-form --line-a-r">
			<button class="btn --login" type="submit" value="Login">
				Login
			</button>
		</div>

	</form>

</section>
