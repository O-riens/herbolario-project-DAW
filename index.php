<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: plantas.php");
    exit;
}
 
// Include config file
require_once "config/bd.php";
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Introduzca el email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduzca la contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, nombre, email, password, tipoUsuario FROM usuarios WHERE email = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $nombre, $email, $hashed_password, $tipoUsuario);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
							$_SESSION["id"] = $id;
							$_SESSION["nombre"] = $nombre;
							$_SESSION["email"] = $email;  
							$_SESSION["tipoUsuario"] = $tipoUsuario;                            
							
							
							header("location: plantas.php");

                        } else{
                            // Display an error message if password is not valid
                            $password_err = "La contraseña no es válida.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No existe cuenta con ese email.";
                }
            } else{
                echo "Oops! Algo salió mal, inténtelo más tarde.";
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
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	
	<div class="container-login100" style="background-image: url('img/bg-06.jpg');">
		<div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
			<form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<span class="login100-form-title p-b-37">
				<h2>
					Iniciar Sesión
				</h2>
				</span>

				<div class="wrap-input100 validate-input m-b-20 <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>" data-validate = "Formato: ex@abc.xyz">
					<input class="input100" type="email" name="email" placeholder="email">
					<span class="focus-input100"></span>
					<span class="help-block"><?php echo $email_err; ?></span>
				</div>
					

				<div class="wrap-input100 validate-input m-b-25 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" data-validate = "Introduzca la contraseña">
					<input class="input100" title="password" type="password" name="password" placeholder="contraseña">
					<span class="focus-input100"></span>
					<span class="help-block"><?php echo $password_err; ?></span>
				</div>


				<div class="container-login100-form-btn">
					<button class="login100-form-btn" type="submit">
						Iniciar Sesión
					</button>
				</div>

				<div class="container-login100-form-btn m-t-30">
					<p>Forgot password? <a href="forgotPassword.php">Restaurar</a></p>
				</div>

				<div class="text-center p-t-57 p-b-20 m-b-30">
					<span class="txt1">
						O Iniciar Sesión
					</span>
					<div class="text-center p-t-10 p-b-20">
					<span class="txt1">
					<a href="plantas.php">Como invitado</a>
					</span>
				</div>
				</div>


				<hr/>

				<div class="text-center txt2 hov1">
					<a href="registro.php">Registrarse</a>
				</div>
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