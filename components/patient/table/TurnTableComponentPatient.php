<div>
    <div class="container-table-button-top">
        <a href="../../views/patient/create.php">
            <button class="actual-turns-btn">
                <img width="20" height="20" src="../../assets/icons/PlusIcon.svg" alt="plus-icon" />
                Solicitar turno
            </button>
        </a>
        <form method="GET">
            <button class="actual-turns-btn" name="turnsRequested" type="submit">
                <img width="20" height="20" src="../../assets/icons/ChecklistIcon.svg" alt="check-list-icon" />
                Turnos solicitados
            </button>
        </form>
        <form method="GET">
            <button class="history-turns-btn" name="turnsHistory" type="submit">
                <img width="20" height="20" style="margin-right: 3px" src="../../assets/icons/PasadoIcon.svg" alt="past-icon" />
                Historial de turnos
            </button>
        </form>
    </div>
    <table class="content-table">
        <thead>
            <tr>
                <th>DNI - Paciente</th>
                <th>Especialidad</th>
                <th>Fecha atención</th>
                <th>Fecha creación</th>
                <th>Horario</th>
                <th>Estado</th>
            </tr>
        </thead>
        <?php
        if (isset($_GET['turnsHistory'])) {
            include_once "TurnHistoryDataTableComponentPatient.php";
        } else if (isset($_GET['turnsRequested'])) {
            include_once "TurnRequestedDataTableComponentPatient.php";
        } else {
            include_once "TurnRequestedDataTableComponentPatient.php";
        }
        ?>
    </table>
</div>