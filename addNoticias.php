<?php

// Initialize the session
session_start();

// Include config file
require_once "config/bd.php";
 
// Define variables and initialize with empty values
$titulo = $imgContent = $entrada = $cuerpo = '';

    // Obtener ID para insertar en la BBDD
    $nombre = $_SESSION['nombre'];
    $id = "SELECT id FROM usuarios WHERE nombre = '$nombre'";
    $sth = $db->query($id);
    $row = mysqli_fetch_assoc($sth);
    $user_id = $row['id'];



$titulo_err = $menosDiezMil_err = '';

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate titulo
    if(empty(trim($_POST["titulo"]))){
        $titulo_err = "Introduzca el titular.";
        } else{
        // Prepare a select statement
        $sql = "SELECT noticiaId FROM articulos WHERE titulo = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_titulo);
            
            // Set parameters
            $param_titulo = trim($_POST["titulo"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $titulo_err = "Este nombre ya existe.";
                } else{
                    $titulo = trim($_POST["titulo"]);
                }
            } else{
                echo "Oops! Algo salió mal, pruebe de nuevo.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

        // Validate cuerpo y entrada
        if(empty(trim($_POST["cuerpo"])) && empty(trim($_POST["entrada"]))){
            $menosDiezMil_err = "Son datos obligatorios.";     
        } elseif((strlen(trim($_POST["cuerpo"])) && strlen(trim($_POST["entrada"]))) > 10000){
            $menosDiezMil_err = "Debe tener una longitud menor de 10000 caracteres.";
        } else{
            $cuerpo = trim($_POST["cuerpo"]);
            $entrada = trim($_POST["entrada"]);
        }
        

    // Check input errors before inserting in database
    if(empty($titulo_err) && empty($menosDiezMil_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO articulos (titulo, cuerpo, entrada, autorId) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss",
            $param_titulo,
            $param_entrada,
            $param_cuerpo,
            $param_autorId);
            
            // Set parameters
            $param_titulo = $titulo;
            $param_entrada = $entrada;
            $param_cuerpo = $cuerpo;
            $param_autorId = $user_id;
                        
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
                        $insert = $db->query("UPDATE articulos SET imagen = '$imgContent' WHERE titulo = '$titulo'"); 
                                                                            
                    }
        } 

                header('Location: noticias.php');
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
                        <h1 class="display-4" style="text-align:center; font-style: oblique">Añadir art&iacute;culos</h1>
                        <br/>
                        <!-- Page content -->
                        <div class="content">
                            <hr>
                            <div class="row">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>
                                        <p class="label-txt">T&Iacute;TULO</p>
                                        <input type="text" id="titulo" name="titulo" class="input">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                    </label>
                                    
                                    <label>
                                        <p class="label-txt">ENTRADA</p>
                                        <br/>
                                        <textarea id="entrada" name="entrada" style="background-color: white;" class="input"></textarea>
                                    </label>

                                    <label>
                                        <p class="label-txt">CUERPO</p>
                                        <br/>
                                        <textarea id="cuerpo" name="cuerpo" style="background-color: white;" class="input"></textarea>
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