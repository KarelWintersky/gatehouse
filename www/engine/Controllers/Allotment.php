<?php


namespace Gatehouse\Controllers;

use Arris\Template;
use Gatehouse\Units\AllotmentUnit;
use Gatehouse\Units\PipelinesUnit;

class Allotment
{
    private $unit_instance;

    public function __construct()
    {
        $this->unit_instance = new AllotmentUnit();
    }

    public function __invoke()
    {
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
        $selector_pipelines = (new PipelinesUnit())->getPipelines();

        $t = new Template('form_add.html', '$/templates/places');
        return $t->render();
    }

    public function form_edit()
    {
        $t = new Template('form_edit.html', '$/templates/places');
        $allotment_id = intval($_REQUEST['id']);

        $allotment_data = $this->unit_instance->get($allotment_id);

        $t->set('allotment_id', $allotment_id);
        $t->set('allotment', $allotment_data);

        return $t->render();
    }

    public function callback_add()
    {
        $dataset = [
            'pipeline'  =>  $_REQUEST['pipeline'],
            'name'      =>  $_REQUEST['index'],
            'owner'     =>  $_REQUEST['owner'],
            'status'    =>  is_null(@$_REQUEST['status']) ? 'restricted' : 'allowed'
        ];

        $insert_status = $this->unit_instance->insert($dataset);

        //@todo: if false - set SESSION value

        redirect('/places');
    }

    public function callback_edit()
    {
        $dataset = [
            'id'        =>  $_REQUEST['allotment_hidden_id'],
            'owner'     =>  $_REQUEST['owner'],
            'status'    =>  is_null(@$_REQUEST['status']) ? 'restricted' : 'allowed'
        ];

        $update_status = $this->unit_instance->update($dataset);

        //@todo: set session value

        redirect('/places');
    }

    public function callback_delete()
    {
        $id = $_REQUEST['id'];

        $delete_status = $this->unit_instance->delete($id);

        //@todo: set session value

        redirect('/places');
    }

}