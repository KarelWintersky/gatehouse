<?php


namespace Gatehouse\Units;

use Gatehouse\AbstractUnit;
use function Arris\DBC;

class PhoneUnit extends AbstractUnit
{
    public function __construct()
    {
    }

    public function getAll()
    {
        $query = "
        SELECT 
            p.id AS id,
            a.name AS id_allotment,
            phone_number
        FROM
            allotments AS a, phones AS p
        WHERE 
            a.id = p.id_allotment
        ORDER BY p.id
        ";

        $sth = DBC()->query($query);

        return $sth->fetchAll();
    }

    /**
     * Пытается вставить номер телефона в базу
     *
     * @param $dataset
     * @return array
     */
    public function insert($dataset)
    {
        $query = " INSERT INTO phones (`id_allotment`, `phone_number`) VALUES (:id_allotment, :phone_number) ";

        $result = [
            'success'       =>  0,
            'error'         =>  'Unknown error',
            'id_allotment'  =>  $dataset['id_allotment'],
            'id_phone'      =>  NULL,
            'phone_number'  =>  $dataset['phone_number']
        ];

        try {
            $sth = DBC()->prepare($query);
            $sth->execute($dataset);

            $result['id_phone'] = DBC()->lastInsertId();
            $result['success'] = 1;

        } catch (\PDOException $e) {
            if ($e->errorInfo[1] == self::MYSQL_ERROR_DUPLICATE_ENTRY) {
                $result['error'] = '1062';
            } else {
                $result['error'] = $e->getMessage();
            }
        }

        return $result;
    }

    /**
     * Пытается удалить номер телефона из базы по его ID
     *
     * @param $id
     * @return array
     */
    public function deleteByID($id)
    {
        $result = [
            'error'     =>  'Unknown',
            'success'   =>  0
        ];

        $query = "DELETE FROM phones WHERE id = :id ";
        try {
            $sth = DBC()->prepare($query);
            $sth->execute([ 'id' => $id ]);

            $result['success'] = 1;

        } catch (\PDOException $e) {
            $result['error'] = $e->getMessage();
        }

        return $result;
    }


}