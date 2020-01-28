<?php

/* Базовый класс для моделей */

namespace core\base;

use core\Database;

abstract class Model
{
    public function __construct()
    {
        Database::instance();
    }
}