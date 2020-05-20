<?php

    // Initialize the session
    session_start();

    require_once "config/bd.php"; 
    
        
    $id = $_GET['noticia'];	
    $record = mysqli_query($db, "SELECT * FROM articulos a INNER JOIN usuarios u ON a.autorId = u.id WHERE noticiaId = $id");
    $articulo = mysqli_fetch_array($record);

    $record2 = "SELECT * FROM articulos a 
    INNER JOIN comentarios c ON a.noticiaId = c.articuloId
    INNER JOIN usuarios u ON u.id = c.autorId
    WHERE articuloId = ".$id.""; 
    $comentarios = $db->query($record2); 

    // Define variables and initialize with empty values
    $comentario = '';
    $comentario_err =  '';


    // Obtener ID para insertar en la BBDD
    if($_SESSION['nombre'] == null){
        
    } else {
    $nombre = $_SESSION['nombre'];
    $idUsuario = "SELECT id FROM usuarios WHERE nombre = '$nombre'";
    $sth2 = $db->query($idUsuario);
    $row2 = mysqli_fetch_assoc($sth2);
    $user_id = $row2['id'];
    }

 
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){

            // Validate comentario
            if(empty(trim($_POST["comentario"]))){
                $comentario_err = "Dato obligatorio.";     
            } elseif((strlen(trim($_POST["comentario"]))) > 10000){
                $comentario_err = "Debe tener una longitud menor de 10000 caracteres.";
            } else{
                $comentario = trim($_POST["comentario"]);
            }
            

        // Check input errors before inserting in database
        if(empty($comentario_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO comentarios (autorId, articuloId, comentario) VALUES (?, ?, ?)";
            
            if($stmt = mysqli_prepare($db, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss",
                $param_autorId,
                $param_articuloId,
                $param_comentario);
                
                // Set parameters
                $param_autorId = $_SESSION['id'];
                $param_articuloId = $_POST['id'];
                $param_comentario = $comentario;
                            
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    header("Location: readNoticias.php");
                } else{
                    echo '<div class="alert alert-danger" role="alert">
                            Algo ha salido mal
                        </div>';

                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
        
        // Close connection
        mysqli_close($db);
    }

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
                        <?php
                        echo '<h1 class="display-5" style="text-align:center; font-style: oblique">'.$articulo['titulo'].'</h1>';
                        ?>
                        <br/>
                        <!-- Page content -->
                        <div class="content">
                            <hr>
                            <div class="row">
                            <div class="container">
                                <div class="container">
                                    <div class="text-center">
                                        <?php
                                            echo '<img src="data:image/jpeg;base64,'.base64_encode( $articulo['imagen'] ).'" alt="Card image cap" width="700px">';
                                            echo '<br/><br/>';
                                            echo '<p class="h5 text-justify">'.$articulo['cuerpo'].'</p>';
                                        ?>
                                    </div>

                                </div>

                            <h1 class="display-5 m-t-40" style="text-align:center; font-style: oblique">Comentarios</h1>
                            <br/>
                            <?php

                            if ($comentarios->num_rows > 0) {
                                // output data of each row
                                while($row = $comentarios->fetch_assoc()) {
                                    echo '<div class="card">';
                                    echo '<div class="card-body">
                                        '.$row['comentario'].'';
                                    echo '</div>';
                                    echo '<div class="card-footer">
                                    '.$row['nombre'].'-'.$row['fechaPublicacion'].'
                                    </div>';
                                    echo '</div><br/>';
                                        } 
                                    }
                                        else {
                                            echo '<div class="card">';
                                            echo '<div class="card-body">
                                                No existen comentarios.';
                                            echo '</div>';
                                            echo '</div>';
                                        
                                }
                            ?>
                            <?php
                            if ($_SESSION['nombre'] == NULL) {
                                echo '<div class="card">';
                                            echo '<div class="card-body">
                                                No puede comentar.';
                                            echo '</div>';
                                            echo '</div>';
                                } else {
                                    echo '<form action="htmlspecialchars($_SERVER["PHP_SELF"]);" method="POST" enctype="multipart/form-data">';
                                    echo '<div class="form-row">';
                                    echo '<div class="form-group col-md-12">';
                                    echo '<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">';
                                    echo '<label>';
                                    echo '<p class="label-txt">COMENTARIO</p>';
                                    echo '<br/>';
                                    echo '<textarea id="comentario" name="comentario" style="background-color: white;" class="input"></textarea>';
                                    echo '</label>';
                                    echo '<button type="submit">submit</button>';
                                    echo '</form>';
                                }
                                ?> 
                                </div>
                            
                            
                        </div>
                        <!-- // Page content -->

                       
                    </div>
                </div>
                <hr>

                <br/>
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