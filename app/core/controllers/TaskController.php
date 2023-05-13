<?php

class TaskController extends Controller {

	private static $TASK_COUNT_PER_PAGE_LIMIT = 3;
	private static $CURRENT_PAGE_NUM = 1;


	public static $data = null;

	public static function show() {

		self::getTaskList();
		self::getPagination();
		self::getSort();

		return [
			'class' => 'IndexView',
			'data' => self::$data
		];

	}

	public static function getTaskList() {

		self::$CURRENT_PAGE_NUM = !empty($_REQUEST['PAGEN']) ? (int) $_REQUEST['PAGEN'] : 1;
		$pageN = self::$CURRENT_PAGE_NUM;

		$limit = self::$TASK_COUNT_PER_PAGE_LIMIT;
		$offset = ((($pageN * $limit) - $limit) < 0) ? 0 : (($pageN * $limit) - $limit);

		$order = [];
		if (!empty($_REQUEST['ORDER_ID'])) {
			$order['id'] = $_REQUEST['ORDER_ID'];
		}
		if (!empty($_REQUEST['ORDER_USER'])) {
			$order['user'] = $_REQUEST['ORDER_USER'];
		}
		if (!empty($_REQUEST['ORDER_EMAIL'])) {
			$order['email'] = $_REQUEST['ORDER_EMAIL'];
		}
		if (!empty($_REQUEST['ORDER_STATE'])) {
			$order['state'] = $_REQUEST['ORDER_STATE'];
		}
		if (empty($order)) {
			$order = null;
		}

		$Model = new TaskModel();
		$result = $Model->getList($limit, $offset, $order);

		// TODO: Сделать редирект в случае превышение лимита
		if (empty($result) && self::$CURRENT_PAGE_NUM) {
			debug('Сделать потом редирект на первую страницу по параметру $pagination["REDIRECT_TO_FIRST"]');
		}

		self::$data['task-list']['ITEMS'] = $result;

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

		$pagination['ITEMS']['NEXT']['SHOW'] = ($countTaskNext > 1) ? true : false;
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
		$sort = [
			'SHOW' => true,
			'REDIRECT_TO_FIRST' => false,
			'ITEMS' => [
				'ORDER_ID' => '',
				'ORDER_USER' => '',
				'ORDER_EMAIL' => '',
				'ORDER_STATE' => ''
			]
		];
	}
}