<?php
require_once '../../controllers/administrative/AdministrativeController.php';

$administrativeController = new AdministrativeController();
$turns = $administrativeController->showTurnRequested();
?>
<?php if (!empty($turns)): ?>
    <?php foreach ($turns as $turn): ?>
        <tr>
            <td><?php echo htmlspecialchars($turn["dni_paciente"]); ?></td>
            <td><?php echo htmlspecialchars($turn["fecha_atencion"]); ?></td>
            <td><?php echo htmlspecialchars($turn["fecha_creacion"]); ?></td>
            <td><?php echo htmlspecialchars($turn["horario"]); ?></td>
            <td><?php echo htmlspecialchars($turn["estado"]); ?></td>
            <td>
                <div class='container-buttons-table-aside'>
                    <form method="POST" action="../../controllers/administrative/AdministrativeController.php?action=assing&id=<?php echo urldecode($turn["id"]) ?>">
                        <button class='table-button-update' type='submit'>Relevar</button>
                    </form>

                </div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7">No hay turnos solicitados por los pacientes.</td>
    </tr>
<?php endif; ?>