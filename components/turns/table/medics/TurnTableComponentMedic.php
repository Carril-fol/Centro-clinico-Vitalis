<div>
    <div class="container-table-button-top">
        <form method="GET">
            <button class="actual-turns-btn" name="turnsPendientCurrent" type="submit">
                <img width="20" height="20" src="../../assets/icons/ChecklistIcon.svg" />
                Turnos actuales
            </button>
        </form>
        <form method="GET">
            <button class="history-turns-btn" name="turnsCompleted" type="submit">
                <img width="20" height="20" style="margin-right: 3px" src="../../assets/icons/PasadoIcon.svg" />
                Historial de turnos
            </button>
        </form>
    </div>
    <table class="content-table">
        <thead>
            <tr>
                <th>DNI - Paciente</th>
                <th>Fecha atención</th>
                <th>Fecha creación</th>
                <th>Horario</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <?php
        if (isset($_GET['turnsCompleted'])) {
            include("TurnCompletedDataTableComponentMedic.php");
        } else if (isset($_GET['turnsPendientCurrent'])) {
            include("TurnAvailableDataTableComponentMedic.php");
        } else {
            include("TurnAvailableDataTableComponentMedic.php");
        }
        ?>
    </table>
</div>