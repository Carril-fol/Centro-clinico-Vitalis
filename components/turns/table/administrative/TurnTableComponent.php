<div>
    <div class="container-table-button-top">
        <ul class="list-container-buttons">
            <li>
                <a href="../../views/auth/register.php">
                    <button class="add-personal">
                        <img src="../../assets/icons/AvatarIcon.svg" />
                        Dar alta personal
                    </button>
                </a>
            </li>
            <li>
                <a href="../../views/turn/create.php">
                    <button class="table-button-add">
                        <img src="../../assets/icons/PlusIcon.svg" />
                        Agregar turnos
                    </button>
                </a>
            </li>
        </ul>
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