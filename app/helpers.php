<?php

/**
 * var_export() с форматированием
 *
 * @param array $arr
 */
function debug($arr = 'OK') {
	$GLOBALS['APP']['CORE']['CSS']['helper--debug'] = true;
	echo '<br><pre class="helper--debug">';
	echo
		'<b>'
		. 'Debug::'
		. '['
		. debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 0)[0]['line']
		. ']'
		. debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 0)[0]['file']
		. '</b>'
		. PHP_EOL;
	var_export($arr);
	echo '</pre><br>';
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


	// debug($arClasses);


	if (!empty($arClasses[$className])) {

		if (file_exists($arClasses[$className])) {
			require $arClasses[$className];
		}

	}

});