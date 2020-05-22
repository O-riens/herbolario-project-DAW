<?php 
    session_start();

    require_once "config/bd.php";
    
    
	    $id = $_GET['edit'];	
        $record = mysqli_query($db, "SELECT * FROM plantas WHERE id=$id");
        $planta = mysqli_fetch_array($record);

    
    
    if (isset($_POST['update'])) {
        
        $id = $_POST['id'];
        $nombreComun = $_POST['nombreComun'];
        $luz = $_POST['luz'];
        $riego = $_POST['riego'];
        $nombreCientifico = $_POST['nombreCientifico'];
        $hojas = $_POST['hojas'];
        $tamañoPlanta = $_POST['tamañoPlanta'];
        $caracteristicas = $_POST['caracteristicas'];
        $floracion = $_POST['floracion'];
        $colorFlor = $_POST['colorFlor'];
        $estiloJardin = $_POST['estiloJardin'];

        $insert = $db->query("UPDATE plantas SET nombreComun = '$nombreComun', luz='$luz', 
        riego='$riego', nombreCientifico='$nombreCientifico', hojas='$hojas', tamañoPlanta='$tamañoPlanta',
        caracteristicas='$caracteristicas', floracion='$floracion', colorFlor='$colorFlor',  
        estiloJardin='$estiloJardin' WHERE id='$id'");

        if($insert) {
            if(!empty($_FILES["image"]["name"])) { 
                // Get file info 
                $fileName = basename($_FILES["image"]["name"]); 
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType, $allowTypes)){ 
                    $image = $_FILES['image']['tmp_name']; 
                    $imgContent = addslashes(file_get_contents($image));
                    $insert = $db->query("UPDATE plantas SET imagen = '$imgContent' WHERE id = '$id'"); 
                                                                        
                }
            }
            header('location: plantas.php');

        } else {
            echo 'No se ha insertado nada';
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
                        <h1 style="text-align:center;">Modificar la planta</h1>
                        <br/>
                        <!-- Page content -->
                        <div class="content">
                            <hr/>
                            <div class="row">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-md-6 mt-1">
                                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                        <p class="label-txt">NOMBRE COM&Uacute;N</p>
                                        <input type="text" id="nombreComun" name="nombreComun"  class="input" value="<?php echo $planta['nombreComun'];?>">
                                        <div class="line-box">
                                            <div class="line"></div>
                                        </div>
                                        </div>
                                            <div class="form-group col-md-6 mt-1">
                                            <p class="label-txt">NOMBRE CIENT&Iacute;FICO</p>
                                                <input type="text" id="nombreCientifico" name="nombreCientifico" class="input" value="<?php echo $planta['nombreCientifico'];?>">
                                                    <div class="line-box">
                                                <div class="line"></div>
                                            </div>
                                    </div>
                                    

                                    <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">LUZ</p>
                                        <input type="text" id="luz" name="luz" class="input" value="<?php echo $planta['luz'];?>">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                        </div>
                                        <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">RIEGO</p>
                                        <input type="text" id="riego" name="riego" class="input" value="<?php echo $planta['riego'];?>">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">FLORACI&Oacute;N (Opcional)</p>
                                        <input type="text" id="floracion" name="floracion" class="input" value="<?php echo $planta['floracion'];?>">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                        </div>
                                        <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">COLOR DE LA FLOR</p>
                                        <input type="text" id="colorFlor" name="colorFlor" class="input" value="<?php echo $planta['colorFlor'];?>">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">HOJAS (Opcional)</p>
                                        <input type="text" id="hojas" name="hojas" class="input" value="<?php echo $planta['hojas'];?>">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                        </div>
                                        <div class="form-group col-md-6 mt-4">
                                        <p class="label-txt">TAMAÑO DE LA PLANTA (Opcional)</p>
                                        <input type="text"id="tamañoPlanta" name="tamañoPlanta" class="input" value="<?php echo $planta['tamañoPlanta'];?>">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                        </div>
                                    </div>
                                       
                                    <label>
                                        <p class="label-txt">CARACTER&Iacute;STICAS</p>
                                        <input type="text" id="caracteristicas" name="caracteristicas" class="input" value="<?php echo $planta['caracteristicas'];?>">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                    </label>
                                    
                                    <label>
                                        <p class="label-txt">ESTILO DE JARD&Iacute;N (Opcional)</p>
                                        <input type="text" id="estiloJardin" name="estiloJardin" class="input" value="<?php echo $planta['estiloJardin'];?>">
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

                                    <button class="btn" type="submit" name="update"  >Actualizar</button>

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