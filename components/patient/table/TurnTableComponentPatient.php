<div>
    <div class="container-table-button-top">
        <a href="../../views/patient/create.php">
            <button class="actual-turns-btn">
                <img width="20" height="20" src="../../assets/icons/ChecklistIcon.svg" alt="check-list-icon" />
                Solicitar turno
            </button>
        </a>
    </div>
    <table class="content-table">
        <thead>
            <tr>
                <th>DNI - Paciente</th>
                <th>Fecha atención</th>
                <th>Fecha creación</th>
                <th>Horario</th>
                <th>Estado</th>
            </tr>
        </thead>
        <?php include "TurnDataTableComponentPatient.php"; ?>
    </table>
</div>
