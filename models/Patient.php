<?php
require_once  __DIR__ . '/../config.php';

class Patient
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connection();
    }

    public function createPatient(int $dni)
    {
        $paramsQuery = [":dni" => $dni];
        $insertQuery = "INSERT INTO paciente (dni) VALUES (:dni)";
        $resultQuery = $this->db->prepare($insertQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery;
    }

    public function getPatientByDni($dni)
    {
        $paramsQuery = [":dni" => $dni];
        $selectQuery = "SELECT * FROM paciente WHERE dni = :dni";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        $row = $resultQuery->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getTurnsRequestedFromPatientByDni($dni)
    {
        $paramsQuery = [":dni" => $dni];
        $selectQuery = "SELECT * FROM turnos_solicitados WHERE dni_paciente = :dni";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        $rows = $resultQuery->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function getTurnsCanceledOrCompletedFromPatientByDni($dni)
    {
        $paramsQuery = [":dni" => $dni];
        $selectQuery = "SELECT * FROM turno WHERE dni_paciente = :dni AND estado in ('CANCELADO', 'COMPLETADO')";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        $rows = $resultQuery->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
}
?>