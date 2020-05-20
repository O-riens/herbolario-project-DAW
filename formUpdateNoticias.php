<?php 
    session_start();

    require_once "config/bd.php";
    
    
	    $id = $_GET['edit'];	
        $record = mysqli_query($db, "SELECT * FROM articulos WHERE noticiaId=$id");
        $articulo = mysqli_fetch_array($record);

    
    
    if (isset($_POST['update'])) {
        
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $entrada = $_POST['entrada'];
        $cuerpo = $_POST['cuerpo'];

        $insert = $db->query("UPDATE articulos SET titulo = '$titulo', entrada='$entrada', 
        cuerpo='$cuerpo' WHERE noticiaId='$id'");

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
                    $insert = $db->query("UPDATE articulos SET imagen = '$imgContent' WHERE noticiaId = '$id'"); 
                                                                        
                }
            }
            header('location: noticias.php');

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
                        <h1 class="display-4" style="text-align:center; font-style: oblique">Modificar la noticia</h1>
                        <br/>
                        <!-- Page content -->
                        <div class="content">
                            <hr/>
                            <div class="row">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                <div class="form-group col-md-12">
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                    <label>
                                        <p class="label-txt">T&Iacute;TULO</p>
                                        <input type="text" id="titulo" name="titulo" class="input" value="<?php echo $articulo['titulo'];?>">
                                        <div class="line-box">
                                        <div class="line"></div>
                                        </div>
                                    </label>
                                    
                                    <label>
                                        <p class="label-txt">ENTRADA</p>
                                        <br/>
                                        <textarea id="entrada" name="entrada" style="background-color: white;" class="input"><?php echo $articulo['entrada'];?></textarea>
                                    </label>

                                    <label>
                                        <p class="label-txt">CUERPO</p>
                                        <br/>
                                        <textarea id="cuerpo" name="cuerpo" style="background-color: white;" class="input"><?php echo $articulo['cuerpo'];?></textarea>
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