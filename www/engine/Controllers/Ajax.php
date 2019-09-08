<?php


namespace Gatehouse\Controllers;


use Gatehouse\Units\AjaxUnit;
use Gatehouse\Units\PhoneUnit;

class Ajax
{
    private $unit_instance;

    public function __construct()
    {
        $this->unit_instance = new AjaxUnit();
    }
    public function __invoke()
    {
        return json_encode(['success' => 0, "error" =>  __METHOD__ . ' not implemented yet' ]);
    }

    public function action_phone_add()
    {
        $dataset = [
            'phone_number' => $_REQUEST['phone_number'],
            'id_allotment' => $_REQUEST['id_allotment']
        ];

        $result = (new PhoneUnit())->insert($dataset);

        return json_encode($result);
    }

    public function action_phone_delete()
    {
        $result = (new PhoneUnit())->deleteByID($_REQUEST['phone_id']);
        return json_encode($result);
    }


    public function action_transport_add()
    {
        return json_encode(['success' => 0, "error" =>  __METHOD__ . ' not implemented yet' ]);
    }

    public function action_transport_delete()
    {
        return json_encode(['success' => 0, "error" =>  __METHOD__ . ' not implemented yet' ]);
    }

}