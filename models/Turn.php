<?php
require_once  __DIR__ . '/../config.php';

class Turn
{
    public $db;
    public $id;
    public $dniPatient;
    public $dniMedic;
    public $dateAtention;
    public $dateCreation;
    public $turnTime;
    public $speciality;
    public $status;

    public function __construct($id = null, $dniPatient = null, $dniMedic = null, $dateAtention = null, $turnTime = null, $speciality = null, $status = null)
    {
        $this->db = (new Database())->connection();
        $this->dniPatient = $dniPatient;
        $this->dniMedic = $dniMedic;
        $this->dateAtention = $dateAtention;
        $this->dateCreation = date("Y-m-d");
        $this->turnTime = $turnTime;
        $this->speciality = $speciality;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->dniPatient;
    }

    public function setId($id)
    {
        if ($id < 0) {
            throw new Exception("Las ID no pueden ser menores a 1");
        }
        $this->id = $id;
    }

    public function getDniPatient()
    {
        return $this->dniPatient;
    }

    public function setDniPatient($dniPatient)
    {
        $this->dniPatient = $dniPatient;
    }

    public function getDniMedic()
    {
        return $this->dniMedic;
    }

    public function setDniMedic($dniMedic)
    {
        $this->dniMedic = $dniMedic;
    }

    public function getDateAtention()
    {
        return $this->dateAtention;
    }

    public function setDateAtention($dateAtention)
    {
        $dateToday = date("Y-m-d");
        if ($dateAtention < $dateToday) {
            throw new Exception("La fecha de atención no puede ser menor a la de hoy.");
        }
        $this->dateAtention = $dateAtention;
    }

    public function getTurnTime()
    {
        return $this->turnTime;
    }

    public function setTurnTime($turnTime)
    {
        $this->turnTime = $turnTime;
    }

    public function getSpeciality()
    {
        return $this->speciality;
    }

    public function setSpeciality($speciality)
    {
        $this->speciality = $speciality;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    public function existsTurnByDni($dniPatient)
    {
        $paramsQuery = [":dni" => $dniPatient];
        $selectQuery = "SELECT * FROM turno WHERE dni_paciente = :dni AND estado IN ('PENDIENTE', 'CONFIRMADO')";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->rowCount() > 0;
    }

    public function createTurn()
    {
        $paramsQuery = [
            ":dniPatient" => $this->dniPatient,
            ":dniMedic" => $this->dniMedic,
            ":dateAtention" => $this->dateAtention,
            ":dateCreation" =>  $this->dateCreation,
            ":turnTime" => $this->turnTime,
            ":status" => $this->status,
            ":speciality" => $this->speciality
        ];
        $insertQuery = "INSERT INTO turno (
            dni_paciente,
            dni_medico,
            fecha_atencion,
            fecha_creacion,
            horario,
            estado,
            especialidad
        ) VALUES (
            :dniPatient,
            :dniMedic,
            :dateAtention,
            :dateCreation,
            :turnTime,
            :status,
            :speciality
        )";
        $resultQuery = $this->db->prepare($insertQuery);
        return $resultQuery->execute($paramsQuery);
    }

    public function getAllTurnsAvailable()
    {
        $selectQuery = "SELECT * FROM turno WHERE estado = 'PENDIENTE'";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute();
        $rows = $resultQuery->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function deleteTurnById()
    {
        $paramsQuery = [":id" => $this->id];
        $deleteQuery = "UPDATE turno
                        SET estado = 'CANCELADO'
                        WHERE id = :id";
        $resultQuery = $this->db->prepare($deleteQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->rowCount();
    }

    public function updateTurnById()
    {
        $paramsQuery = [
            ":id" => $this->id,
            ":dniPatient" => $this->dniPatient,
            ":dateAtention" => $this->dateAtention,
            ":turnTime" => $this->turnTime,
            ":dniMedic" => $this->dniMedic,
            ":speciality" => $this->speciality
        ];
        $updateQuery = "UPDATE turno
                        SET dni_paciente = :dniPatient, dni_medico = :dniMedic, fecha_atencion = :dateAtention, horario = :turnTime, especialidad = :speciality 
                        WHERE id = :id";
        $resultQuery = $this->db->prepare($updateQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->rowCount();
    }

    public function detailTurnById()
    {
        $paramsQuery = [":id" => $this->id];
        $selectQuery = "SELECT * FROM turno WHERE id = :id";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatusTurnById()
    {
        $paramsQuery = [
            ":status" => $this->status,
            ":id" => $this->id
        ];
        $updateQuery = "UPDATE turno SET estado = :status WHERE id = :id";
        $resultQuery = $this->db->prepare($updateQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->rowCount();
    }

    public function getAllTurnByDay($date)
    {
        $paramsQuery = [":date"=>$date];
        $selectQuery = "SELECT * FROM turno WHERE fecha_atencion = :date AND estado = 'PENDIENTE'";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->fetchAll(PDO::FETCH_ASSOC);
    }
    public function verificarTurnoSimilar($fecha,$hora,$medico)
    {
        $paramsQuery = [':fecha' =>$fecha,':hora' =>$hora,':medico' =>$medico];
        $selectQuery = "SELECT * FROM turno WHERE fecha_atencion = :fecha AND horario = :hora AND dni_medico = :medico";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        if ($resultQuery->fetch()) {
            return false;
        }
    
        return true;
    }
}
