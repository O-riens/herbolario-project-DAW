<?php

    // Initialize the session
    session_start();

    require_once "config/bd.php";

    
    $consulta = "SELECT * FROM plantas";

    $planta = $db->query($consulta);    

?>


<!DOCTYPE html>
<html lang="es">
<head>
	<title>Prickles</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/mainPortada.css">
    <link rel="stylesheet" type="text/css" href="css/title.css">
    <link rel="stylesheet" href="css/sidebar-themes.css">
<!--===============================================================================================-->
</head>
<body>
<div class="page-wrapper default-theme sidebar-bg bg1 toggled">
    <?php require_once "admin/includes/sidebar.php"; ?>
        <!-- page-content  -->
        <main class="page-content" style="background-image: url(img/bg5.jpg)">
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5">
                
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            <a id="toggle-sidebar" class="btn btn-secondary rounded-0" href="#">
                                <span>Mostrar/Ocultar Men&uacute;</span>
                            </a>
                        </div>
                        <h1 class="display-4" style="text-align:center; font-style: oblique">Plantas</h1>
                        <br/>
                        <!-- Page content -->
                        <div class="content">
                            <hr/>
                            <div class="row">

                                    <?php
                                
                                    if ($planta->num_rows > 0) {
                                        // output data of each row
                                        while($row = $planta->fetch_assoc()) {
                                            echo '<div class="col-xs-12 col-sm-6 col-md-4">';
                                                echo '<div class="image-flip" >';
                                                    echo '<div class="mainflip flip-0">';
                                                        echo '<div class="frontside">';
                                                            echo '<div class="card">';
                                                                echo '<div class="card-body text-center">';
                                                                    echo ' <p><img class="img-fluid" src="data:image/jpeg;base64,'.base64_encode( $row['imagen'] ).'" alt=""></p>';
                                                                    echo '<h4 class="card-title">'.$row["nombreComun"].'</h4>';
                                                                    echo '<hr/>';
                                                                    echo '<p class="card-text">'.$row["caracteristicas"].'</p>';
                                                                    echo '<br/>';
                                                                echo '</div>';
                                                            echo '</div>';
                                                        echo '</div>';
                                                        
                                                        echo '<div class="backside">';
                                                            echo '<div class="card" style="background-image: url(img/bg011.jpg);">';
                                                                echo '<div class="card-body text-center mt-4">';
                                                                    echo '<h4 class="card-title">'.$row["nombreCientifico"].'</h4>';
                                                                    echo '<hr/>';
                                                                    echo '<p class="card-text text-left"><b>Luz:</b><br/>'.$row["luz"].'<br/><b>Riego:</b><br/> '.$row["riego"].'<br/>
                                                                    <b>Floraci&oacute;n</b><br/> '.$row["floracion"].'<br/>
                                                                    <b>Color de flor:</b><br/> '.$row["colorFlor"].'</p>';
                                                                    echo '<a href="pdfPlanta.php?pdf='.$row['id'].'" target="_blank" id="pdf" name="pdf" class="btn btn-info btn-rounded mb-4">Generar PDF</a>';
                                                                    
                                                                echo '</div>';
                                                            echo '</div>';
                                                        echo '</div>';
                                                    echo '</div>';
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                        } else {
                                        echo "No hay plantas.";
                                        }
                                ?>           

                            </div>

                        </div>
                        <!-- // Page content -->

                    </div>   
                </div>
            </div>

        </main>
        <!-- page-content" -->
</div>
<!-- page-wrapper -->

  


  <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
  <script src="js/main.js"></script>
  <script src="js/mainPortada.js"></script>

</body>
</html>