<?php    
    function renderDataTable($turns) {
        foreach ($turns as $row) {
            echo "
                <tr>
                    <td>" . htmlspecialchars($row['dni_paciente']) . "</td>
                    <td>" . htmlspecialchars($row['dni_medico']) . "</td>
                    <td>" . htmlspecialchars($row['fecha_atencion']) . "</td>
                    <td>" . htmlspecialchars($row['fecha_creacion']) . "</td>
                    <td>" . htmlspecialchars($row['horario']) . "</td>
                    <td>" . htmlspecialchars($row['estado']) . "</td>
                    <td>
                        <div class='container-buttons-table-aside'>
                            <a href='../../controllers/turn/TurnController.php?action=update&id=" . $row['id'] . "'>
                                <button class='table-button-update' type='button'>Editar</button>
                            </a>
                            <a href='../../controllers/turn/TurnController.php?action=delete&id=" . $row['id'] . "'>
                                <button class='table-button-delete' type='button'>Eliminar</button>
                            </a>
                        </div>
                    </td>
                </tr>
            ";
        }
    }
?>