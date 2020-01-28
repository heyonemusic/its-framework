<?php

/* Базовый класс для контроллеров */

namespace core\base;

abstract class Controller
{
    public $route = [];  // Текущий маршрут
    public $view; // Текущий вид
    public $layout; // Текущий шаблон
    public $vars = []; // Пользовательские данные

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function getView() // Вывод вида и шаблона
    {
        $vObj = new View($this->route, $this->layout, $this->view); // Создание объекта класса View
        $vObj->render($this->vars); // Вызов метода подключения вида и шаблона
    }
    // Объявление переменных внутри вида
    public function set($vars)
    {
        $this->vars = $vars;
    }
}