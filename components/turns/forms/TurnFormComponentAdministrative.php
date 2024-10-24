<?php
// Importe de controlador
require_once '../../controllers/turn/TurnController.php';

// Instancia de controlador
$turnController = new TurnController();

// Llamado de función del modelo de Medico
$specialities = $turnController->medicModel->getSpecialitiesAvailable();

function optionsFormated($specialities) {
    foreach ($specialities as $row): 
        ?>
            <option value='<?php echo htmlspecialchars($row['especialidad']); ?>'>
                <?php echo htmlspecialchars($row['especialidad']); ?>
            </option>
        <?php
    endforeach;
}
?>
<form class='formulario-turno-creacion' method='POST' action='../../controllers/turn/TurnController.php?action=create'>
    <div>
        <img src='../../assets/images/logo.webp' alt='Logo'/>
        <h1>Crea tu turno</h1>
    </div>
    <input type='text' name='dniPatient' placeholder='Dni del paciente'>
    <input type='date' name='dateAtention'>
    <input type='time' name='timeAtention'>
    <select required name='speciality'>
        <?php optionsFormated($specialities); ?>
    </select>
    <button type='submit'>
        Crear
    </button>
</form>