<?php
require_once '../../controllers/patient/PatientController.php';

$patientController = new PatientController();

$turns = $patientController->showHistoryTurnsFromPatient();
?>
<?php if (!empty($turns)): ?>
    <?php foreach ($turns as $turn): ?>
        <tr>
            <td><?php echo htmlspecialchars($turn['dni_paciente']); ?></td>
            <td><?php echo htmlspecialchars($turn['especialidad']); ?></td>
            <td><?php echo htmlspecialchars($turn['fecha_atencion']); ?></td>
            <td><?php echo htmlspecialchars($turn['fecha_creacion']); ?></td>
            <td><?php echo htmlspecialchars($turn['horario']); ?></td>
            <td><?php echo htmlspecialchars($turn['estado']); ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7">No tienes turnos cancelados/completados todavía.</td>
    </tr>
<?php endif; ?>