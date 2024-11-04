<?php
require_once "../../models/Patient.php";
require_once "../../controllers/core/Controller.php";
require_once "../../controllers/turn/TurnController.php";

class PatientController extends Controller
{
    private $patientModel;
    private $turnController;

    function __construct()
    {
        $this->patientModel = new Patient();
        $this->turnController = new TurnController();
    }

    private function redirectToHome()
    {
        header("refresh:3; url=home.php");
        exit();
    }
    public function showTurnFromPatient()
    {
        $dniInCookies = $this->getDniFromToken();
        $turns = $this->patientModel->getTurnsFromPatientByDni($dniInCookies);
        return $turns;
    }

    private function getFormatedDataFromForm()
    {
        $dniUser = $this->getDniFromToken();
        $data = $this->turnController->getDataFromForm();
        $data["dniPatient"] = $dniUser;
        return $data;
    }

    public function createTurn() 
    {
        $data = $this->getFormatedDataFromForm();
        var_dump($data);
        //$this->turnController->createTurn($data);
        ///$this->redirectToHome();
    }
}

$patientController = new PatientController();
$action = strtoupper($patientController->getActionInUrl());

switch ($action) {
    case "CREATE":
        $createdTurn = $patientController->createTurn();
        break;
}