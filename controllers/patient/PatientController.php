<?php
require_once "../../models/Patient.php";
require_once "../../models/Turn.php";
require_once "../../models/TurnRequested.php";
require_once "../../models/Medic.php";
require_once "../../controllers/core/Controller.php";

class PatientController extends Controller
{
    private $patientModel;
    private $turnModel;
    private $turnRequestedModel;

    function __construct()
    {
        $this->patientModel = new Patient();
        $this->turnModel = new Turn();
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
        $data = $this->getDataFromFormPatient();

        $this->turnModel->setStatus("SOLICITADO");
        $this->turnModel->setDniPatient($data['dniPatient']);
        $this->turnModel->setDateAtention($data['dateAtention']);
        $this->turnModel->setTurnTime($data['turnTime']);
        $this->turnModel->setSpeciality($data['speciality']);
        $this->turnRequestedModel->createTurnRequested();
        $this->redirectToHome();
    }
}

$controller = new PatientController();
$action = $controller->getActionInUrl();

switch ($action) {
    case "CREATE":
        $createdTurn = $controller->registerTurnPatient();
        break;
}