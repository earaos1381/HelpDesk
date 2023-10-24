<?php
    require_once("../../config/conexion.php");
    if(isset($_SESSION["user_id"])) {
?>

<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>

    <title>Nuevo Ticket</title>

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
							<h3>Nuevo Ticket</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="..\Home\">Home</a></li>
								<li class="active">Ticket</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

            <div class="box-typical box-typical-padding">
				<p>
					Favor de llenar todos los campos del Ticket
				</p>

				<h5 class="m-t-lg with-border">Información de Ticket</h5>

				<div class="row">
                    <form method="post" id="ticket_form">

                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION["user_id"]?>">
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="titulo_ticket">Asunto</label>
                                <input type="text" class="form-control" id="titulo_ticket" name="titulo_ticket" placeholder="Ingrese Asunto">
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="id_uniadmin">Unidad Administrativa Principal</label>
                                <select id="id_uniadmin" name="id_uniadmin" class="form-control">
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="subUni_id">Unidad Administrativa Sub</label>
                                <select id="subUni_id" name="subUni_id" class="form-control">
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="id_categoria">Categoria</label>
                                <select id="id_categoria" name="id_categoria" class="form-control">
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="id_categoria">Archivos Adjuntos</label>
                                <input type="file" name="fileElem" id="fileElem" class="form-control" multiple>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="descripcion">Descripción</label>
                                <div class="summernote-theme-1" >
                                    <textarea id="ticket_descripcion" name="descripcion" class="summernote"></textarea>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Guardar</button>
                        </div>
                    </form>
				</div>
            </div>
		</div>
	</div>

    <!-- Contenido -->

    <?php require_once("../MainJS/js.php");?>
    <script type="text/javascript" src="nuevoticket.js"></script>
</body>
</html>

<?php
    } else {
        header("Location:".Conectar::ruta()."index.php");
    }
?>