<?php
require_once "../../models/Patient.php";
require_once "../../models/TurnRequested.php";
require_once "../../models/Medic.php";
require_once "../../controllers/core/Controller.php";

class PatientController extends Controller
{
    private $patientModel;
    private $turnRequestedModel;

    function __construct()
    {
        $this->patientModel = new Patient();
        $this->turnRequestedModel = new TurnRequested();
    }

    private function redirectToHome()
    {
        header("Location: ../../views/core/home.php");
        exit();
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
