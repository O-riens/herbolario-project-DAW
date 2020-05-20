<?php
// Include config file
require_once "config/bd.php";
 
// Define variables and initialize with empty values
$username = $password = $email = $confirm_password = "";
$username_err = $password_err = $email_err= $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["nombre"]))){
        $username_err = "Introduzca un usuario.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM usuarios WHERE nombre = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["nombre"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Este usuario ya existe.";
                } else{
                    $username = trim($_POST["nombre"]);
                }
            } else{
                echo "Oops! Algo salió mal, pruebe de nuevo.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
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
    if(empty($username_err) && empty($password_err)  && empty($email_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                        
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Salgo salió mal. Pruebe de nuevo.";
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
	
	
	<div class="container-login100" style="background-image: url('img/bg-03.jpg');">
		<div class="wrap-login100 p-l-40 p-r-40 p-t-80 p-b-30">
			<form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
				<span class="login100-form-title p-b-37">
					Registrarse
				</span>
            
				<div class="wrap-input100 validate-input m-b-20 form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" data-validate="Introduzca el usuario">
					<input class="input100" type="text" name="nombre" placeholder="nombre" value="<?php echo $username; ?>">
					<span class="help-block"><?php echo $username_err; ?></span>
				</div>

                <div class="wrap-input100 validate-input m-b-25 form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>" data-validate = "Introduzca el correo">
					<input class="input100" type="email" name="email" value="<?php echo $email; ?>" placeholder="email">
					<span class="help-block"><?php echo $email_err; ?></span>
				</div>

                <div class="wrap-input100 validate-input m-b-25 form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" data-validate = "Introduzca la contraseña">
					<input class="input100" type="password" name="password" value="<?php echo $password; ?>" placeholder="contraseña">
					<span class="help-block"><?php echo $password_err; ?></span>
				</div>

                <div class="wrap-input100 validate-input m-b-25 form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>" data-validate = "Introduzca la contraseña de nuevo">
					<input class="input100" type="password" name="confirm_password" value="<?php echo $confirm_password; ?>" placeholder="contraseña">
					<span class="help-block"><?php echo $confirm_password_err; ?></span>
				</div>

				<div class="container-login100-form-btn">
					<button class="login100-form-btn">
						Registrarse
					</button>
                    
				</div>

				<div class="text-center p-t-57 p-b-20">
					<span class="txt1">
						O regístrate con
					</span>
				</div>

				<div class="flex-c p-b-112">
					<a href="#" class="login100-social-item">
						<i class="fa fa-facebook-f"></i>
					</a>

					<a href="#" class="login100-social-item">
						<img src="img/icons/icon-google.png" alt="GOOGLE">
					</a>
				</div>

				<div class="text-center">
					<a href="#" class="txt2 hov1">
					<a href="index.php">¿Ya tienes una cuenta? Vaya al inicio</a>
					</a>
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

            