<?php
// Importes
require_once '../../controllers/medic/MedicController.php';

$medicController = new MedicController();

$turns = $medicController->showAllTurnAvailableFromMedic();
?>
<?php if (!empty($turns)): ?>
    <?php foreach ($turns as $turn): ?>
        <tr>
            <td><?php echo htmlspecialchars($turn["dni_paciente"]); ?></td>
            <td><?php echo htmlspecialchars($turn['fecha_atencion']); ?></td>
            <td><?php echo htmlspecialchars($turn['fecha_creacion']); ?></td>
            <td><?php echo htmlspecialchars($turn['horario']); ?></td>
            <td><?php echo htmlspecialchars($turn['estado']); ?></td>
            <td>
                <div class='container-buttons-table-aside'>
                    <a href='../../controllers/medic/MedicController.php?action=update&id=<?php echo $turn['id']; ?>'>
                        <button class='table-button-complete' type='button'>Completar</button>
                    </a>
                    <a href='../../views/turn/update.php?action=update&id=<?php echo $turn['id']; ?>'>
                        <button class='table-button-update' type='button'>Editar</button>
                    </a>

                    <?php 
                        $dni = $turn["dni_paciente"];
                        $paciente = new User();
                        $datos = $paciente->getDataFromUserByDni($dni);

                    ?>
                    <a href="./../../bajarPdf.php?n=<?php echo $datos['nombre'];?>&a=<?php echo $datos['apellido'];?>&dni=<?php echo($turn['dni_paciente'])?>&fa=<?php echo($turn['fecha_atencion'])?>&fc=<?php echo($turn['fecha_creacion'])?>&h=<?php echo($turn['horario'])?>&d=<?php echo($turn['fecha_atencion'])?>" target="_blank" style="padding: 5px; background-color: #F90909; border-radius: 5px;" download >
                        <img src="../../assets/icons/pdf-file.svg" alt="pdf file" width="25px">
                    </a>

                </div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7">No tienes turnos por el momento.</td>
    </tr>
<?php endif; ?>