<?php
require_once "../../models/Patient.php";
require_once "../../models/TurnRequested.php";
require_once "../../models/Turn.php";
require_once "../../models/Medic.php";
require_once "../../controllers/core/Controller.php";

class PatientController extends Controller
{
    private $patientModel;
    private $turnRequestedModel;
    private $turnModel;

    function __construct()
    {
        $this->patientModel = new Patient();
        $this->turnRequestedModel = new TurnRequested();
        $this->turnModel = new Turn();
    }

    private function getDataFromFormPatient()
    {
        return [
            'dniPatient' => $this->sanitizeInput($this->getDniFromToken()),
            'dateAtention' => $this->sanitizeInput($_POST['dateAtention']),
            'turnTime' => $this->sanitizeInput($_POST['timeAtention']),
            'speciality' => strtoupper($this->sanitizeInput($_POST['speciality']))
        ];
    }

    private function alreadyExistsTurnRequestedFromPatient($dniPatient)
    {
        $turnAlreadyExists =  $this->turnRequestedModel->existsTurnRequestedByDni($dniPatient);
        if ($turnAlreadyExists) {
            throw new Exception("El paciente ya tiene un turno solicitado.");
        }
    }

    private function validateIfTimeAtentionIsAvailable($turnDay, $turnTimeActual)
    {
        $turnTimeActualFormatted = date("H:i:s", strtotime($turnTimeActual . ":00"));
        $timeArray = [];
        $turns = $this->turnModel->getAllTurnByDay($turnDay);
        if ($turns == false) {
            return true;
        }
        foreach ($turns as $turn) {
            array_push($timeArray, $turn["horario"]);
        }
        foreach ($timeArray as $turnTime) {
            if (strcmp($turnTimeActualFormatted, $turnTime) === 1) {
                throw new Exception(("Ya existe un turno registrado para el día " . $turnDay . " a las " . $turnTimeActual . ". Por favor, seleccione una hora diferente."));
            }
        }
        return true;
    }

    public function showTurnRequestedFromPatient()
    {
        $dniInCookies = $this->getDniFromToken();
        return $this->patientModel->getTurnsRequestedFromPatientByDni($dniInCookies);
    }

    public function showHistoryTurnsFromPatient()
    {
        $dniInCookies = $this->getDniFromToken();
        return $this->patientModel->getTurnsCanceledOrCompletedFromPatientByDni($dniInCookies);
    }

    public function registerTurnPatient()
    {
        try {
            $data = $this->getDataFromFormPatient();
            $this->validateIfTimeAtentionIsAvailable($data["dateAtention"], $data["turnTime"]);
            $this->alreadyExistsTurnRequestedFromPatient($data["dniPatient"]);
            $this->turnRequestedModel->setStatus("SOLICITADO");
            $this->turnRequestedModel->setDniPatient($data['dniPatient']);
            $this->turnRequestedModel->setDateAtention($data['dateAtention']);
            $this->turnRequestedModel->setTurnTime($data['turnTime']);
            $this->turnRequestedModel->setSpeciality($data['speciality']);
            $this->turnRequestedModel->createTurnRequested();
            $this->redirectToHome();
        } catch (Exception $error) {
            $this->handleError($error, "patient", "create");
        }
    }
}

$controller = new PatientController();
$action = strtoupper($controller->getActionInUrl());

switch ($action) {
    case "CREATE":
        $createdTurn = $controller->registerTurnPatient();
        break;
}
