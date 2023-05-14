<?php

/**
 * var_export() с форматированием
 *
 * @param array $data
 */
function vd(...$data) {

	//-- Фикс для dd массив в массиве
	if (is_array($data) && count($data) === 1) {
		$data = $data[0];
	}

	//-- Фикс если передали одну строку
	if (is_array($data) && count($data) === 1 && !empty($data[0])) {
		$data = $data[0];
	}

	//-- Значение по умолчанию
	if (is_array($data) && empty($data)) {
		$data = '==DEBUG==';
	}

	//-- Изменение индекса для dd()
	$bugTraceI = 0;
	if (debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 0)[0]['file'] === __FILE__) {
		$bugTraceI = 1;
	}
	$bugTraceFile = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 0)[$bugTraceI]['file'];
	$bugTraceLine = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 0)[$bugTraceI]['line'];

	$GLOBALS['APP']['CORE']['CSS']['helper--debug'] = true;

	echo '<br><pre class="helper--debug">';
	//-- Файл и строка вызова
	$heading = $bugTraceI > 0 ?
		'=== DIE ===' . PHP_EOL
		: 'Debug  ';
	echo
		'<b>'
		. $heading
		. '[' . $bugTraceLine . ']::' . $bugTraceFile
		. '</b>'
		. PHP_EOL
		. '-----------'
		. PHP_EOL;

	//-- Данные для вывода
	var_export($data);
	echo PHP_EOL . '-----------';
	echo '</pre><br>';
}

/**
 * var_export() с форматированием + die()
 *
 * @param array $data
 */
function dd(...$data) {
	vd($data);
	die();
}


function getCoreStyle() {

	$styles = '';

	foreach ($GLOBALS['APP']['CORE']['CSS'] as $filename => $true) {
		$styles .= '<link href="/app/assets/css/' . $filename . '.css" rel="stylesheet">';
	}

	return PHP_EOL . $styles;

}


/**
 * Позволяет получить индекс файловой системы.
 * Рекурсивно обходит указанный каталог и находит все файлы.
 *
 * @param string $pathSearch - Путь по которому нужно построить индекс
 * @param array $arExt - Массив допустимых расширений файлов 
 *   array('jpeg', 'jpg', 'png')
 * 
 * @return array
 */
function getIndexFiles($pathSearch = null, $arExt = null) {

	$result = [
		// 'fileName' => 'filePath'
	];

	//-- Если путь действителен
	if (file_exists($pathSearch)) {

		//-- Итерируемые директории
		$iterateDirectories = array(
			$pathSearch,
		);

		//-- Перебрать все доступные для индексирования директории
		while (count($iterateDirectories)) {

			//-- Извлечь последний элемент массива доступных для перебора директорий
			$i_dir = array_pop($iterateDirectories);

			//-- Прочитать директорию
			if ($handle = opendir($i_dir)) {

				//-- Перебрать все файловые сущности
				while (($i_fsEntity = readdir($handle)) !== false) {

					//-- Массив для сбора информации о файловой сущности
					$i_outputItem = [];

					//-- Если файловая сущность это ссылка
					// на себя (.) или родителя  (..) пропустить
					if ($i_fsEntity == '.' || $i_fsEntity == '..') {
						continue;
					}

					//-- Полный путь к итерируемой сущности
					$i_fsEntityPath = $i_dir . '/' . $i_fsEntity;

					//--------------------------------------------------------------------
					// Если текущая сущность директория
					// добавить ее в начало массива перебираемых путей для поиска,
					// чтобы в ней на последующих итерациях найти все файлы
					//--------------------------------------------------------------------
					if (is_dir($i_fsEntityPath)) {
						array_push($iterateDirectories, $i_fsEntityPath);
						continue;
					}

					//--------------------------------------------------------------------
					// Если текущая сущность файл
					//--------------------------------------------------------------------
					else {

						//-- Расширение итерируемого файла
						$i_fxEntityExt = strtolower(pathinfo($i_fsEntityPath)['extension']);

						//-- Если указан массив допустимых расширений файлов
						// и расширение итерируемого файла не в массиве допустимых
						// не записывать этот файл
						if (
							!empty($arExt) && is_array($arExt)
							&& !in_array($i_fxEntityExt, $arExt)
						) {
							continue;
						}


						// Записатьнеобходимую информацию о файле
						$i_outputItem['path'] = $i_fsEntityPath;
						// $i_outputItem['data']['size'] = filesize($i_fsEntityPath);
						// $i_outputItem['data']['dateChange'] = filectime($i_fsEntityPath);
						// $i_outputItem['data']['ext'] = $i_fxEntityExt;

					}

					//--------------------------------------------------------------------
					// Добавть информацию в результат
					//--------------------------------------------------------------------
					if (!empty($i_outputItem)) {
						//array_push($indexFileSystem, $i_outputItem);

						$className = (pathinfo($i_fsEntityPath))['filename'];

						$result[$className] = realpath($i_outputItem['path']);
					}

				}

			}

		}

	}

	return $result;

}


