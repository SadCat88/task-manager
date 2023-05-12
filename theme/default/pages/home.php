<main class="main">
	<div class="container">


		<? include(_TEMPLATE_PATH_ . '/components/form.php') ?>


		<?
		// $cfgDB = Config::get('DB');
		
		// $SQL = mysqli_connect($cfgDB['DB_HOST'], $cfgDB['DB_USER'], $cfgDB['DB_PASS'], $cfgDB['DB_NAME']);
		


		// $result = mysqli_query($SQL, "SELECT * FROM `test`");
		// for ($data = []; $row = mysqli_fetch_assoc($result); $data[$row['id']] = $row) {
		// }
		
		// debug($data);

		

		// $Model = new Model();
		// $result = $Model->query("SELECT * FROM `test`")->toArray();

		// debug($result);


		$Model = new TestModel('test');
		$result = $Model->getById(2);

		debug($result);

		?>

	</div>
</main>