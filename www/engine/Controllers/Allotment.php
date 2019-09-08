<?php


namespace Gatehouse\Controllers;

use Arris\Template;
use Gatehouse\Units\AllotmentUnit;
use Gatehouse\Units\PhonesUnit;
use Gatehouse\Units\PipelinesUnit;
use Gatehouse\Units\TransportUnit;

class Allotment
{
    private $unit_instance;
    private $template_path;
    private $url_page_list;

    public function __construct()
    {
        $this->unit_instance = new AllotmentUnit();
        $this->template_path = '$/templates/places';
        $this->url_page_list = '/places';
    }

    public function __invoke()
    {
        return __METHOD__;
    }

    /**
     * ==========================================
     */
    public function page_manage()
    {
        $t = new Template('manage.html', $this->template_path);
        $id = intval($_REQUEST['id']);
        $data_allotment = $this->unit_instance->get($id);
        $data_phones = (new PhonesUnit())->getAll();
        $data_transport = (new TransportUnit())->getAll();

        $t->set('allotment', $data_allotment);
        $t->set('phones', $data_phones);
        $t->set('transport', $data_transport);

        return $t->render();
    }



    public function page_list()
    {
        $t = new Template('list.html', $this->template_path);

        $allotments = $this->unit_instance->getAll();

        $t->set('allotments_list', $allotments);
        $t->set('allotments_count', count($allotments));

        return $t->render();
    }

    public function form_add()
    {
        $selector_pipelines = (new PipelinesUnit())->getPipelines();

        $t = new Template('form_add.html', $this->template_path);
        return $t->render();
    }

    public function form_edit()
    {
        $t = new Template('form_edit.html', $this->template_path);
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

        redirect($this->url_page_list);
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

        redirect($this->url_page_list);
    }

    public function callback_delete()
    {
        $id = $_REQUEST['id'];

        $delete_status = $this->unit_instance->delete($id);

        //@todo: set session value

        redirect($this->url_page_list);
    }

}