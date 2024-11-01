<?php
// Importe de controlador
require_once '../../controllers/turn/TurnController.php';

// Instancia de controlador
$turnController = new TurnController();

// Llamado de función del modelo de Medico
$specialities = $turnController->medicModel->getSpecialitiesAvailable();

function optionsFormated($specialities) {
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
<form class='formulario-turno-creacion' method='POST' action='../../controllers/turn/TurnController.php?action=create'>
    <div>
        <img src='../../assets/images/logo.webp' alt='Logo'/>
        <h1>Crea tu turno</h1>
    </div>
    <input type='text' name='dniPatient' placeholder='DNI DEL PACIENTE'>
    <div>
        <label for="dateAtention">Fecha de turno</label>
        <input type='date' name='dateAtention'>
    </div>
    <div>
        <label for="timeAtention"></label>
        <input type='time' name='timeAtention'>
    </div>
    <select required name='speciality'>
        <?php optionsFormated($specialities); ?>
    </select>
    <button type='submit'>
        Crear
    </button>
</form>