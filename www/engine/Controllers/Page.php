<?php


namespace Gatehouse\Controllers;


use Arris\Template;

class Page
{
    public function __construct()
    {
    }

    public function page_welcome()
    {
        $t = new Template('index.html', '$/templates');

        // $t->set();

        return $t->render();
    }
}