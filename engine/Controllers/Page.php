<?php

namespace Gatehouse\Controllers;

use Gatehouse\Template;
use Gatehouse\AbstractUnit;

class Page
{
    /**
     * @var string
     */
    private $template_path;

    public function __construct()
    {
        $this->template_path = '$/templates/pages';
    }


    public function page_welcome()
    {
        $t = new Template('page_welcome.html', $this->template_path);
        return $t->render();
    }

    /**
     * Страница сервисов
     * @return string
     */
    public function page_services()
    {
        $t = new Template('page_list_services.html', $this->template_path);
        return $t->render();
    }
}