<?php
if ($_SESSION["id_rol"] == 1) {
    // Lógica para el rol de Usuario
    ?>
    <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="blue-dirty">
                <a href="..\Home\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Inicio</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\NuevoTicket\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Nuevo Ticket</span>
                </a>
            </li>

            <li class="blue-dirty">
                <a href="..\ConsultarTicket">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Consultar Ticket</span>
                </a>
            </li>
        </ul>
    </nav>
    <?php
} elseif ($_SESSION["id_rol"] == 2 || $_SESSION["id_rol"] == 3) {
    // Lógica común para el rol de Soporte (2) y Administrador (3)
    ?>
    <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="blue-dirty">
                <a href="..\Home\">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Inicio</span>
                </a>
            </li>
            <li class="blue-dirty">
                <a href="..\ConsultarTicket">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Consultar Ticket</span>
                </a>
            </li>
            <?php
            // Lógica adicional para el rol de Administrador (3)
            if ($_SESSION["id_rol"] == 3) {
                ?>
                <li class="blue-dirty">
                    <a href="..\Usuarios">
                        <span class="glyphicon glyphicon-th"></span>
                        <span class="lbl">Gestión de Usuarios</span>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
    <?php
}
?>
