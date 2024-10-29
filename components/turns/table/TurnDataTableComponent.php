<?php
    // Importes
    require_once '../../controllers/turn/TurnController.php';
    require_once 'TurnDataTableComponent.php';
    
    // Llamado de funcion del controlador 
    $turns = $turnController->showTurnsAvailable();
?>
<?php if (!empty($turns)): ?>
    <?php foreach ($turns as $turn): ?>
        <tr>
            <td><?php htmlspecialchars($turn['dni_paciente']); ?></td>
            <td><?php htmlspecialchars($turn['dni_medico']); ?></td>
            <td><?php htmlspecialchars($turn['fecha_atencion']); ?></td>
            <td><?php htmlspecialchars($turn['fecha_creacion']); ?></td>
            <td><?php htmlspecialchars($turn['horario']); ?></td>
            <td><?php htmlspecialchars($turn['estado']); ?></td>
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
        <td colspan="7">No hay turnos disponibles.</td>
    </tr>
<?php endif; ?>