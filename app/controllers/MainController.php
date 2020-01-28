<?php

namespace controllers;

use models\Main;
use R;

class MainController extends AppController
{

    public function indexAction()
    {
        $model = new Main; // Создание объекта класса Модель
        $postsAll = R::findAll('posts'); // Вывод всех постов
        $menu = R::findAll('category');
        // Реализация вывода переменных внутри вида
        $title = 'Шаблон по умолчанию';
        $this->set(compact('title', 'postsAll', 'menu'));
    }

}