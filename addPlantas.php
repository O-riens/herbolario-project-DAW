<?php

// Initialize the session
session_start();

// Include config file
require_once "config/bd.php";
 
// Define variables and initialize with empty values
$nombreComun = $imgContent = $nombreCientifico = $luz = $riego = $floracion = $colorFlor = $hojas = $tamañoPlanta = 
$caracteristicas = $estiloJardin = $status = $statusMsg = '';

    // Obtener ID para insertar en la BBDD
    $nombre = $_SESSION['nombre'];
    $id = "SELECT id FROM usuarios WHERE nombre = '$nombre'";
    $sth = $db->query($id);
    $row = mysqli_fetch_assoc($sth);
    $user_id = $row['id'];



$nombreCientifico_err = $menosCincuentaLongitud_err = 
$nombreComun_err = $luz_err = $riego_err = $colorFlor_err = '';

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate nombre cientifico
    if(empty(trim($_POST["nombreCientifico"]))){
        $nombreCientifico_err = "Introduzca un nombre cient&iacue;fico.";
        } else{
        // Prepare a select statement
        $sql = "SELECT id FROM plantas WHERE nombreCientifico = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_nombreCientifico);
            
            // Set parameters
            $param_nombreCientifico = trim($_POST["nombreCientifico"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $nombreCientifico_err = "Este nombre ya existe.";
                } else{
                    $nombreCientifico = trim($_POST["nombreCientifico"]);
                }
            } else{
                echo "Oops! Algo salió mal, pruebe de nuevo.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

        // Validate nombreComun, luz, riego y color de la flor
        if(empty(trim($_POST["nombreComun"])) && empty(trim($_POST["luz"])) && empty(trim($_POST["riego"])) && empty(trim($_POST["colorFlor"]))){
            $menosCincuentaLongitud_err = "Son datos obligatorios.";     
        } elseif(strlen(trim($_POST["nombreComun"])) && strlen(trim($_POST["luz"])) && strlen(trim($_POST["riego"])) && strlen(trim($_POST["colorFlor"])) > 50){
            $menosCincuentaLongitud_err = "Debe tener una longitud menor de 50 caracteres.";
        } else{
            $nombreComun = trim($_POST["nombreComun"]);
            $luz = trim($_POST["luz"]);
            $riego = trim($_POST["riego"]);
            $colorFlor = trim($_POST["colorFlor"]);
        }

        // Validate tamañoPlanta, floracion y estiloJardin
        if(strlen(trim($_POST["tamañoPlanta"])) && strlen(trim($_POST["floracion"])) && strlen(trim($_POST["estiloJardin"])) > 200){
            $menosCincuentaLongitud_err = "Debe tener una longitud menor de 200 caracteres.";
        } else{
            $tamañoPlanta = trim($_POST["tamañoPlanta"]);
            $floracion = trim($_POST["floracion"]);
            $estiloJardin = trim($_POST["estiloJardin"]);
        }

        // Validate hojas
        if(strlen(trim($_POST["hojas"])) > 300){
            $menosCincuentaLongitud_err = "Debe tener una longitud menor de 300 caracteres.";
        } else{
            $hojas = trim($_POST["hojas"]);
        }

        // Validate caracteristicas
        if(strlen(trim($_POST["caracteristicas"])) > 1000){
            $menosCincuentaLongitud_err = "Debe tener una longitud menor de 1000 caracteres.";
        } else{
            $caracteristicas = trim($_POST["caracteristicas"]);
        }

        

    // Check input errors before inserting in database
    if(empty($nombreCientifico_err) && empty($nombreComun_err) && empty($luz_err) && empty($riego_err) && empty($colorFlor_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO plantas (nombreComun, imagen, luz, riego, nombreCientifico, hojas, tamañoPlanta, caracteristicas, floracion, colorFlor
        , estiloJardin, usuarioId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssssss",
            $param_nombreComun,
            $param_imagen,
            $param_luz,
            $param_riego,
            $param_nombreCientifico,
            $param_hojas,
            $param_tamañoPlanta,
            $param_caracteristicas,
            $param_floracion,
            $param_colorFlor,
            $param_estiloJardin,
            $param_usuarioId);
            
            // Set parameters
            $param_nombreComun = $nombreComun;
            $param_imagen = $imgContent;
            $param_luz = $luz;
            $param_riego = $riego;
            $param_nombreCientifico = $nombreCientifico;
            $param_hojas = $hojas;
            $param_tamañoPlanta = $tamañoPlanta;
            $param_caracteristicas = $caracteristicas;
            $param_floracion = $floracion;
            $param_colorFlor = $colorFlor;
            $param_estiloJardin = $estiloJardin;
            $param_usuarioId = $user_id;
                        
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Subir imagen
                if(!empty($_FILES["image"]["name"])) { 
                    // Get file info 
                    $fileName = basename($_FILES["image"]["name"]); 
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                    // Allow certain file formats 
                    $allowTypes = array('jpg','png','jpeg','gif'); 
                    if(in_array($fileType, $allowTypes)){ 
                        $image = $_FILES['image']['tmp_name']; 
                        $imgContent = addslashes(file_get_contents($image));
                        $insert = $db->query("UPDATE plantas SET imagen = '$imgContent' WHERE nombreCientifico = '$nombreCientifico'"); 
                                                                            
                    }
        } 

                header('Location: plantas.php');
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
                        <h1 class="display-4" style="text-align:center; font-style: oblique">Añadir plantas</h1>
                        <br/>
                        <!-- Page content -->
                        <div class="content">
                            <hr>
                            <div class="row">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-md-6 mt-1">
                                        <p class="label-txt">NOMBRE COM&Uacute;N</p>
                                        <input type="text" id="nombreComun" name="nombreComun"  class="input">
                                        <div class="line-box">
                                            <div class="line"></div>
                                        </div>
                                        </div>
                                            <div class="form-group col-md-6 mt-1">
                                            <p class="label-txt">NOMBRE CIENT&Iacute;FICO</p>
                                                <input type="text" id="nombreCientifico" name="nombreCientifico" class="input">
                                                    <div class="line-box">
                                                <div class="line"></div>
                                            </div>
                                    </div>
                                    

                                    <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">LUZ</p>
                                        <input type="text" id="luz" name="luz" class="input">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                        </div>
                                        <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">RIEGO</p>
                                        <input type="text" id="riego" name="riego" class="input">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">FLORACI&Oacute;N (Opcional)</p>
                                        <input type="text" id="floracion" name="floracion" class="input">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                        </div>
                                        <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">COLOR DE LA FLOR</p>
                                        <input type="text" id="colorFlor" name="colorFlor" class="input">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">HOJAS (Opcional)</p>
                                        <input type="text" id="hojas" name="hojas" class="input">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                        </div>
                                        <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">TAMAÑO DE LA PLANTA (Opcional)</p>
                                        <input type="text"id="tamañoPlanta" name="tamañoPlanta" class="input">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                        </div>
                                    </div>
                                       
                                    <label>
                                        <p class="label-txt">CARACTER&Iacute;STICAS</p>
                                        <input type="text" id="caracteristicas" name="caracteristicas" class="input">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                    </label>
                                    
                                    <label>
                                        <p class="label-txt">ESTILO DE JARD&Iacute;N (Opcional)</p>
                                        <input type="text" id="estiloJardin" name="estiloJardin" class="input">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                    </label>
                                    <label>
                                        <div class="form-group">
                                            <label for="imagen">Subir imagen</label>
                                            <input type="file" id="image" name="image">
                                        </div>
                                    </label>
                                    <button type="submit">submit</button>
                                </form>


                            </div>

                        </div>
                        <!-- // Page content -->

                       
                </div>
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