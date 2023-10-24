<?php
    require_once("../../config/conexion.php");
    if(isset($_SESSION["user_id"])) {
?>

<!DOCTYPE html>
<html>
<?php require_once("../MainHead/head.php");?>

    <title>Consultar Ticket</title>

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
							<h3>Consultar Ticket</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="..\Home\">Home</a></li>
								<li class="active">Ticket</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

            <div class="box-typical box-typical-padding">
            <div class="row" id="viewuser">
					<div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label" for="titulo_ticket">Titulo</label>
							<input type="text" class="form-control" id="titulo_ticket" name="titulo_ticket" placeholder="Ingrese Titulo" required>
						</fieldset>
					</div>

					<div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label" for="id_categoria">Categoria</label>
							<select class="select2" id="id_categoria" name="id_categoria" data-placeholder="Selecciona una Categoria">
								<option label="Seleccionar"></option>

							</select>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="id_prioridad">Prioridad</label>
							<select class="select2" id="id_prioridad" name="id_prioridad" data-placeholder="Seleccionar una Prioridad">
								<option label="Seleccionar"></option>

							</select>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="btnfiltrar">&nbsp;</label>
							<button type="submit" class="btn btn-rounded btn-primary btn-block" id="btnfiltrar">Filtrar</button>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="btntodo">&nbsp;</label>
							<button class="btn btn-rounded btn-primary btn-block" id="btntodo">Ver Todo</button>
						</fieldset>
					</div>
				</div>

                <div class="box-typical box-typical-padding" id="table">
					<table id="ticket_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 5%;">#</th>
								<th style="width: 15%;">Unidad Administrativa</th>
								<th style="width: 15%;">Categoria</th>
								<th style="width: 40%;">Asunto</th>
								<th style="width: 5%;">Prioridad</th>
								<th style="width: 5%;">Estado</th>
								<th style="width: 5%;">Fecha de Creación</th>
								<th style="width: 5%;">Fecha de Asignación</th>
								<th style="width: 5%;">Fecha de Cierre</th>
								<th style="width: 10%;">Soporte</th>
								<th style="width: 5%;"></th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
            </div>

		</div>
	</div>

    <!-- Contenido -->

    <?php require_once("modalasignar.php");?>
    <?php require_once("../MainJS/js.php");?>
    <script type="text/javascript" src="consultarticket.js"></script>
</body>
</html>

<?php
    } else {
        header("Location:".Conectar::ruta()."index.php");
    }
?>