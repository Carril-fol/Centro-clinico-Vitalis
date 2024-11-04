<?php
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/../config.php';

class Administrative
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connection();
    }
    
    private function checkIfAdministrativeExists($paramsQuery)
    {
        $selectQuery = "SELECT dni FROM administrativo WHERE dni = :dni";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->rowCount() > 0;
    }

    public function createAdministrative(int $dni)
    {
        $paramsQuery = [':dni'=>$dni];
        $checkIfAdministrativeExists = $this->checkIfAdministrativeExists($paramsQuery);
        if ($checkIfAdministrativeExists) {
            return false;
        }
        $insertQuery = "INSERT INTO administrativo (dni) VALUES (:dni)";
        $resultQuery = $this->db->prepare($insertQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery;
    }

    public function getAdministrativeByDni($dni)
    {
        $paramsQuery = [':dni'=>$dni];
        $selectQuery = "SELECT * FROM administrativo WHERE dni = :dni";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        $row = $resultQuery->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getTurnsRequested()
    {
        $selectQuery = "SELECT * FROM turnos_solicitados WHERE estado = 'SOLICITADO'";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute();
        return $resultQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTurnsPending()
    {
        $selectQuery = "SELECT * FROM turno WHERE estado = 'PENDIENTE'";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute();
        return $resultQuery->fetchAll(PDO::FETCH_ASSOC);
    }
}