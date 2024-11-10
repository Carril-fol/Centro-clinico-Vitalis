<?php
require_once '../../models/Turn.php';
require_once '../../models/Medic.php';
require_once '../../models/TurnRequested.php';
require_once '../../controllers/core/Controller.php';

class TurnRequestedController extends Controller
{
    private $turnRequestedModel;

    public function __construct()
    {
        $this->turnRequestedModel = new TurnRequested();
    }

    public function alreadyExistsTurnRequestedFromPatient($dniPatient)
    {
        $turnAlreadyExists =  $this->turnRequestedModel->existsTurnRequestedByDni($dniPatient);
        if ($turnAlreadyExists) {
            throw new Exception("El paciente ya tiene un turno solicitado.");
        }
    }

    public function deleteTurnRequested($dniPatient)
    {
        $idTurnRequested = $this->turnRequestedModel->detailTurnRequestedConfirmedFromPatientByDni($dniPatient)["id"];
        $this->turnRequestedModel->setId($idTurnRequested);
        $this->turnRequestedModel->setStatus("CANCELADO");
        $this->turnRequestedModel->updateStatusTurnRequestedById();
    }

}