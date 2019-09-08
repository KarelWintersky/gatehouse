<?php


namespace Gatehouse\Controllers;

use Gatehouse\AbstractUnit;
use Gatehouse\Units\AjaxUnit;
use Gatehouse\Units\PhoneUnit;
use Gatehouse\Units\TransportUnit;

class Ajax extends AbstractUnit
{
    private $unit_instance;

    public function __construct()
    {
        $this->unit_instance = new AjaxUnit();
    }
    public function __invoke()
    {
        return json_encode(['error' => 0, "errorMsg" =>  __METHOD__ . ' not implemented yet' ]);
    }

    /**
     * +
     * @return false|string
     */
    public function action_phone_add()
    {
        $dataset = [
            'phone_number' => $_REQUEST['phone_number'],
            'id_allotment' => $_REQUEST['id_allotment']
        ];

        $json = (new PhoneUnit())->insert($dataset);

        return json_encode($json);
    }

    /**
     * +
     * @return false|string
     */
    public function action_phone_delete()
    {
        $json = (new PhoneUnit())->deleteByID($_REQUEST['phone_id']);
        return json_encode($json);
    }

    /**
     *
     *
     * @return false|string
     * @throws \Exception
     */
    public function action_transport_add()
    {
        $dataset = [
            'id_allotment'      =>  $_REQUEST['id_allotment'],
            'transport_number'  =>  $_REQUEST['transport_number'],
            'pass_unlimited'    =>  1,
            'pass_expiration'   =>  (new \DateTime('+100 years'))->format('Y-m-d'),
            'phone_number_temp' =>  ''
        ];

        $json = (new TransportUnit())->insert($dataset);

        if ($json['error'] == 0) {
            $json['id'] = $json['result'];
            $json['transport_number'] = $dataset['transport_number'];
        }

        return json_encode($json);
    }

    public function action_transport_delete()
    {
        $id = $_REQUEST['transport_id'];

        $json = (new TransportUnit())->delete($id);

        if ($json['error'] == 0) {
            $json['transport_id'] = $id;
        }

        return json_encode($json);
    }

}