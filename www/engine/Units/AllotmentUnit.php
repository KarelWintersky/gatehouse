<?php


namespace Gatehouse\Units;

use Gatehouse\AbstractUnit;
use function Arris\DBC;

class AllotmentUnit extends AbstractUnit
{
    /**
     * Загружает список всех участков
     * @return array
     */
    public function getAll()
    {
        $query = "SELECT * FROM allotments ORDER BY `id_pipeline`, `name` "; // WHERE посёлок = N

        $sth = DBC()->query($query);

        $allotments = [];
        while ($row = $sth->fetch()) {
            $allotments[] = $row;
        }

        return $allotments;
    }

    /**
     * Загружает информацию об участке по ID
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        $query = "
SELECT a.id as id, p.name as pipeline, a.name as name, owner, IF(status = 'allowed', 1, 0) as status 
FROM 
     allotments AS a,
     pipelines AS p
WHERE a.id = :id AND a.id_pipeline = p.id 
";
        $allotment = [];

        try {
            $sth = DBC()->prepare($query);
            $sth->execute([
                'id'    =>  $id
            ]);

            $allotment = $sth->fetch();
        } catch (\PDOException $e) {
            dd($e);
        }

        return $allotment;
    }

    /**
     * Вставляет данные в таблицу участков
     *
     * @param $dataset
     * @return string|null
     */
    public function insert($dataset)
    {
        $query = "
INSERT INTO allotments 
(`id_pipeline`, `name`, `owner`, `status`) VALUES
(:id_pipeline,  :name,  :owner,  :status)
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
     * Обновляет информацию в базе
     *
     * @param array $dataset
     * @return string
     */
    public function update(array $dataset)
    {
        $query = "
UPDATE allotments SET
`owner` = :owner, `status` = :status
WHERE `id` = :id 
        ";

        try {
            $sth = DBC()->prepare($query);
            $sth->execute($dataset);
        } catch (\PDOException $e) {
            dd($e);
        }

        return DBC()->lastInsertId();
    }

    /**
     * Удаляет по ID
     *
     * @param $id_allotment
     * @return bool
     */
    public function delete($id_allotment)
    {
        try {
            DBC()->beginTransaction();

            $sth = DBC()->prepare("DELETE FROM phones WHERE id_allotment = :id_allotment ");
            $sth->execute([
                'id_allotment'  =>  $id_allotment
            ]);

            $sth = DBC()->prepare("DELETE FROM transport WHERE id_allotment = :id_allotment ");
            $sth->execute([
                'id_allotment'  =>  $id_allotment
            ]);

            $sth = DBC()->prepare("DELETE FROM allotments WHERE id = :id_allotment");
            $sth->execute([
                'id_allotment'  =>  $id_allotment
            ]);

            DBC()->commit();
        } catch (\PDOException $e) {
            DBC()->rollBack();
            return false;
        }

        return true;
    }

    /**
     * Возвращает список участков для селектора
     * @return array
     */
    public function getAllForSelector()
    {
        $query = " SELECT a.id AS id, CONCAT(a.name, ' (', p.name, ')') as name
FROM allotments as a, pipelines as p
WHERE a.id_pipeline = p.id
ORDER BY a.id_pipeline, a.name ";

        $list = [];
        try {
            $sth = DBC()->query($query);
            $list = $sth->fetchAll();
        } catch (\PDOException $e) {
            dd($e);
        }

        return $list;
    }


}