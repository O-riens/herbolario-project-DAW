<?php

    // Initialize the session
    session_start();

    require_once "config/bd.php";

    // Obtener ID para insertar en la BBDD
    $nombre = $_SESSION['nombre'];
    $id = "SELECT id FROM usuarios WHERE nombre = '$nombre'";
    $sth = $db->query($id);
    $row = mysqli_fetch_assoc($sth);
    $user_id = $row['id'];

    
    $consulta = "SELECT * FROM plantas WHERE usuarioId = '$user_id'";

    $planta = $db->query($consulta);  

    
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Prickles</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="vendors/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendors/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/daterangepicker/daterangepicker.css">
	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/mainPortada.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="stylesheet" type="text/css" href="css/title.css">
    <link rel="stylesheet" href="css/sidebar-themes.css">
<!--===============================================================================================-->
</head>
<body>
<div class="page-wrapper default-theme sidebar-bg bg1 toggled">
<?php require_once "admin/includes/sidebar.php"; ?>
        <!-- page-content  -->
        <main class="page-content" style="background-image: url(img/bg5.jpg); height: 100%;  ">
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5">
                
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            <a id="toggle-sidebar" class="btn btn-secondary rounded-0" href="#">
                                <span>Mostrar/Ocultar Men&uacute;</span>
                            </a>
                        </div>
                        <h1 style="text-align:center;">Sus plantas</h1>
                        <br/>
                        <hr/>
                        <!-- Page content -->
                        <div class="content">
                            <div class="row">
                                <?php
                            
                                if ($planta->num_rows > 0) {
                                    
                                    // output data of each row
                                    while($row = $planta->fetch_assoc()) {
                                        echo '<div class="col-xs-12 col-sm-6 col-md-4">';
                                            echo '<div class="image-flip" >';
                                                echo '<div class="mainflip flip-0">';
                                                        echo '<div class="card">';
                                                            echo '<div class="card-body text-center">';
                                                                echo ' <p><img class="img-fluid" style="width: 40%; height: 170px; border-radius: 60px" src="data:image/jpeg;base64,'.base64_encode( $row['imagen'] ).'"></p>';
                                                                echo ' <div class="card-body">';
                                                                    echo '<h4 class="card-title">'.$row["nombreComun"].'</h4>';
                                                                echo '</div>';
                                                            echo '</div>';
                                                            echo '                                                                                
                                                            <div class="text-center">
                                                                <a href="formUpdatePlantas.php?edit='.$row['id'].'" id="edit" name="edit" class="btn btn-info btn-rounded mb-4">Modificar</a>
                                                            </div>';
                                                        echo '</div> <br/>';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    }
                                    } else {
                                        echo '<div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-3">';
                                        echo '<div class="card text-center mt-3 mb-3">
                                        <div class="card-header">
                                        No tienes plantas
                                        </div>
                                    </div>';
                                    echo '</div>';
                                    }
                                ?>           
                            </div>
                        </div>
                        <!-- // Page content -->                       
                    </div>
                </div>
                <hr>
            </div>
                <br/>
            </main>
        <!-- page-content" -->
</div>
<!-- page-wrapper -->

  


  <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

<!--===============================================================================================-->
<script src="vendors/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendors/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendors/bootstrap/js/popper.js"></script>
	<script src="vendors/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendors/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendors/daterangepicker/moment.min.js"></script>
	<script src="vendors/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendors/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
  <script src="js/main.js"></script>
  <script src="js/mainPortada.js"></script>

</body>
</html>