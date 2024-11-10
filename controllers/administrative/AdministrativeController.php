<?php
require_once "../../models/Administrative.php";
require_once "../../models/TurnRequested.php";
require_once "../../models/Medic.php";
require_once "../../models/Turn.php";
require_once "../../controllers/core/Controller.php";

class AdministrativeController extends Controller
{
    private $administrativeModel;
    private $turnRequestedModel;
    private $medicModel;

    function __construct()
    {
        $this->administrativeModel = new Administrative();
        $this->turnRequestedModel = new TurnRequested();
        $this->medicModel = new Medic();
    }

    private function getMedicForTurn($speciality)
    {
        $medics = $this->medicModel->getMedicsBySpeciality($speciality);
        if (empty($medics)) {
            throw new Exception("No hay medicos disponibles con esa especialidad por el momento");
        }
        return $medics[0];
    }

    private function creationTurnRequested($turnRequestedData)
    {
        // $dniMedic = $this->getMedicForTurn($turnRequestedData['especialidad'])['dni'];
        $dniMedic = $_POST['med'];
        // $this->medicModel->changeStatusMedic($dniMedic, "OCUPADO");
        if (!$this->turnRequestedModel->verificarTurnoSimilar($turnRequestedData['fecha_atencion'], $turnRequestedData['horario'], $dniMedic)) {
            throw new Exception("Ya existe un turno asignado para este médico en la fecha y hora seleccionadas.");
        }
        $this->turnRequestedModel->setStatus("PENDIENTE");
        $this->turnRequestedModel->setDniPatient($turnRequestedData['dni_paciente']);
        $this->turnRequestedModel->setDniMedic($dniMedic);
        $this->turnRequestedModel->setDateAtention($turnRequestedData['fecha_atencion']);
        $this->turnRequestedModel->setTurnTime($turnRequestedData['horario']);
        $this->turnRequestedModel->setSpeciality($turnRequestedData['especialidad']);
        $this->turnRequestedModel->createTurn();
    }

    private function changeStatusTurnRequested($status, $id)
    {
        $this->turnRequestedModel->setId($id);
        $this->turnRequestedModel->setStatus($status);
        $this->turnRequestedModel->updateStatusTurnRequestedById();
    }

    public function showTurnPending()
    {
        return $this->administrativeModel->getTurnsPending();
    }

    public function showTurnRequested()
    {
        return $this->administrativeModel->getTurnsRequested();
    }

    public function assignMedicToATurn()
    {
        try {
            $id = $this->getIdUrl();
            $this->turnRequestedModel->setId($id);
            $turnRequestedData = $this->turnRequestedModel->detailFromTurnRequestedById();
            
            $this->creationTurnRequested($turnRequestedData);
            $this->changeStatusTurnRequested("CONFIRMADO", $id);
            $this->redirectToHome();
        } catch (Exception $error) {
            $this->handleError($error, "core", "home");
        }
    }
    public function mostrarDatosMedicos()
    {
        return $this->administrativeModel->obtenerDatosMedicos();
    }
}

$controller = new AdministrativeController();
$action = strtoupper($controller->getActionInUrl());

switch ($action) {
    case "ASSING":
        $controller->assignMedicToATurn();
        break;
}