<?php
require_once '../../models/Turn.php';
require_once '../../models/Medic.php';
require_once '../../controllers/core/Controller.php';

class MedicController extends Controller
{
    private $medicModel;
    private $turnModel;

    function __construct()
    {
        $this->medicModel = new Medic();
        $this->turnModel = new Turn();
    }

    private function redirectToHome()
    {
        header("Location: ../../views/core/home.php");
        exit();
    }

    public function returnTurnStatus()
    {
        $turn = $this->turnModel->detailTurnById()['estado'];
        return $turn;
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

    public function updateTurn()
    {
        try {
            $id = $this->getIdUrl();
            $this->turnModel->setId($id);
            $turnStatus = $this->returnTurnStatus();
            if ($turnStatus == "COMPLETADO") {
                $this->turnModel->setStatus("PENDIENTE");
            } else {
                $this->turnModel->setStatus("COMPLETADO");
            }
            $this->turnModel->updateStatusTurnById();
            $this->redirectToHome();
        } catch (Exception $error) {
            $this->handleError($error, "core", "home");
        }
    }
}

$medicController = new MedicController();
$action = strtoupper($medicController->getActionInUrl());

switch ($action) {
    case "UPDATE":
        $medicController->updateTurn();
        break;
}
