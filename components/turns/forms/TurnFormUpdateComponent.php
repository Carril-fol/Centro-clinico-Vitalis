<?php
require_once '../../controllers/turn/TurnController.php';

$turnController = new TurnController();

function optionsFormated()
{
    global $turnController;
    $specialities = $turnController->medicModel->getSpecialitiesAvailable();
    $turnData = $turnController->detailTurn();
    ?>
    <option value='<?php echo htmlspecialchars($turnData['especialidad']); ?>' selected>
        <?php echo htmlspecialchars($turnData['especialidad']); ?>
    </option>
    <?php
    foreach ($specialities as $row) {
        ?>
            <option value='<?php echo htmlspecialchars($row['especialidad']); ?>'>
                <?php echo htmlspecialchars($row['especialidad']); ?>
            </option>
        <?php
    }
}
?>
<form class="form-turn-creation" method='POST' action="../../controllers/turn/TurnController.php?action=update&id=<?php echo $turnData['id']; ?>">
    <div class="container-fields-form-turn">
        <div class="form-header">
            <h1>Actualizar Turnos de Pacientes</h1>
        </div>

        <div class="container-field">
            <label for="dniPatient">Dni del paciente</label>
            <input type='text' name='dniPatient' value='<?php echo htmlspecialchars($turnData['dni_paciente']); ?>'>
        </div>

        <div class="container-field">
            <label for="dateAtention">Fecha de turno</label>
            <input type='date' name='dateAtention' value='<?php echo htmlspecialchars($turnData['fecha_atencion']); ?>'>
        </div>

        <div class="container-field">
            <label for="timeAtention">Hora de turno</label>
            <input type='time' name='timeAtention' value='<?php echo htmlspecialchars($turnData['horario']); ?>'>
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