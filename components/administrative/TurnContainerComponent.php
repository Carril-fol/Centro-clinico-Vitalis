<div>
    <div class="container-table-button-top">
        <ul class="list-container-buttons">
            <li>
                <a href="../../views/auth/register.php">
                    <button class="add-personal">
                        <img src="../../assets/icons/AvatarIcon.svg" alt="avatar-icon" />
                        Dar alta personal
                    </button>
                </a>
            </li>
            <li>
                <a href="../../views/turn/create.php">
                    <button class="table-button-add">
                        <img src="../../assets/icons/PlusIcon.svg" alt="plus-icon" />
                        Agregar turnos
                    </button>
                </a>
            </li>
            <li>
                <form method="GET">
                    <button class="history-turns-btn" name="turnsPending" type="submit">
                        <img width="20" height="20" style="margin-right: 3px" src="../../assets/icons/ChecklistIcon.svg" alt="check-list-icon" />
                        Turnos pendientes
                    </button>
                </form>
            </li>
            <li>
                <form method="GET">
                    <button class="history-turns-btn" name="turnsRequested" type="submit">
                    <img width="20" height="20" style="margin-right: 3px" src="../../assets/icons/ListIcon.svg" alt="list-icon" />
                        Turnos solicitados
                    </button>
                </form>
            </li>
        </ul>
    </div>
    <?php
    if (isset($_GET["turnsPending"])) {
        include_once "TurnTablePendingComponent.php";
    } else if (isset($_GET["turnsRequested"])) {
        include_once "TurnTableRequestedComponent.php";
    } else {
        include_once "TurnTableRequestedComponent.php";
    }
    ?>
</div>