<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form action="post" id="usuario_form">
                <div class="modal-body">
                    <input type="hidden" id="user_id" name="user_id">
                    <div class="form-group">
                        <label class="form-label" for="user_nom">Nombre</label>
                        <input type="text" class="form-control" id="user_nom" name="user_nom" placeholder="Ingrese Nombre" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="user_ap">Apellido</label>
                        <input type="text" class="form-control" id="user_ap" name="user_ap" placeholder="Ingrese Apellido" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="user_correo">Correo</label>
                        <input type="email" class="form-control" id="user_correo" name="user_correo" placeholder="@" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="user_password">Contraseña</label>
                        <input type="text" class="form-control" id="user_password" name="user_password" placeholder="******" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="id_rol">Rol de Usuario</label>
                        <select class="select2" id="id_rol" name="id_rol" required>
                            <option value="1">Usuario</option>
                            <option value="2">Soporte</option>
                            <option value="3">Administrador</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div><!--.modal-->