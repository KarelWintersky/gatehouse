<?php


namespace Gatehouse\Units;

use function Arris\DBC;

class TransportUnit
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