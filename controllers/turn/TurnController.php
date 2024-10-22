<?php
    require_once '../../models/Turn.php';
    require_once '../../models/Medic.php';
    require_once '../../controllers/core/Controller.php';

    class TurnController extends Controller
    {
        private $turnModel; 
        private $medicModel;

        function __construct() {
            $this->turnModel = new Turn;
            $this->medicModel = new Medic;
        }

        private function redirectToHome() {
            header("Location: ../../views/core/home.php");
            exit();
        }

        private function getMedicForTurn($speciality) {
            $medics = $this->medicModel->getMedicsBySpeciality($speciality);
            if (empty($medics)) {
                throw new Exception("No hay medicos disponibles con esa especialidad por el momento");
            }
            return $medics[0];
        }

        private function getDataFromForm() {
            $data = [
                'dniPatient' => $this->sanitizeInput($_POST['dniPatient']),
                'dateAtention' => $this->sanitizeInput($_POST['dateAtention']),
                'turnTime' => $this->sanitizeInput($_POST['timeAtention']),
                'speciality' => strtoupper($this->sanitizeInput($_POST['speciality']))
            ];
            return $data;
        }

        private function createTurn($turnData) {
            $dniMedic = $this->getMedicForTurn($turnData['speciality'])['dni'];
            $this->medicModel->changeStatusMedic($dniMedic, "OCUPADO");
    
            $this->turnModel->setDniPatient($turnData['dniPatient']);
            $this->turnModel->setDniMedic($dniMedic);
            $this->turnModel->setDateAtention($turnData['dateAtention']);
            $this->turnModel->setTurnTime($turnData['turnTime']);
            $this->turnModel->setSpeciality($turnData['speciality']);
            $this->turnModel->createTurn();
        }

        private function deleteTurnById($id) {
            $this->turnModel->setId($id);
            $deletedTurn = $this->turnModel->deleteTurnById();
            if ($deletedTurn < 1) {
                throw new Exception("No se encontró un turno con esa ID o el estado ya estaba cancelado.");
            }
        }

        public function registerTurn() {
            try {
                $turnData = $this->getDataFromForm();
                $this->createTurn($turnData);
                $this->redirectToHome();
            } catch (Exception $error) {
                $this->handleError($error, 'turn', 'create');
            }
        }

        public function deleteTurn() {
            try {
                $id = $this->getIdUrl();
                $this->deleteTurnById($id);
                $this->redirectToHome();
            } catch (Exception $error) {
                $this->handleError($error, "core", "home");
            }
        }

        public function showTurnsAvailable() {
            $turns = $this->turnModel->getAllTurnsAvailable();
            return $turns;
        }
    }

    $turnController = new TurnController();    
    $action = strtoupper($turnController->getActionInUrl());

    switch ($action) {
        case "DELETE":
            $deletedTurn = $turnController->deleteTurn();
            break;
        case "CREATE":
            $createdTurn = $turnController->registerTurn();
            break;
        }
?>