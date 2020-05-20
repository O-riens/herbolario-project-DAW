<?php
// Include config file
require_once "config/bd.php";
 
// Define variables and initialize with empty values
$password = $email = $confirm_password = "";
$password_err = $email_err= $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduzca una contraseña.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La contraseña debe de tener al menos 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Vuelva a escribir la contraseña.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "La contraseña no coincide.";
        }
    }

    // Validate email

    if(empty(trim($_POST["email"]))){
        $email_err = "Introduzca un email.";     
    } else {
        if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Formato inválido.";
        } else {
        $email = trim($_POST["email"]);
        }
    }


    // Check input errors before inserting in database
    if(empty($password_err)  && empty($email_err) && empty($confirm_password_err)){
        
        $select = $db->query("SELECT email FROM usuarios");
        $sth = $db->query($sql);
        $result=mysqli_fetch_array($select);
        $email = $result['email'];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $update = $db->query("UPDATE usuarios SET email = '$email', password = '$password_hash' WHERE email = '$email'");
    
        if($update){ 
            header("Location: index.php"); 
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
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	
	<div class="container-login100" style="background-image: url('img/bg-03.jpg');">
		<div class="wrap-login100 p-l-40 p-r-40 p-t-80 p-b-30">
        <h3>¿Has olvidado tu contraseña</h3>
	                <p>Cambie su contraseña con estos tres pasos. ¡Hagamos segura su contraseña!</p>
	                <ol class="list-unstyled m-t-10">
	                    <li><span class="text-primary text-medium">1. </span>Introduzca el correo.</li>
	                    <li><span class="text-primary text-medium">2. </span>Nuestro sistemas le enviar&aacute; la contraseña</li>
	                    <li><span class="text-primary text-medium">3. </span>¡Click en el bot&oacute;n!</li>
	                </ol>
	            </div>
	            <form class="card mt-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
	                <div class="card-body">
                    <div class="form-group"> <label for="email_for_pass">Introduzca su correo</label> <input class="form-control" type="text" id="email" name="email" required=""><small class="form-text text-muted">Introduzca el correo con el que se registr&oacute; en nuestra p&aacute;gina web.</small> </div>
                    <div class="form-group"> <label for="password_for_pass">Introduzca la contraseña</label> <input class="form-control" type="text" id="password" name="password" required=""> </div>
                    <div class="form-group"> <label for="-confirm_password_pass">Introduzca de nuevo la contraseña</label> <input class="form-control" type="text" name="confirm_password"  id="confirm_password" required=""></div>
	                </div>
	                <div class="card-footer"> <button class="btn btn-success" type="submit">Obtener password</button> 
                    <button onclick="window.location.href='index.php'" class="btn btn-info" type="submit">Volver al login</button> </div>
	            </form>

			
		</div>
	</div>
	
	

	<div id="dropDownSelect1"></div>
	
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

</body>
</html>

            