<?php

/* Класс для работы с Базой Данных */

namespace core;

use R;

class Database
{
    protected static $instance; // Объект данного класса

    protected function __construct()
    {
        R::setup('mysql:host=localhost;dbname=fw', 'root', '');
        R::freeze(true);
    }

    // Проверка на наличие создания объекта
    public static function instance()
    {
        /* Если в св-во $instance ничего не записано,
        то записываем в это св-во объект данного класса */
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}