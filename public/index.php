<?php

error_reporting(-1);

// Входящий URL от пользователя
$query = $_SERVER['QUERY_STRING'];

define('ROOT', dirname(__DIR__));
// Корневой каталог
define('APP', dirname(__DIR__) . '/app');
// Шаблон по умолчанию
define('LAYOUT', 'default');
// Подключение автозагрузки файлов
require_once '../vendor/autoload.php';
// Подключение ORM библиотеки RedBean
require_once '../vendor/libs/rb.php';

// Подключение классов
use core\Router;
use controllers\Main;
use controllers\Page;
use controllers\Posts;
use controllers\PostsNew;

// Правило, которое срабатывает при передаче параметра (controller/action/parameter)
Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Page']);
// Создание 'action' => 'view' по умолчанию для контроллера 'page'
Router::add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' => 'view']);
/* Создание первого правила по умолчанию,
срабатывает при чистом домене */
Router::add('^$', ['controller' => 'main', 'action' => 'index']);
/* Создание второго правила по умолчанию,
срабатывает при разных сегментах */
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query); //Вызов метода вывода маршрута