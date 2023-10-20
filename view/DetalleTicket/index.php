<?php
    require_once("../../config/conexion.php");
    if(isset($_SESSION["user_id"])) {
?>

<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>

    <title>Detalle Ticket</title>

<body class="with-side-menu">
    
    <?php require_once("../MainHeader/header.php");?>

	<div class="mobile-menu-left-overlay"></div>

    <?php require_once("../MainNav/nav.php");?>

    <!-- Contenido -->
	
    <div class="page-content">
		<div class="container-fluid">
            <header class="section-header">
                    <div class="tbl">
                        <div class="tbl-row">
                            <div class="tbl-cell">
                                <h3 id="lblnoticket"></h3>
                                <span id="lblestado"></span>
                                <span class="label label-pill label-primary" id="lblnomusuario"></span>
                                <span class="label label-pill label-default" id="lblfechacreacion"></span>
                                <ol class="breadcrumb breadcrumb-simple">
                                    <li><a href="..\Home\">Home</a></li>
                                    <li class="active">Detalle Ticket</li>
                                </ol>
                            </div>
                        </div>
                    </div>
            </header>

            <div class="box-typical box-typical-padding">
                <div class="row">
                <div class="col-lg-12">
                    <fieldset class="form-group">
                        <label class="form-label semibold" for="titulo_ticket">Asunto</label>
                        <input type="text" class="form-control" id="titulo_ticket" name="titulo_ticket" readonly>
                    </fieldset>
                </div>
                <div class="col-lg-4">
                    <fieldset class="form-group">
                        <label class="form-label semibold" for="id_uniadmin">Unidad Administrativa</label>
                        <input type="text" class="form-control" id="id_uniadmin" name="id_uniadmin" readonly>
                    </fieldset>
                </div>    
                <div class="col-lg-4">
                    <fieldset class="form-group">
                        <label class="form-label semibold" for="id_categoria">Categoria</label>
                        <input type="text" class="form-control" id="id_categoria" name="id_categoria" readonly>
                    </fieldset>
                </div>
                <div class="col-lg-12">
                    <fieldset class="form-group">
                        <label class="form-label semibold" for="id_categoria">Archivos Adjuntos</label>
                        <table id="documentos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th style="width: 90%;">Nombre</th>
                                    <th class="text-center" style="width: 10%;"></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </fieldset>
                </div>
                <div class="col-lg-12">
                    <fieldset class="form-group">
                        <label class="form-label semibold" for="descripcion_usu">Descripción</label>
                        <div class="summernote-theme-1" >
                            <textarea id="descripcion_usu" name="descripcion_usu" class="summernote"></textarea>
                        </div>
                    </fieldset>
                </div>
                </div>
            </div>

            <section class="activity-line" id="lbldetalle">
			</section>

            <div class="box-typical box-typical-padding" id="pnldetalle">
				<p>Ingrese su duda o consulta</p>
				<div class="row">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="descripcion">Descripción</label>
                                <div class="summernote-theme-1" >
                                    <textarea id="ticket_descripcion" name="descripcion" class="summernote"></textarea>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <button type="button" id="btnenviar" class="btn btn-rounded btn-inline btn-primary">Enviar</button>
                            <button type="button" id="btcerrarticket" class="btn btn-rounded btn-inline btn-danger">Cerrar Ticket</button>
                        </div>
				</div>
            </div>

		</div>
	</div>

    <!-- Contenido -->

    <?php require_once("../MainJS/js.php");?>
    <script type="text/javascript" src="detalleticket.js"></script>
</body>
</html>

<?php
    } else {
        header("Location:".Conectar::ruta()."index.php");
    }
?>