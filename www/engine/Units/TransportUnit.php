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
     * @return array
     */
    public function get($id)
    {
        $query = "
SELECT
	t.id AS id, 
	p.name AS pipeline_name, 
	id_allotment,
	pass_unlimited AS is_pass_unlimited,
	COALESCE(pass_expiration, CURDATE()) AS pass_expiration,
	transport_number,
	phone_number_temp
FROM transport AS t, pipelines AS p, allotments AS a
WHERE t.id_allotment = a.id AND a.pipeline = p.id AND t.id = :id
        ";

        $transport = [];

        try {
            $sth = DBC()->prepare($query);
            $sth->execute([
                'id'    =>  $id
            ]);

            $transport = $sth->fetch();
        } catch (\PDOException $e) {
            dd($e);
        }

        return $transport;
    }

    /**
     * Вставка нового транспортного средства
     *
     * @param array $dataset
     * @return array
     */
    public function insert(array $dataset)
    {
        $response = self::initResponse();

        $query = "
INSERT INTO transport 
(`id_allotment`, `transport_number`, `pass_unlimited`, `pass_expiration`, `phone_number_temp`) VALUES
(:id_allotment,  :transport_number,  :pass_unlimited,  :pass_expiration, :phone_number_temp)
        ";

        try {
            $sth = DBC()->prepare($query);
            $sth->execute($dataset);

            $response['result'] = DBC()->lastInsertId();

            $response['error'] = 0;

        } catch (\PDOException $e) {
            $response['error'] = $e->getCode();
            $response['errorMsg'] = $e->getMessage();

            if ($e->errorInfo[1] == self::MYSQL_ERROR_DUPLICATE_ENTRY) {
                $response['error'] = self::MYSQL_ERROR_DUPLICATE_ENTRY;
            }
        }

        return $response;
    }

    /**
     * Обновление транспортного средства
     *
     * @param array $dataset
     * @return string
     */
    public function update(array $dataset)
    {
        $query = "
UPDATE transport 
SET
    `transport_number`  =   :transport_number,
    `pass_unlimited`    =   :pass_unlimited,
    `pass_expiration`   =   :pass_expiration,
    `phone_number_temp` =   :phone_number_temp
WHERE
    `id` = :id
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
     * Удаление записи о транспортном средстве по ID
     *
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $result = self::initResponse();

        $query = " DELETE FROM transport WHERE id = :id ";

        try {
            $sth = DBC()->prepare($query);
            $sth->execute([
                'id'    =>  $id
            ]);
            $result['error'] = 0;

        } catch (\PDOException $e) {
            $result['error'] = $e->getCode();
            $result['errorMsg'] = $e->getMessage();
        }

        return $result;
    }

}