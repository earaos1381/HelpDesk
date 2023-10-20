<div id="modalasignar" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form action="post" id="ticket_form">
                <div class="modal-body">
                    <input type="hidden" id="ticket_id" name="ticket_id">

                    <div class="form-group">
                        <label class="form-label" for="user_asig">Soporte</label>
                        <select class="select2" name="user_asig" id="user_asig" data-placeholder="Seleccionar" required>
                            
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Asignar</button>
                </div>
            </form>
        </div>
    </div>
</div><!--.modal-->