function passwordEncrypt($password = null) {

	$result = false;

	if ($password) {
		$password = md5($password, true);
		$result = password_hash($password, PASSWORD_BCRYPT);
	}

	return $result;

}
function passwordCheck($password = null, $hash = null) {

	$result = false;

	if ($password && $hash) {
		$password = md5($password, true);
		$result = password_verify($password, $hash);
	}

	return $result;

}


function getUrl($home = false) {

	$result = false;

	//-- Домашняя страница HTTP://SITE.COM/
	if ($home === 'home') {
		$result =
				/* HTTP:// */	((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://'
			/* SITE.COM/ */	. $_SERVER['HTTP_HOST'] . '/';

	}
	//-- Полный URL HTTP://SITE.COM/SECTION/?GET=OK 
	else {
		$result =
				/* HTTP:// */	((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://'
			/* SITE.COM  */	. $_SERVER['HTTP_HOST']
			/* /SECTION/ */	. $_SERVER['REDIRECT_URL']
			/* ?GET=OK   */	. ((!empty($_SERVER['QUERY_STRING'])) ? '/?' . $_SERVER['QUERY_STRING'] : '');
	}


	return $result;
}


function goHome() {
	$home = getUrl('home');
	header("Location: {$home}");
	exit;
}

function goBack() {
	$home = getUrl();
	header("Location: {$home}");
	exit;
}



/**
 * Автоладер классов
 */
spl_autoload_register(function ($className) {

	global $cfg;

	$corePath = realpath(__DIR__ . '/..' . $cfg['path']['core']);

	$arClasses = [
		// 'fileName' => 'filePath'
	];

	$arClasses = getIndexFiles(
		/* folderPath */	$corePath,
		/* good ext */	['php']
	);

	if (!empty($arClasses[$className])) {

		if (file_exists($arClasses[$className])) {
			require $arClasses[$className];
		}

	}

});

/**
 * Замена GET параметров в URI
 * 	$params = [
 *  	'PAGEN' => '2',
 * 		'ORDER_ID' => 'DESC',
 * 	];
 * 
 * 	$mode = 'uri'|'get';
 */
function changeGetParams($params = null, $mode = 'uri') {


	$urlFull = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http')
		. '://' . $_SERVER['HTTP_HOST']
		. ((!empty($_SERVER['QUERY_STRING'])) ? '/?' . $_SERVER['QUERY_STRING'] : '');

	$urlParts = parse_url($urlFull);

	$urlGetParams = [];
	if (!empty($urlParts['query'])) {
		parse_str($urlParts['query'], $urlGetParams);
	}

	foreach ($params as $name => $val) {
		if ($val === false || $val === null) {
			unset($urlGetParams[$name]);
		}
		//
		else {
			$urlGetParams[$name] = $val;
		}
	}


	$new_url = '';
	if ($mode === 'uri') {
		$new_url .= (empty($urlParts['path'])) ? '/' : $urlParts['path'];
	}
	if (!empty($urlGetParams)) {
		$new_url .= '?' . http_build_query($urlGetParams);
	}

	return $new_url;

}