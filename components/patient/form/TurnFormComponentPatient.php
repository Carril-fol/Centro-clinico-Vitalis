<?php
require_once '../../controllers/turn/TurnController.php';

$turnController = new TurnController();

function optionsFormated()
{
    global $turnController;
    $specialities = $turnController->medicModel->getSpecialitiesAvailable();
    if (empty($specialities)) {
        echo "<option value=''>No hay especialidades disponibles.</option>";
    } else {
        foreach ($specialities as $row):
?>
            <option value='<?= htmlspecialchars($row['especialidad']); ?>'>
                <?= htmlspecialchars($row['especialidad']); ?>
            </option>
<?php
        endforeach;
    }
}
?>
<form class="form-turn-creation" method="POST" action="../../controllers/patient/PatientController.php?action=create">
    <div class="container-fields-form-turn">
        <div class="form-header">
            <h1>Solicita tu turno</h1>
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
                <?php optionsFormated(); ?>
            </select>
        </div>
        <div class="container-form-button-submit">
            <button type="submit" class="submit-button">Solicitar</button>
        </div>
    </div>
</form>