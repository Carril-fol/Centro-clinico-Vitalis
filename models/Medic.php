<?php
require_once  __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/User.php';

class Medic
{
    private $db;

    public function __construct() {
        $this->db = (new Database())->connection();
    }

    private function checkIfMedicExists($medicLicense){
        $paramsQuery = [":matricula" => $medicLicense];
        $selectQuery = "SELECT matricula FROM medico WHERE matricula = :matricula";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->rowCount() > 0;
    }

    public function createMedic(int $dni, string $medicLicense, string $medicSpeciality){
        if ($this->checkIfMedicExists($medicLicense)) {
            return false;
        }
        $paramsQuery = [
            ":dni" => $dni, 
            ":matricula" => $medicLicense, 
            ":medicSpeciality" => $medicSpeciality,
            ":status" => "DESOCUPADO"
        ];
        $insertQuery = "INSERT INTO medico (dni, matricula, especialidad, estado) VALUES (:dni, :medicLicense, :medicSpeciality, :status)";
        $resultQuery = $this->db->prepare($insertQuery);
        $resultQuery->execute($paramsQuery);
        return true;
    }

    public function getMedicByDni($dni){   
        $paramsQuery = [":dni" => $dni];
        $selectQuery = "SELECT * FROM medico WHERE $dni = :dni";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        $row = $resultQuery->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getMedicsBySpeciality($speciality) {
        $paramsQuery = [":speciality" => $speciality, ":status" => "DESOCUPADO"];
        $selectQuery = "SELECT dni, especialidad FROM medico WHERE estado = :status AND especialidad = :speciality";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        $rows = $resultQuery->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function changeStatusMedic($dniMedic, $status) {
        $paramsQuery = [":dniMedic" => $dniMedic, ":status" => $status];
        $selectQuery = "UPDATE medico set estado = :status WHERE dni = :dniMedic";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->rowCount() > 0;
    }

}

?>