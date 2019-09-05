<?php


namespace Gatehouse\Units;

use function Arris\DBC;

class PipelinesUnit
{
    /**
     * Загружает список очередей застройки
     * @return array
     */
    public function getPipelines()
    {
        $query = " SELECT * FROM pipelines";
        $sth = DBC()->query($query);

        return $sth->fetchAll();
    }

}