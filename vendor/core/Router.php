<?php

/* Класс Маршрутизатор */

namespace core;

class Router
{

    protected static $routes = []; // Массив всех маршрутов
    protected static $route = []; // Массив текущего маршрута

    public static function add($regexp, $route = []) // Заполнение массива $routes
    {
        /* Обращение к статическому св-ву $routes,
        передача в него ключа параметра $regexp (рег-го выр-ия) и,
        присвоение ему значения параметра $route */
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function getRoute()
    {
        return self::$route;
    }

    protected static function matchRoute($url) // Сравнение
    {
        /* Перебор массива маршрутов,
        получение отдельного рег-ного выр-я и,
        отдельного маршрута, а также запись в массив $matches */
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    /* Если у ключа массива $matches строковое значение,
                    то записывай в массив $routes данные в виде:
                    ключ => значение */
                    if (is_string($key)) {
                        $route[$key] = $value;
                        /* Если action пустой, то создавай
                        по умолчанию action = index */
                        if (!isset($route['action'])) {
                            $route['action'] = 'index';
                        }
                    }
                }
                $route['controller'] = self::upperCamelCase($route['controller']); // Делаем первую букву названия контроллера заглавной
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    public static function dispatch($url) // Вывод сущ-ей стр-цы, либо 404
    {
        //Вызов метода сравнения
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {
            // Имя файла контроллера
            $controller = 'controllers\\' . self::$route['controller'] . 'Controller';
            // Поиск класса с таким же названием как у контроллера
            if (class_exists($controller)) {
                // Создание объекта контроллера
                $cObj = new $controller(self::$route);
                // Вызов соответствующего метода данного контроллера
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                // Проверка метода на его существование
                if (method_exists($cObj, $action)) {
                    // Обращение объекта класса к методу $action
                    $cObj->$action();
                    // Вызов метода
                    $cObj->getView();
                } else {
                    echo "Метод <b>$controller::$action</b> не найден!";
                }
            } else {
                echo "Контроллер <b>$controller</b> не найден!";
            }
        } else {
            http_response_code(404);
            include '404.html';
        }
    }

    protected static function upperCamelCase($name) // Приведение названия класса к стандарту
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name))); // Удаление пробела
    }

    protected static function lowerCamelCase($name) // Приведение названия метода к стандарту
    {
        return lcfirst(self::upperCamelCase($name));
    }

    // Обрезка явных GET-параметров
    protected static function removeQueryString($url)
    {
        if ($url) {
            // Разбиение URL по знаку &
            $params = explode('&', $url, 2);
            /* Если GET-параметр неявный, то всё ОК,
            иначе, возвращай пустую строку */
            if (false === strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }
    }

}