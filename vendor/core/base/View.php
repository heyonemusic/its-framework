<?php

/* Базовый класс для видов и шаблонов */

namespace core\base;

class View
{
    public $route = [];  // Текущий маршрут
    public $view; // Текущий вид
    public $layout; // Текущий шаблон

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        // Если св-во в action $layout = false, то не подключай шаблон
        if ($layout === false) {
            $this->layout = false;
        } else {
            // Подключение шаблона по умолчанию в случае отсутствия значения в параметре $layout
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    public function render($vars) // Подключение вида и шаблона
    {
        // Импорт переменных из массива в строку
        extract($vars);
        // Путь к файлу с видом
        $file_view = APP . "/views/{$this->route['controller']}/{$this->view}.php";
        ob_start(); // Буферизация
        if (is_file($file_view)) {
            require $file_view;
        } else {
            echo "<p>Не найден вид <b>$file_layout</b></p>";
        }
        $content = ob_get_clean(); // Содержимое вида в буфере
        // Если св-во $layout не равен false, то подключай шаблон
        if (false !== $this->layout) {
            // Путь к файлу с шаблоном
            $file_layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($file_layout)) {
                require $file_layout;
            } else {
                echo "<p>Не найден шаблон <b>$file_layout</b></p>";
            }
        }
    }
}