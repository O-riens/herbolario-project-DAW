<?php

    // Initialize the session
    session_start();

    require_once "config/bd.php";

    
    $consulta = "SELECT * FROM articulos a INNER JOIN usuarios u ON a.autorId = u.id";

    $articulo = $db->query($consulta);    


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
    <link rel="stylesheet" type="text/css" href="css/title.css">
    <link rel="stylesheet" href="css/sidebar-themes.css">
<!--===============================================================================================-->
</head>
<body>
<div class="page-wrapper default-theme sidebar-bg bg1 toggled">
<?php require_once "admin/includes/sidebar.php"; ?>
        <!-- page-content  -->
        <main class="page-content" style="background-image: url(img/bg5.jpg); height: 100%;">
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5">
                
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-12">
                            <a id="toggle-sidebar" class="btn btn-secondary rounded-0" href="#">
                                <span>Mostrar/Ocultar Men&uacute;</span>
                            </a>
                        </div>
                        <h1 style="text-align:center; ">Noticias</h1>
                        <br/>
                        <!-- Page content -->
                        <div class="content">
                            <hr>
                            <div class="row">
                            <div class="container">
                                <div class="container">
                                    <div class="card-columns">
                                    <?php
                                
                                    if ($articulo->num_rows > 0) {
                                        // output data of each row
                                        while($row = $articulo->fetch_assoc()) {

                                                    echo '<div class="card">';
                                                            echo '<img class="card-img-top" src="data:image/jpeg;base64,'.base64_encode( $row['imagen'] ).'" alt="Card image cap">';
                                                                echo '<div class="card-body">';
                                                                echo '<a href="readNoticias.php?noticia='.$row['noticiaId'].'">';
                                                                    echo '<h5 class="card-title">'.$row["titulo"].'</h5>';
                                                                echo '</a>';
                                                                echo '<hr/>';
                                                                echo '<p class="card-text">'.$row["entrada"].'</p>';
                                                                echo '<br/>';
                                                                echo '<hr/>';
                                                                echo ' <p class="card-text text-right">'.$row['nombre'].' - '.$row['fechaPublicacion'].'</p>';
                                                                echo '</div>';
                                                    echo '</div>';
                                        }
                                        } else {
                                        echo "No hay art&iacute;culos.";
                                        }
                                    ?>    
                                    </div>       

                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- // Page content -->
                    </div>
                <hr>
                <br/>
                </div>
            </div>
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