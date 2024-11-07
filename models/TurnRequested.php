<?php
require_once  __DIR__ . '/../config.php';
require_once "Turn.php";

class TurnRequested extends Turn
{
    public function __construct() {
        parent::__construct();
    }

    public function setProperties($id, $dniPatient, $dateAtention, $dateCreation, $turnTime, $status, $speciality) {
        $this->id = $id;
        $this->dniPatient = $dniPatient;
        $this->dateAtention = $dateAtention;
        $this->dateCreation = $dateCreation;
        $this->turnTime = $turnTime;
        $this->status = $status;
        $this->speciality = $speciality;
    }

    public function existsTurnRequestedByDni($dniPatient)
    {
        $paramsQuery = [":dni" => $dniPatient];
        $selectQuery = "SELECT * FROM turnos_solicitados WHERE dni_paciente = :dni AND estado IN ('CONFIRMADO', 'SOLICITADO')";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->rowCount() > 0;
    }

    public function createTurnRequested()
    {
        $paramsQuery = [
            ":dniPatient" => $this->dniPatient,
            ":dateAtention" => $this->dateAtention,
            ":dateCreation" =>  $this->dateCreation,
            ":turnTime" => $this->turnTime,
            ":status" => $this->status,
            ":speciality" => $this->speciality
        ];
        $insertQuery = "INSERT INTO turnos_solicitados (
            dni_paciente,
            fecha_atencion,
            fecha_creacion,
            horario,
            estado,
            especialidad
        ) VALUES (
            :dniPatient,
            :dateAtention,
            :dateCreation,
            :turnTime,
            :status,
            :speciality
        )";
        $resultQuery = $this->db->prepare($insertQuery);
        return $resultQuery->execute($paramsQuery);
    }

    public function detailFromTurnRequestedById()
    {
        $paramsQuery = [":id" => $this->id];
        $selectQuery = "SELECT * FROM turnos_solicitados WHERE id = :id";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatusTurnRequestedById()
    {
        $paramsQuery = [":id" => $this->id, ":status" => $this->status];
        $updateQuery = "UPDATE turnos_solicitados SET estado = :status WHERE id = :id";
        $resultQuery = $this->db->prepare($updateQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->rowCount();
    }
}
