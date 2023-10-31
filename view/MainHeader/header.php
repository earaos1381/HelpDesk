<header class="site-header">
	    <div class="container-fluid">
	
	        <a href="#" class="site-logo">
	            <img class="hidden-md-down" src="../../public/img/logo-2.png" alt="">
	            <img class="hidden-lg-up" src="../../public/img/logo-2-mob.png" alt="">
	        </a>
	
	        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
	            <span>toggle menu</span>
	        </button>
	
	        <button class="hamburger hamburger--htla">
	            <span>toggle menu</span>
	        </button>

	        <div class="site-header-content">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">
					<div class="dropdown dropdown-typical">
                            <a class="dropdown-toggle no-arr">
                                <span id="notification-count" class="label label-pill label-danger">#</span>
                            </a>
                        </div>
						<div class="dropdown dropdown-notification notif">
							<a href="../Notificacion/" class="header-alarm">
								<i class="font-icon-alarm"></i>
	                        </a>
						</div>
	                    <div class="dropdown user-menu">
	                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                            <img src="../../public/img/<?php echo $_SESSION["id_rol"]?>.jpg" alt="">
	                        </button>
	                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
							<a class="dropdown-item"><span class="lblcontactonomx"><?php echo $_SESSION["user_nom"]?> <?php echo $_SESSION["user_ap"]?></span></a>
	                            <a class="dropdown-item" href="../Perfil/"><span class="font-icon glyphicon glyphicon-user"></span>Perfil</a>
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-question-sign"></span>Ayuda</a>
	                            <div class="dropdown-divider"></div>
	                            <a class="dropdown-item" href="../Logout/Logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Cerrar Sesión</a>
	                        </div>
	                    </div>
	                </div>
	
	                <div class="mobile-menu-right-overlay"></div>

					<input type="hidden" id="usuario_id" value="<?php echo $_SESSION["user_id"]?>"> <!--ID usuario -->
					<input type="hidden" id="id_roluser" value="<?php echo $_SESSION["id_rol"]?>"> <!--Rol de usuario -->

                    <!-- <div class="dropdown dropdown-typical">
	                    <a href="#" class="dropdown-toggle no-arr">
	                        <span class="font-icon font-icon-user"></span>
	                        <span class="lblcontactonomx"><?php echo $_SESSION["user_nom"]?> <?php echo $_SESSION["user_ap"]?></span>
	                    </a>
	                </div> -->
	        </div>
	    </div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</header>

<script>
    $(document).ready(function() {
        var userId = $("#usuario_id").val();

        $.ajax({
            type: "POST",
            url: "../../controller/notificacion.php?op=contar",
            data: { user_id: userId },
            dataType: "json",
            success: function(response) {
                var count = response.count;
				$("#notification-count").text(response.count);

            },
            error: function() {
                $("#notification-count").text("Error");
            }
        });
    });
</script>

