<?php

// Initialize the session
session_start();

require_once "config/bd.php";
 
// If file upload form is submitted 
$status = $statusMsg = ''; 

if(isset($_POST["submit"])){ 
    $status = 'error'; 
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
            $user = $_SESSION['nombre'];
            // Insert image content into database 
            $insert = $db->query("UPDATE usuarios SET img = '$imgContent' WHERE nombre = '$user'"); 

            if($insert){ 
                $status = 'success'; 
                $statusMsg = '<script type="text/JavaScript">  
                                alert("Se ha actualizado exitosamente."); 
                            </script>' ; 
            }else{ 
                $statusMsg = '<script type="text/JavaScript">  
                                alert("Error, hazlo de nuevo."); 
                            </script>'; 
            }  
        }else{ 
            $statusMsg =  '<script type="text/JavaScript">  
                                alert("Solo se permiten las extensiones JPG, JPEG, PNG, & GIF."); 
                            </script>'; 
        } 
    }else{ 
        $statusMsg = '<script type="text/JavaScript">  
                        alert("Seleccione una imagen."); 
                    </script>';  
    } 
}

// Display status message 
echo $statusMsg; 

if(isset($_POST['nombreCambio']))
{
    $user = $_SESSION['nombre'];
    $nombre = $_POST['nombreCambio'];
    $insert = $db->query("UPDATE usuarios SET nombre = '$nombre' WHERE nombre = '$user'");

    if($insert){ 
        $_SESSION['nombre'] = $nombre; 
    }
    
} elseif (isset($_POST['email']))
{
    $user = $_SESSION['nombre'];
    $email = $_POST['email'];

    $insert = $db->query("UPDATE usuarios SET email = '$email' WHERE nombre = '$user'");

    if($insert){ 
        $_SESSION['email'] = $email; 
    }

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
    <link rel="stylesheet" type="text/css" href="css/title.css">
    <link rel="stylesheet" href="css/sidebar-themes.css">
<!--===============================================================================================-->
</head>
<body>
<div class="page-wrapper default-theme sidebar-bg bg1 toggled">
<?php require_once "admin/includes/sidebar.php"; ?>
        <!-- page-content  -->
        <main class="page-content" style="background-image: url(img/bg5.jpg); height: 100%; ">
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5">
                
                <div class="row">
                    <div class="form-group col-md-12">
                    <div class="form-group col-md-12">
                        <a id="toggle-sidebar" class="btn btn-secondary rounded-0" href="#">
                            <span>Mostrar/Ocultar Men&uacute;</span>
                        </a>
                    </div>
                        <h1 class="display-4" style="text-align:center; font-style: oblique">Ajustes</h1>
                        <br/>
                        <div style="text-align:center;">
                        <?php  
                            if($_SESSION['img'] = 'NULL'  && !isset($_SESSION['nombre'])){
                                echo '<img src="img/user.jpg" alt="Perfil Invitado" height="300" width="500" style="border-radius: 70px"/>'; 
                            } else {
                                $user = $_SESSION['nombre'];
                                $sql = "SELECT * FROM usuarios WHERE nombre = '$user'";
                                $sth = $db->query($sql);
                                $result=mysqli_fetch_array($sth);
                                echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['img'] ).'" alt="Perfil" height="300" width="500" style="border-radius: 70px"/>';      
                            }
                    ?>
            
                    </div>
                    </div>
                </div>
                <hr>

                <br/>
                <div class="card text-center">
                    <div style="text-align:center;" class="card-header">
                        Cambiar imagen de perfil
                    </div>
                    <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                          <label>Select Image File:</label>
                          <input type="file" name="image">
                          <input type="submit" name="submit" value="Actualizar">
                      </form>
                      
                    </div>
                    
                </div>
                

                <br/>
                <hr>
                <br/> 

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="card-deck">
                        <div class="card">
                            <div class="card-body mb-4">
                                <h5 class="card-title">Nombre</h5>
                                <hr/>
                                <div class="input-group">
                                    <input type="text" name="nombreCambio" class="form-control" placeholder="Nombre" aria-label="Nombre"
                                        aria-describedby="nombre">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-md btn-outline-default m-0 px-3 py-2 z-depth-0 waves-effect" id="nombreCambio">Cambiar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="card">
                            <div class="card-body mb-4">
                                <h5 class="card-title">Email</h5>
                                <hr/>
                                <div class="input-group">
                                    <input type="text" name="email" class="form-control" placeholder="Email" aria-label="Email"
                                        aria-describedby="email">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-md btn-outline-default m-0 px-3 py-2 z-depth-0 waves-effect" id="email">Cambiar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
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