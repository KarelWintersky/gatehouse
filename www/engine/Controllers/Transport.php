<?php


namespace Gatehouse\Controllers;

use Arris\Template;
use Gatehouse\Units\AllotmentUnit;
use Gatehouse\Units\TransportUnit;

class Transport
{
    private $unit_instance;
    private $template_path;
    private $url_page_list;

    public function __construct()
    {
        $this->unit_instance = new TransportUnit();
        $this->template_path = '$/templates/transport';
        $this->url_page_list = '/transport';
    }

    public function __invoke()
    {
        return __METHOD__;
    }

    /**
     * ==========================================
     */

    /**
     * Список транспортных средств
     * @return string
     */
    public function page_list()
    {
        $t = new Template('list.html', $this->template_path);

        $transport_list = $this->unit_instance->getAll();

        $t->set('transport_list', $transport_list);
        $t->set('transport_count', count($transport_list));

        return $t->render();
    }

    /**
     * Форма добавления транспортного средства
     *
     * @return mixed|string|null
     */
    public function form_add()
    {
        $t = new Template('form_add.html', $this->template_path);

        $allotments_selector = (new AllotmentUnit())->getAllForSelector();

        $t->set('select_allotments', $allotments_selector);

        return $t->render();
    }


    public function form_edit()
    {
        $t = new Template('form_edit.html', $this->template_path);
        $id = intval($_REQUEST['id']);

        $transport_data = $this->unit_instance->get($id);

        $t->set('transport_id', $id);
        $t->set('transport', $transport_data);

        return $t->render();
    }

    /**
     * Коллбэк формы добавления транспортного средства
     */
    public function callback_add()
    {
        $dataset = [
            'id_allotment'          =>  $_REQUEST['id_allotment'],
            'transport_number'      =>  $_REQUEST['transport_number'],
            'pass_unlimited'        =>  is_null(@$_REQUEST['is_pass_unlimited']) ? 0 : 1,
            'pass_expiration'       =>  $_REQUEST['pass_expiration'],
            'phone_number_temp'     =>  $_REQUEST['phone_number_temp']
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