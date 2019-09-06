<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        header('Location: index.html');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
