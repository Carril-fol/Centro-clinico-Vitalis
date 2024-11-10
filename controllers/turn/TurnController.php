<?php
require_once '../../models/Turn.php';
require_once '../../models/Medic.php';
require_once 'TurnRequestedController.php';
require_once '../../controllers/core/Controller.php';

class TurnController extends Controller
{
    public $turnModel;
    public $turnRequestedController;
    public $medicModel;

    function __construct()
    {
        $this->turnModel = new Turn();
        $this->medicModel = new Medic();
        $this->turnRequestedController = new TurnRequestedController();
    }

    private function redirectToEditTurn($error, $folder, $file, $id)
    {
        session_start();
        $_SESSION['error'] = $error->getMessage();
        header("Location: ../../views/" . $folder . "/" . $file . ".php" . "?action=update%id=" . $id);
        exit();
    }

    private function getMedicForTurn($speciality)
    {
        $medics = $this->medicModel->getMedicsBySpeciality($speciality);
        if (empty($medics)) {
            throw new Exception("No hay medicos disponibles con esa especialidad por el momento");
        }
        return $medics[0];
    }

    private function alreadyExistsTurnFromPatient($dniPatient)
    {
        $turnAlreadyExists =  $this->turnModel->existsTurnByDni($dniPatient);
        if ($turnAlreadyExists) {
            throw new Exception("El paciente ya se encuentra con un turno, espere a que termine este turno o eliminelo si es un error.");
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

    public function getDataFromForm()
    {
        return [
            'dniPatient' => $this->sanitizeInput($_POST['dniPatient']),
            'dateAtention' => $this->sanitizeInput($_POST['dateAtention']),
            'turnTime' => $this->sanitizeInput($_POST['timeAtention']),
            'speciality' => strtoupper($this->sanitizeInput($_POST['speciality']))
        ];
    }

    public function createTurn($turnData)
    {
        try {
            $this->turnRequestedController->alreadyExistsTurnRequestedFromPatient($turnData["dniPatient"]);
            $this->alreadyExistsTurnFromPatient($turnData["dniPatient"]);
            $this->validateIfTimeAtentionIsAvailable($turnData["dateAtention"], $turnData["turnTime"]);

            $dniMedic = $this->getMedicForTurn($turnData['speciality'])['dni'];
            $this->medicModel->changeStatusMedic($dniMedic, "OCUPADO");
            $this->turnModel->setStatus("PENDIENTE");
            $this->turnModel->setDniPatient($turnData['dniPatient']);
            $this->turnModel->setDniMedic($dniMedic);
            $this->turnModel->setDateAtention($turnData['dateAtention']);
            $this->turnModel->setTurnTime($turnData['turnTime']);
            $this->turnModel->setSpeciality($turnData['speciality']);
            $this->turnModel->createTurn();
        } catch (Exception $error) {
            $this->handleError($error, "core", "home");
        }
    }

    private function deleteTurnById($id)
    {
        $this->turnModel->setId($id);
        $deletedTurn = $this->turnModel->deleteTurnById();
        if ($deletedTurn < 1) {
            throw new Exception("No se encontró un turno con esa ID o el estado ya estaba cancelado.");
        }
    }

    public function detailTurn()
    {
        try {
            $id = $this->getIdUrl();
            $this->turnModel->setId($id);
            return $this->turnModel->detailTurnById();
        } catch (Exception $error) {
            $this->handleError($error, folder: "core", file: "home");
        }
    }

    private function actualizeTurn($turnData, $id)
    {
        $turnDataInDatabase = $this->detailTurn();
        if ($turnData['speciality'] != $turnDataInDatabase['especialidad']) {
            $dniMedicTurnInDatabase = $turnDataInDatabase['dni_medico'];
            $this->medicModel->changeStatusMedic($dniMedicTurnInDatabase, "DESOCUPADO");
        }
        $dniMedic = $this->getMedicForTurn($turnData['speciality'])['dni'];
        $this->medicModel->changeStatusMedic($dniMedic, "OCUPADO");
        $this->turnModel->setId($id);
        $this->turnModel->setDniPatient($turnData['dniPatient']);
        $this->turnModel->setDniMedic($dniMedic);
        $this->turnModel->setDateAtention($turnData['dateAtention']);
        $this->turnModel->setTurnTime($turnData['turnTime']);
        $this->turnModel->setSpeciality($turnData['speciality']);
        $this->turnModel->updateTurnById();
    }

    public function registerTurn()
    {
        try {
            $turnData = $this->getDataFromForm();
            $this->createTurn($turnData);
            $this->redirectToHome();
        } catch (Exception $error) {
            $this->handleError($error, folder: 'turn', file: 'create');
        }
    }

    public function deleteTurn()
    {
        try {
            $id = $this->getIdUrl();
            $this->turnModel->setId($id);
            $turnData = $this->detailTurn();
            $this->turnRequestedController->deleteTurnRequested($turnData["dni_paciente"]);
            $this->medicModel->changeStatusMedic($turnData['dni_medico'], "DESOCUPADO");
            $this->deleteTurnById($id);
            $this->redirectToHome();
        } catch (Exception $error) {
            $this->handleError($error, folder: "core", file: "home");
        }
    }

    public function showTurnsAvailable()
    {
        return $this->turnModel->getAllTurnsAvailable();
    }

    public function updateTurn()
    {
        try {
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $id = $this->getIdUrl();
            if ($requestMethod == "GET") {
                return $this->detailTurn();
            } elseif ($requestMethod == "POST") {
                $turnFormData = $this->getDataFromForm();
                $this->actualizeTurn($turnFormData, $id);
                $this->redirectToHome();
            }
        } catch (Exception $error) {
            $this->redirectToEditTurn($error, 'turn', 'update', $id);
        }
    }
}

$controller = new TurnController();
$action = strtoupper($controller->getActionInUrl());

switch ($action) {
    case "DELETE":
        $deletedTurn = $controller->deleteTurn();
        break;
    case "CREATE":
        $createdTurn = $controller->registerTurn();
        break;
    case "UPDATE":
        $updateTurn = $controller->updateTurn();
        break;
}
