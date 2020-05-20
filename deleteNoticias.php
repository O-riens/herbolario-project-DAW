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

    
    $consulta = "SELECT * FROM articulos a INNER JOIN usuarios u ON a.autorId = u.id WHERE autorId = '$user_id'";

    $articulo = $db->query($consulta);  
    

    
    if (isset($_GET['eliminar'])) {
        $id = $_GET['eliminar'];
        mysqli_query($db, "DELETE FROM articulos WHERE noticiaId=$id");

        header("Location: noticias.php");
    }
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
                        <h1 class="display-4" style="text-align:center; font-style: oblique">Borrar noticias</h1>
                        <br/>
                        <hr/>
                        <!-- Page content -->
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
                                                echo '<a href="#">';
                                                    echo '<h5 class="card-title">'.$row["titulo"].'</h5>';
                                                echo '</a>';
                                                echo '<hr/>';
                                                echo '<p class="card-text">'.$row["entrada"].'</p>';
                                                echo '<br/>';
                                                echo '<hr/>';
                                                echo ' <p class="card-text text-right">'.$row['nombre'].' - '.$row['fechaPublicacion'].'</p>';
                                                echo '</div>';
                                                echo '                                                                                
                                                <div class="text-center">
                                                    <a href="deleteNoticias.php?eliminar='.$row['noticiaId'].'" id="eliminar" name="eliminar" class="btn btn-info btn-rounded mb-4">Eliminar</a>
                                                </div>';
                                        echo '</div>';
                                        }
                                        } else {
                                        echo '<div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-3">';
                                            echo '<div class="card text-center mt-3 mb-3">
                                            <div class="card-header">
                                            No tienes noticias
                                            </div>
                                            <div class="card-body">
                                            <h5 class="card-title">Bienvenido</h5>
                                            <p class="card-text">Usted como autor puede introducir nuevas y preciosas noticias.</p>
                                            <a href="addNoticias.php" class="btn btn-info">Añadir noticias</a>
                                            </div>
                                        </div>';
                                        echo '</div>';
                                        }
                                ?>           

                                </div>
                            </div>
                        </div>
                        <!-- // Page content -->

                       
                </div>
            </div>
                <hr>

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