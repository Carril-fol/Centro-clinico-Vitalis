<?php
require_once '../../controllers/turn/TurnController.php';

$turnController = new TurnController();
$turnData = $turnController->detailTurn();

function optionsFormated()
{
    global $turnController;
    $specialities = $turnController->medicModel->getSpecialitiesAvailable();
    foreach ($specialities as $row) {
?>
        <option value='<?php echo htmlspecialchars($row['especialidad']); ?>'>
            <?php echo htmlspecialchars($row['especialidad']); ?>
        </option>
    <?php
    }
}

function optionsMedicsFormated()
{
    global $turnController;
    $medicsInDatabase = $turnController->medicModel->getAllDataFomMedics();
    foreach ($medicsInDatabase as $row) {
    ?>
        <option value='<?php echo htmlspecialchars($row['dni']); ?>'>
            <?php echo htmlspecialchars($row["nombre"]) . " " . htmlspecialchars($row["apellido"]) . " | " . htmlspecialchars($row["dni"]) . " | " . htmlspecialchars($row["especialidad"]); ?>
        </option>
<?php
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
            <label for="dniMedic">Dni del medico</label>
            <select id="dniMedic" name="dniMedic" required>
                <option disabled selected>Selecciona un nuevo médico</option>
                <?php optionsMedicsFormated() ?>
            </select>
        </div>

        <div class="container-field">
            <label for="dateAtention">Una nueva fecha de turno</label>
            <input type="date" id="dateAtention" name="dateAtention" required placeholder="Selecciona la fecha" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-12-31'); ?>">
        </div>

        <div class="container-field">
            <label for="timeAtention">Una nueva hora de turno</label>
            <select name="timeAtention">
                <?php optionsTimeFormated() ?>
            </select>
        </div>

        <div class="container-field">
            <label for="speciality">Especialidad</label>
            <select id="speciality" name="speciality" required>
                <option disabled selected>Selecciona una nueva especialidad</option>
                <?php optionsFormated(); ?>
            </select>
        </div>
        <div class="container-form-button-submit">
            <button type="submit" class="submit-button">Actualizar</button>
        </div>
    </div>
</form>