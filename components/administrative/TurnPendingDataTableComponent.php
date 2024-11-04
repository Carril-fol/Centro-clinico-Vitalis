<?php
require_once '../../controllers/administrative/AdministrativeController.php';

$administrativeController = new AdministrativeController();
$turns = $administrativeController->showTurnPending();
?>
<?php if (!empty($turns)): ?>
    <?php foreach ($turns as $turn): ?>
        <tr>
            <td><?php echo htmlspecialchars($turn['dni_paciente']); ?></td>
            <td><?php echo htmlspecialchars($turn['dni_medico']); ?></td>
            <td><?php echo htmlspecialchars($turn['fecha_atencion']); ?></td>
            <td><?php echo htmlspecialchars($turn['fecha_creacion']); ?></td>
            <td><?php echo htmlspecialchars($turn['horario']); ?></td>
            <td><?php echo htmlspecialchars($turn['estado']); ?></td>
            <td>
                <div class='container-buttons-table-aside'>
                    <a href='../../views/turn/update.php?action=update&id=<?php echo $turn['id']; ?>'>
                        <button class='table-button-update' type='button'>Editar</button>
                    </a>
                    <a href='../../controllers/turn/TurnController.php?action=delete&id=<?php echo $turn['id']; ?>'>
                        <button class='table-button-delete' type='button'>Eliminar</button>
                    </a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7">No hay turnos pendientes.</td>
    </tr>
<?php endif; ?>