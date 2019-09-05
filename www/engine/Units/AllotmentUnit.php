<?php


namespace Gatehouse\Units;


use function Arris\DBC;

class AllotmentUnit
{
    const MYSQL_ERROR_DUPLICATE_ENTRY = 1062;
    /**
     * Загружает список всех участков
     * @return array
     */
    public function getAll()
    {
        $query = "SELECT * FROM allotments"; // WHERE посёлок = N

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
WHERE a.id = :id AND a.pipeline = p.id 
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
(`pipeline`, `name`, `owner`, `status`) VALUES
(:pipeline,  :name,  :owner,  :status)
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
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $query = " DELETE FROM allotments WHERE id = :id ";

        try {
            $sth = DBC()->prepare($query);
            $sth->execute([
                'id'    =>  $id
            ]);
        } catch (\PDOException $e) {
            dd($e);
            return false;
        }
        return true;
    }


}