<section class="s_task-form">

	<h2>Добавить новую задачу</h2>

	<form class="form form-task">
	
		<div class="w-form --line-2">
	
			<label class="form-item form-item-label">
				<p class="form-item-title">Username:</p>
				<input 
					type="text" 
					class="form-item-input --text --input" 
					name="task_username" 
					placeholder="Enter username" 
					autocomplete="disabled"
				>
			</label>
		
			<label class="form-item form-item-label">
				<p class="form-item-title">Email:</p>
				<input 
					type="text" 
					class="form-item-input --text --input" 
					name="task_email" 
					placeholder="Enter email" 
					autocomplete="disabled"
				>
			</label>
	
		</div>
			
		<label class="form-item form-item-label">
			<p class="form-item-title">Description:</p>
			<textarea
				class="form-item-input --text --textarea"
				name="task_description"
				cols="120"
				rows="3"
				placeholder="Enter your task description"
			></textarea>
		</label>
	
		<div class="w-form --line-a-r">
			<button class="btn --create" type="submit" value="Create">
				Create
			</button>
		</div>
	
	</form>
	
</section>





