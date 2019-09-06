<?php


namespace Gatehouse\Units;

use Gatehouse\AbstractUnit;
use function Arris\DBC;

class TransportUnit extends AbstractUnit
{

    /**
     * TransportUnit constructor.
     */
    public function __construct()
    {

    }

    /**
     * Список всего транспорта
     */
    public function getAll()
    {
        $query = "SELECT * FROM transport"; // WHERE ....

        $sth = DBC()->query($query);

        $transport = [];
        while ($row = $sth->fetch()) {
            $transport[] = $row;
        }

        return $transport;
    }

    /**
     * Информация о транспортном средстве по ID
     *
     * @param $id
     */
    public function get($id)
    {

    }

    /**
     * Вставка нового транспортного средства
     *
     * @param array $dataset
     */
    public function insert(array $dataset)
    {
        $query = "
INSERT INTO transport 
(`id_allotment`, `transport_number`, `pass_unlimited`, `pass_expiration`, `phone_number_temp`) VALUES
(:id_allotment,  :transport_number,  :pass_unlimited,  :pass_expiration, :phone_number_temp)
        ";

        try {
            $sth = DBC()->prepare($query);
            $sth->execute($dataset);
        } catch (\PDOException $e) {
            if ($e->errorInfo[1] == self::MYSQL_ERROR_DUPLICATE_ENTRY) {
                return NULL;
            } else {
                dd($e);
            }
        }

        return DBC()->lastInsertId();
    }

    /**
     * Обновление транспортного средства
     *
     * @param array $dataset
     */
    public function update(array $dataset)
    {

    }

    /**
     * Удаление записи о транспортном средстве по ID
     *
     * @param $id
     */
    public function delete($id)
    {

    }


}