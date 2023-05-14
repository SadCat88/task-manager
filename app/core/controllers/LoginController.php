<?php

class LoginController extends Controller {

	public static $data = null;


	public static function show() {

		self::$data = [
			'MESSAGES' => [
				'GLOBAL' => [],
			],
			'USER' => [
				'LOGIN' => false,
			// 	'ID' => 1,
			// 	'NAME' => 'manager',
			// 	'ACTIVE' => true
			]
		];

		session_start();

		// $_SESSION['MESSAGES']['GLOBAL'] = 'Вы заблокированы администратором!';
		if (!empty($_SESSION['MESSAGES']['GLOBAL'])) {
			self::$data['MESSAGES']['GLOBAL'] = $_SESSION['MESSAGES']['GLOBAL'];
		}
		unset($_SESSION['MESSAGES']['GLOBAL']);

		if (!empty($_SESSION['USER'])) {
			self::$data['USER'] = $_SESSION['USER'];
		}

		self::getForm();
		

		if (!empty($_REQUEST['LOGIN_SIGNIN']) && $_REQUEST['LOGIN_SIGNIN'] === 'true') {
			self::loginFormSignIn();
		}



		return [
			'class' => 'LoginView',
			'data' => self::$data
		];
	}


	public static function getForm() {
		$form = [
			'SHOW' => true,
			'ERRORS' => 'N',
			'FOCUS' => false,
			'ITEMS' => [
				'LOGIN_USERNAME' => ['VALUE' => '', 'ERROR' => '',],
				'LOGIN_PASSWORD' => ['VALUE' => '', 'ERROR' => ''],
			]
		];
		self::$data['form__login'] = $form;
	}

	public static function loginFormSignIn() {


		$form = [
			'SHOW' => true,
			'ERRORS' => 'N',
			'FOCUS' => false,
			'ITEMS' => [
				'LOGIN_USERNAME' => ['VALUE' => '', 'ERROR' => '',],
				'LOGIN_PASSWORD' => ['VALUE' => '', 'ERROR' => ''],
			]
		];

		//-- Проверка наличи пользовательского ввода
		foreach ($form['ITEMS'] as $item => &$data) {
			if (!empty($_REQUEST[$item])) {
				$data['VALUE'] = htmlentities(trim($_REQUEST[$item]), ENT_QUOTES, 'UTF-8');
			} else {
				$form['ERRORS'] = 'Y';
				$data['ERROR'] = 'Обязательно к заполнению';
			}
		}



		//-- Проверка логина		
		if ( 
			!empty( $form['ITEMS']['LOGIN_USERNAME']['VALUE'] ) 
			&& !empty( $form['ITEMS']['LOGIN_PASSWORD']['VALUE'] )
		) {

			$username = $form['ITEMS']['LOGIN_USERNAME']['VALUE'];

			$Model = new UserModel();
			$user = $Model->getElementWhere('username', $username);

			if ($user) {
				$access = passwordCheck($data['VALUE'], $user['password']);
				//-- Пароль верный
				if ($access) {
					//-- Пользователь неактивный
					if ($user['active'] !== '1') {

						$_SESSION['MESSAGES']['GLOBAL'] = 'Вы заблокированы администратором!';
						$_SESSION['USER']['ACTIVE'] = false;
						goBack();
					} 
					//-- Пользователь активный
					else {
						$_SESSION['USER'] = [
							'LOGIN' => true,
							'ID' => (int)$user['id'],
							'NAME' => $user['username'],
							'ACTIVE' => true
						];
						
						goHome();
					}
				} 

				//-- Неверный пароль
				else {
					$form['ITEMS']['LOGIN_PASSWORD']['ERROR'] = 'Неверный пароль!';
				}
			}

		}

		self::$data['form__login'] = $form;

	}

}