<?php
    // Importes
    require_once '../../controllers/turn/TurnController.php';
    require_once 'TurnDataTableComponent.php';

    // Llamado de funcion del controlador 
    $turns = $turnController->showTurnsAvailable();
    
    function renderTurnTable($turns) {
        if (empty($turns)) {
            echo "
                <div>
                    No hay turnos por el momento a mostrar
                </div>
            ";
        } else {
            echo "
                <div class='container-table-button-top'>
                    <a href='../../views/turn/create.php'>
                        <button class='table-button-add'>
                            Agregar
                        </button>
                    </a>
                </div>
            ";
            echo "
                <table class='content-table'>
                    <thead>
                        <tr>
                            <th>DNI - Paciente</th>
                            <th>DNI - Medico</th>
                            <th>Fecha atención</th>
                            <th>Fecha creación</th>
                            <th>Horario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                ";
                renderDataTable($turns);
            echo "  </tbody>
                </table>";
        }
    }

    renderTurnTable($turns);
?>
