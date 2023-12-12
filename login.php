<?php
session_start();
include_once('./include/dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['iniciar_sesion'])) {
    $email = $_POST['correo_electronico'];
    $password = $_POST['contrasena'];

    $database = new Connection();
    $bd = $database->open();

    $stmt = $bd->prepare("SELECT * FROM usuario WHERE correo_electronico = :email");
    $stmt->bindParam(':email', $email); 
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['contrasena'])) {
        if ($email == 'w@w.com') {
            header('Location: admin.php');
            exit();
        } else {
         
            $_SESSION['user_id'] = $user['id']; 
            header('Location: index.php'); 
            exit();
        }
    } else {
        
        $_SESSION['message'] = 'Correo electrónico o contraseña incorrectos';
        header('Location: login.php'); // Redirige de nuevo al formulario de inicio de sesión
        exit();
    }

    // Paso 4: Cerrar la conexión a la base de datos
    $database->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <title>SwitchBook - Inicia Sesión</title>
</head>

<body background="public/media/fonlog.jpg" class="site-body">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card custom-card">
                    <div class="card-header custom-header">
                        <h3 class="text-center custom-title">Iniciar Sesión</h3>
                    </div>
                    <div class="card-body">
                        <form action="./login.php" method="POST" class="row">
                            <div class="form-group">

                                <input type="email" class="form-control custom-input" name="correo_electronico"id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Correo Electrónico">
                            </div>
                            <div class="form-group">

                                <input type="password" name="contrasena" class="form-control custom-input" id="exampleInputPassword1"
                                    placeholder="Contraseña">
                            </div>


                            <button type="submit" name="iniciar_sesion" class="btn btn-primary custom-btn">Iniciar Sesión</button>
                            <a href="register.php">¿No tienes cuenta? Registrate</a>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="public/js/script.js"></script>
</body>

</html>