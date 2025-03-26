<?php

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Debug');

// В нем написать код, который, при обращении к нему по HTTP, будет записывать в файл текущие дату и время.

// Указываем имя файла
$filename = 'current_datetime.txt';

// Получаем текущую дату и время
$currentDateTime = date('d.m.Y H:i:s');

// Открываем файл для добавления. Если файл не существует, он будет создан
$file = fopen($filename, 'a');

// Проверяем, удалось ли открыть файл
if ($file) {
    // Добавляем текущую дату и время в файл с новой строки
    fwrite($file, $currentDateTime . PHP_EOL);

    // Закрываем файл
    fclose($file);

    echo "Дата и время успешно добавлены в файл $filename.<br>";

    // Читаем содержимое файла
    $fileContent = file_get_contents($filename);

    // Выводим содержимое файла
    echo "Содержимое файла:<br>" . nl2br($fileContent);
} else {
    echo "Не удалось открыть файл для записи.";
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';