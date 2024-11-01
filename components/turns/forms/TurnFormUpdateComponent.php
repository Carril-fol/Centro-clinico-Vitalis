<?php
require_once '../../controllers/turn/TurnController.php';

$turnController = new TurnController();

$specialities = $turnController->medicModel->getSpecialitiesAvailable();

$turnData = $turnController->detailTurn();

function optionsFormated($turnData, $specialities) {
    ?>
        <option value='<?php echo htmlspecialchars($turnData['especialidad']); ?>' selected>
            <?php echo htmlspecialchars($turnData['especialidad']); ?>
        </option>
    <?php
    foreach ($specialities as $row): 
        ?>
            <option value='<?php echo htmlspecialchars($row['especialidad']); ?>'>
                <?php echo htmlspecialchars($row['especialidad']); ?>
            </option>
        <?php
    endforeach;
}
?>
<!-- Formulario -->
<form class='formulario-turno-creacion' method='POST' action='../../controllers/turn/TurnController.php?action=update&id=<?php echo $turnData['id']; ?>'>
    <div>
        <img src='../../assets/images/logo.webp' alt='Logo'/>
        <h1>Actualizar turno</h1>
    </div>
    <input type='text' name='dniPatient' value='<?php echo htmlspecialchars($turnData['dni_paciente']); ?>'>
    <input type='date' name='dateAtention' value='<?php echo htmlspecialchars($turnData['fecha_atencion']); ?>'>
    <input type='time' name='timeAtention' value='<?php echo htmlspecialchars($turnData['horario']); ?>'>
    <select required name='speciality'>
        <?php optionsFormated($turnData, $specialities); ?>
    </select>
    <button type='submit'>
         Actualizar
    </button>
</form>