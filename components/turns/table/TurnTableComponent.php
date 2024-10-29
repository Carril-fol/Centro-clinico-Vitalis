<div>
    <div class="container-table-button-top">
        <a href="../../views/turn/create.php">
            <button class="table-button-add">
                Agregar
            </button>
        </a>
    </div>
    <table class="content-table">
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
        <?php include("TurnDataTableComponent.php"); ?>
    </table>
</div>