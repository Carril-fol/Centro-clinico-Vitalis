<?php
require_once '../../models/Turn.php';
require_once '../../models/TurnRequested.php';
require_once '../../models/Medic.php';
require_once '../../controllers/core/Controller.php';

class MedicController extends Controller
{
    private $medicModel;
    private $turnModel;
    private $turnRequestedModel;

    function __construct()
    {
        $this->medicModel = new Medic();
        $this->turnModel = new Turn();
        $this->turnRequestedModel = new TurnRequested();
    }

    private function redirectToHome()
    {
        header("Location: ../../views/core/home.php");
        exit();
    }

    private function actualizeStatusTurnRequested($idTurnParent)
    {
        $this->turnModel->setId($idTurnParent);
        $dniPatient = $this->turnModel->detailTurnById()["dni_paciente"];
        
        $dataTurn = $this->turnRequestedModel->detailTurnRequestedConfirmedFromPatientByDni($dniPatient);
        if ($dataTurn == false) {
            return;
        }

        if ($dataTurn["estado"] == "COMPLETADO") {
            $this->turnRequestedModel->setStatus("CONFIRMADO");
        } else {
            $this->turnRequestedModel->setStatus("COMPLETADO");
        }

        $this->turnRequestedModel->setId($dataTurn["id"]);
        $this->turnRequestedModel->updateStatusTurnRequestedById();
    }

    private function actualizeStatusTurn($idTurn)
    {
        $this->turnModel->setId($idTurn);
        $dataTurn = $this->turnModel->detailTurnById();
    
        if ($dataTurn["estado"] == "COMPLETADO") {
            $this->turnModel->setStatus("PENDIENTE");
        } else {
            $this->turnModel->setStatus("COMPLETADO");
        }
        $this->turnModel->updateStatusTurnById();
        $dataUpdatedTurn = $this->turnModel->detailTurnById();
        return $dataUpdatedTurn;
    }

    private function actualizeStatusMedic($dniMedic, $statusTurn)
    {
        if ($statusTurn == "COMPLETADO") {
            $this->medicModel->changeStatusMedic($dniMedic, "DESOCUPADO");
        } elseif ($statusTurn == "PENDIENTE") {
            $this->medicModel->changeStatusMedic($dniMedic, "OCUPADO");
        }
    }

    public function showAllTurnAvailableFromMedic()
    {
        $dniMedic = $this->getDniFromToken();
        $turnsFromMedic = $this->medicModel->getTurnsForMedicByDni($dniMedic, "PENDIENTE");
        return $turnsFromMedic;
    }

    public function showAllTurnsCompletedFromMedic()
    {
        $dniMedic = $this->getDniFromToken();
        $turnsFromMedic = $this->medicModel->getTurnsForMedicByDni($dniMedic, "COMPLETADO");
        return $turnsFromMedic;
    }

    public function updateTurns()
    {
        try {
            $id = $this->getIdUrl();
            $turnDataUpdated = $this->actualizeStatusTurn($id);
            $this->actualizeStatusMedic($turnDataUpdated["dni_medico"], $turnDataUpdated["estado"]);
            $this->actualizeStatusTurnRequested($id);
            $this->redirectToHome();
        } catch (Exception $error) {
            $this->handleError($error, "core", "home");
        }
    }

}

$controller = new MedicController();
$action = strtoupper($controller->getActionInUrl());

switch ($action) {
    case "UPDATE":
        $controller->updateTurns();
        break;
}
