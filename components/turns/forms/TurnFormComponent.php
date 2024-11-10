<?php
require_once "../../controllers/turn/TurnController.php";
require_once "../../controllers/core/HomeController.php";

$turnController = new TurnController();
$homeController = new HomeController();

$rolFromUser = $homeController->getRolFromUser();
$validationRolFromUser = $homeController->validateRolFromUser($rolFromUser, "administrativo");

function optionsFormated()
{
    global $turnController;
    $specialities = $turnController->medicModel->getSpecialitiesAvailable();
    if (empty($specialities)) {
        echo "<option value=''>No hay especialidades disponibles.</option>";
    } else {
        foreach ($specialities as $row) {
?>
            <option value='<?= htmlspecialchars($row['especialidad']); ?>'>
                <?= htmlspecialchars($row['especialidad']); ?>
            </option>
<?php
        }
    }
}

function optionsTimeFormated()
{
    $timeStart = new DateTime("9:00");
    $timeEnd = new DateTime("18:00");

    for ($time = $timeStart; $time <= $timeEnd; $time->modify("+30 minutes")) {
        $timeValue = $time->format("H:i");
        echo "<option value='$timeValue'>$timeValue</option>";
    }
}
?>
<form class="form-turn-creation" method="POST" action="../../controllers/turn/TurnController.php?action=create">
    <div class="container-fields-form-turn">
        <div class="form-header">
            <h1>Registro de Turnos para Pacientes</h1>
        </div>

        <div class="container-field">
            <label for="dniPatient">Dni del paciente</label>
            <input type='text' name='dniPatient'>
        </div>

        <div class="container-field">
            <label for="dateAtention">Fecha de turno</label>
            <input type="date" id="dateAtention" name="dateAtention" required placeholder="Selecciona la fecha" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-12-31'); ?>">
        </div>

        <div class="container-field">
            <label for="timeAtention">Hora de turno</label>
            <select type="time" id="timeAtention" name="timeAtention" required>
                <?php optionsTimeFormated() ?>
            </select>
        </div>

        <div class="container-field">
            <label for="speciality">Especialidad</label>
            <select id="speciality" name="speciality" required>
                <option value="" disabled selected>Selecciona una especialidad</option>
                <?php optionsFormated($specialities); ?>
            </select>
        </div>
        <div class="container-form-button-submit">
            <button type="submit" class="submit-button">Crear</button>
        </div>
    </div>
</form>