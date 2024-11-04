<?php
require_once "../../controllers/turn/TurnController.php";
require_once "../../controllers/core/HomeController.php";

$turnController = new TurnController();
$homeController = new HomeController();

$rolFromUser = $homeController->getRolFromUser();
$validationRolFromUser = $homeController->validateRolFromUser($rolFromUser, "administrativo");

function optionsFormated() {
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
            <input type="date" id="dateAtention" name="dateAtention" required placeholder="Selecciona la fecha">
        </div>

        <div class="container-field">
            <label for="timeAtention">Hora de turno</label>
            <input type="time" id="timeAtention" name="timeAtention" min="09:00" max="18:00" required>
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