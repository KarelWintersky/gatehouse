<?php


namespace Gatehouse\Controllers;

use Arris\Template;
use function Arris\DBC as DBCAlias;

class Allotment
{
    private $template;

    private $unit_instance;

    public function __construct()
    {
        $this->unit_instance = new \Gatehouse\Units\Allotment();
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
        return __METHOD__;
    }

    /**
     * ==========================================
     */

    public function page_list()
    {
        $t = new Template('list.html', '$/templates/places');

        $allotments = $this->unit_instance->getAll();

        $t->set('allotments_list', $allotments);
        $t->set('allotments_count', count($allotments));

        return $t->render();
    }

    public function form_add()
    {
        $t = new Template('form_add.html', '$/templates/places');
        return $t->render();
    }

    public function form_edit()
    {
        $t = new Template('form_edit.html', '$/templates/places');
        $allotment_id = intval($_REQUEST['allotment_id']);

        $allotment_data = $this->unit_instance->get($allotment_id);

        $t->set('allotment_id', $allotment_id);
        $t->set('allotment', $allotment_data);

        return $t->render();
    }

    public function callback_add()
    {
        $dataset = [

        ];

        $this->unit_instance->insert($dataset);

        redirect('/places');
    }

    public function callback_edit()
    {
        return __METHOD__;
    }

    public function callback_delete()
    {
        return __METHOD__;
    }

}