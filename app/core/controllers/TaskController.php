<?php

class TaskController extends Controller {

	private static $TASK_COUNT_PER_PAGE_LIMIT = 3;
	private static $CURRENT_PAGE_NUM = 1;
	private static $TASK_DB_COUNT = null;

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

		// $_SESSION['MESSAGES']['GLOBAL'] = 'Задача успешно создана!';
		if (!empty($_SESSION['MESSAGES']['GLOBAL'])) {
			self::$data['MESSAGES']['GLOBAL'] = $_SESSION['MESSAGES']['GLOBAL'];
		}
		unset($_SESSION['MESSAGES']['GLOBAL']);

		if (!empty($_SESSION['USER'])) {
			self::$data['USER'] = $_SESSION['USER'];
		}

		self::getForm();
		if (!empty($_REQUEST['TASK_CREATE']) && $_REQUEST['TASK_CREATE'] === 'true') {
			self::createTask();
		}

		self::getTaskList();
		self::getPagination();
		self::getSort();




		return [
			'class' => 'IndexView',
			'data' => self::$data
		];

	}

	public static function getTaskList() {

		$taskList = [
			'SHOW' => false,
			'ITEMS' => []
		];

		self::$CURRENT_PAGE_NUM = !empty($_REQUEST['PAGEN']) ? (int) $_REQUEST['PAGEN'] : 1;
		$pageN = self::$CURRENT_PAGE_NUM;

		$limit = self::$TASK_COUNT_PER_PAGE_LIMIT;
		$offset = ((($pageN * $limit) - $limit) < 0) ? 0 : (($pageN * $limit) - $limit);

		$order = [];
		// TODO: Сделать потом валидатор
		if (!empty($_REQUEST['ORDER_ID'])) {
			if (in_array($_REQUEST['ORDER_ID'], ['ASC', 'DESC'])) {
				$order['id'] = $_REQUEST['ORDER_ID'];
			}
		}
		if (!empty($_REQUEST['ORDER_USER'])) {
			if (in_array($_REQUEST['ORDER_USER'], ['ASC', 'DESC'])) {
				$order['user'] = $_REQUEST['ORDER_USER'];
			}
		}
		if (!empty($_REQUEST['ORDER_EMAIL'])) {
			if (in_array($_REQUEST['ORDER_EMAIL'], ['ASC', 'DESC'])) {
				$order['email'] = $_REQUEST['ORDER_EMAIL'];
			}
		}
		if (!empty($_REQUEST['ORDER_STATE'])) {
			if (in_array($_REQUEST['ORDER_STATE'], ['ASC', 'DESC'])) {
				$order['state'] = $_REQUEST['ORDER_STATE'];
			}
		}
		if (empty($order)) {
			$order = null;
		}

		$Model = new TaskModel();
		$result = $Model->getList($limit, $offset, $order);

		// TODO: Сделать редирект в случае превышение лимита
		if (empty($result) && self::$CURRENT_PAGE_NUM !== 1) {
			vd('Сделать потом редирект на первую страницу по параметру $pagination["REDIRECT_TO_FIRST"]');
		}

		$taskList['ITEMS'] = $result;

		$taskList['SHOW'] = (!empty($result)) ? true : false;

		self::$data['task-list'] = $taskList;

	}

	public static function getPagination() {

		$pagination = [
			'SHOW' => false,
			'REDIRECT_TO_FIRST' => false,
			'ITEMS' => [
				'FIRST' => ['SHOW' => false, 'VALUE' => 1, 'LINK' => ''],
				'PREV' => ['SHOW' => false, 'VALUE' => self::$CURRENT_PAGE_NUM - 1, 'LINK' => ''],
				'CURRENT' => ['SHOW' => true, 'VALUE' => self::$CURRENT_PAGE_NUM, 'LINK' => ''],
				'NEXT' => ['SHOW' => true, 'VALUE' => self::$CURRENT_PAGE_NUM + 1, 'LINK' => ''],
				'LAST' => ['SHOW' => false, 'VALUE' => self::$CURRENT_PAGE_NUM + 1, 'LINK' => '']
			]
		];

		$Model = new TaskModel();

		//-- Расчет количества заданий

		$countAllTask = (int) $Model->getCount();
		self::$TASK_DB_COUNT = $countAllTask;

		$countTaskPrev = (self::$CURRENT_PAGE_NUM * self::$TASK_COUNT_PER_PAGE_LIMIT) - self::$TASK_COUNT_PER_PAGE_LIMIT;

		$countTaskNext = $countAllTask - $countTaskPrev - self::$TASK_COUNT_PER_PAGE_LIMIT;
		$countTaskNext = ($countTaskNext < 0) ? 0 : $countTaskNext;

		$countCurrentTask = $countAllTask - $countTaskPrev - $countTaskNext;


		//-- Состояние самой пагинации
		$pagination['SHOW'] = ($countAllTask > self::$TASK_COUNT_PER_PAGE_LIMIT) ? true : false;

		if ($countCurrentTask < 0) {
			$pagination['REDIRECT_TO_FIRST'] = true;
		}

		//-- Передача в пагинацию состояния активности кнопок и их значений
		$pagination['ITEMS']['FIRST']['SHOW'] = ($countTaskPrev > 0) ? true : false;
		$pagination['ITEMS']['FIRST']['SHOW'] = ($pagination['ITEMS']['FIRST']['VALUE'] < $pagination['ITEMS']['PREV']['VALUE']) ? true : false;

		$pagination['ITEMS']['PREV']['SHOW'] = (self::$CURRENT_PAGE_NUM > 1) ? true : false;

		$pagination['ITEMS']['NEXT']['SHOW'] = ($countTaskNext >= 1) ? true : false;
		$pagination['ITEMS']['NEXT']['VALUE'] = (!$pagination['ITEMS']['NEXT']['SHOW']) ? self::$CURRENT_PAGE_NUM : $pagination['ITEMS']['NEXT']['VALUE'];

		$pagination['ITEMS']['LAST']['SHOW'] = ($countTaskNext > self::$TASK_COUNT_PER_PAGE_LIMIT) ? true : false;
		$pagination['ITEMS']['LAST']['VALUE'] = (int) round($countAllTask / self::$TASK_COUNT_PER_PAGE_LIMIT);


		//-- Передача в пагинацию ссылок для каждой кнопки
		foreach ($pagination['ITEMS'] as $item => &$data) {
			if ($item !== 'CURRENT' && $data['SHOW'] === true) {
				$params = ['PAGEN' => $data['VALUE']];
				$data['LINK'] = changeGetParams($params);
			}
		}

		self::$data['pagination'] = $pagination;

	}

	public static function getSort() {

		$orderFlow = ['ASC', 'DESC', 'NULL'];

		$sort = [
			'SHOW' => true,
			'ITEMS' => [
				'ORDER_ID' => ['VALUE' => 'NULL', 'LINK' => ''],
				'ORDER_USER' => ['VALUE' => 'NULL', 'LINK' => ''],
				'ORDER_EMAIL' => ['VALUE' => 'NULL', 'LINK' => ''],
				'ORDER_STATE' => ['VALUE' => 'NULL', 'LINK' => ''],
			]
		];

		if (self::$TASK_DB_COUNT > 1) {

			//-- Передача в сортировку ссылок для каждого элемента
			foreach ($sort['ITEMS'] as $item => &$data) {

				//-- Считать текущее значение
				if (
					!empty($_REQUEST[$item])
					&& in_array($_REQUEST[$item], $orderFlow)
				) {
					//-- СБрос значения по умолчанию
					if (empty($_REQUEST['ORDER_ID'])) {
						$sort['ITEMS']['ORDER_ID']['VALUE'] = 'NULL';
					}
					//-- Установка текущего значения
					$data['VALUE'] = $_REQUEST[$item];
				}

				//-- Следующее значение
				$nextVal = array_search($data['VALUE'], $orderFlow);
				$nextVal++;
				if ($nextVal >= count($orderFlow)) {
					$nextVal = 0;
				}
				$nextVal = ($orderFlow[$nextVal] === 'NULL') ? null : $orderFlow[$nextVal];

				//-- Передача в сортировку ссылок
				$params = [$item => $nextVal];
				$data['LINK'] = changeGetParams($params);
			}

		} else {
			$sort['SHOW'] = false;
		}



		self::$data['sort'] = $sort;

	}

	public static function getForm() {
		$form = [
			'SHOW' => true,
			'ERRORS' => 'N',
			'FOCUS' => false,
			'ITEMS' => [
				'TASK_USERNAME' => ['VALUE' => '', 'ERROR' => '',],
				'TASK_EMAIL' => ['VALUE' => '', 'ERROR' => ''],
				'TASK_DESCRIPTION' => ['VALUE' => '', 'ERROR' => ''],
			]
		];
		self::$data['form'] = $form;
	}


	public static function createTask() {
		$form = [
			'SHOW' => true,
			'ERRORS' => 'N',
			'FOCUS' => true,
			'ITEMS' => [
				'TASK_USERNAME' => ['VALUE' => '', 'ERROR' => '',],
				'TASK_EMAIL' => ['VALUE' => '', 'ERROR' => ''],
				'TASK_DESCRIPTION' => ['VALUE' => '', 'ERROR' => ''],
			]
		];

		foreach ($form['ITEMS'] as $item => &$data) {
			if (!empty($_REQUEST[$item])) {

				$data['VALUE'] = htmlentities(trim($_REQUEST[$item]), ENT_QUOTES, 'UTF-8');

				if ($item === 'TASK_EMAIL') {
					$pattern = "|^([a-z0-9_.-]{1,20})@([a-z0-9.-]{1,20}).([a-z]{2,4})|is";
					if (!preg_match($pattern, strtolower($_REQUEST[$item]))) {
						$form['ERRORS'] = 'Y';
						$data['ERROR'] = 'В поле Email надо ввести действительный адрес.';
					}
				}
			} else {
				$form['ERRORS'] = 'Y';
				$data['ERROR'] = 'Обязательно к заполнению';
			}
		}


		if ($form['ERRORS'] === 'N') {

			$Model = new TaskModel();

			$result = $Model->createTask(
				$form['ITEMS']['TASK_USERNAME']['VALUE'],
				$form['ITEMS']['TASK_EMAIL']['VALUE'],
				$form['ITEMS']['TASK_DESCRIPTION']['VALUE']
			);

			if ($result) {

				$_SESSION['MESSAGES']['GLOBAL'] = 'Задача успешно создана!';
				goBack();

			}

		}

		self::$data['form'] = $form;

	}
}