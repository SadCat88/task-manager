<? if( $arResult['USER']['LOGIN'] ): ?>
	<section class="s_task-form">

	<h2>Добавить новую задачу</h2>

	<form 
		class="form form-task"
		method="POST"
		action="/"
	>
	
		<div class="w-form --line-2">

			<input type="hidden" name="TASK_CREATE" value="true">
	
			<? $item = $arResult['form']['ITEMS']['TASK_USERNAME']  ?>
			<label class="form-item form-item-label <?= ($item['ERROR']) ? '--error' : '' ?>">
				<p class="form-item-title">Username:</p>
				<input 
					type="text" 
					class="form-item-input --text --input" 
					name="TASK_USERNAME" 
					placeholder="Enter username" 
					autocomplete="off"
					value="<?=$item['VALUE']?>"
				>
				<p class="form-item-error"><?=$item['ERROR']?></p>
			</label>
		
			<? $item = $arResult['form']['ITEMS']['TASK_EMAIL']  ?>
			<label class="form-item form-item-label <?= ($item['ERROR']) ? '--error' : '' ?>">
				<p class="form-item-title">Email:</p>
				<input 
					type="text" 
					class="form-item-input --text --input" 
					name="TASK_EMAIL" 
					placeholder="Enter email" 
					autocomplete="off"
					value="<?=$item['VALUE']?>"
				>
				<p class="form-item-error"><?=$item['ERROR']?></p>
			</label>
	
		</div>
			
		<? $item = $arResult['form']['ITEMS']['TASK_DESCRIPTION']  ?>
		<label class="form-item form-item-label <?= ($item['ERROR']) ? '--error' : '' ?>">
			<p class="form-item-title">Description:</p>
			<textarea
				class="form-item-input --text --textarea"
				name="TASK_DESCRIPTION"
				cols="120"
				rows="3"
				placeholder="Enter your task description"
				autocomplete="off"
				<?= ($arResult['form']['FOCUS']) ? 'autofocus' : '' ?>
			><?=$item['VALUE']?></textarea>
			<p class="form-item-error"><?=$item['ERROR']?></p>
		</label>
	
		<div class="w-form --line-a-r">
			<button class="btn --create" type="submit" value="Create">
				Create
			</button>
		</div>
	
	</form>
	
</section>
<? endif;?>




