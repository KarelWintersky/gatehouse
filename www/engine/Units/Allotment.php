<?php


namespace Gatehouse\Units;


use function Arris\DBC;
use function Arris\DBC as DBCAlias;

class Allotment
{
    public function getAll()
    {
        $query = "SELECT * FROM allotments"; // WHERE посёлок = N

        $sth = DBCAlias()->query($query);

        $allotments = [];
        while ($row = $sth->fetch()) {
            $allotments[] = $row;
        }

        return $allotments;
    }

    public function get($allotment_id)
    {
        $query = " SELECT * FROM allotments WHERE id = :id ";
        $sth = DBCAlias()->prepare();
        $sth->execute([
            'id'    =>  $allotment_id
        ]);

        return $sth->fetch();
    }

    public function insert($dataset)
    {
        return true;
    }


}