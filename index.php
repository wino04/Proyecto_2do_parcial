<?php
session_start();
include_once('funciones.php');

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$userState = obtenerEstadoUsuario($userId);

$database = new Connection();
$bd = $database->open();

$stmtLibrosCercanos = $bd->prepare("SELECT librosusuarios.*, libro.titulo AS nombre_libro, libro.descripcion, usuario.nombre AS nombre_dueño, usuario.estado_pais AS estado_dueño, librosusuarios.motivo_cambio FROM librosusuarios INNER JOIN libro ON librosusuarios.libro_id = libro.id INNER JOIN usuario ON librosusuarios.usuario_id = usuario.id WHERE librosusuarios.usuario_id != :user_id AND usuario.estado_pais = :user_state");

$stmtLibrosCercanos->bindParam(':user_id', $userId);
$stmtLibrosCercanos->bindParam(':user_state', $userState);
$stmtLibrosCercanos->execute();

$stmtLibrosOtrosEstados = $bd->prepare("SELECT librosusuarios.*, libro.titulo AS nombre_libro, libro.descripcion, usuario.nombre AS nombre_dueño, usuario.estado_pais AS estado_dueño, librosusuarios.motivo_cambio FROM librosusuarios INNER JOIN libro ON librosusuarios.libro_id = libro.id INNER JOIN usuario ON librosusuarios.usuario_id = usuario.id WHERE librosusuarios.usuario_id != :user_id AND usuario.estado_pais != :user_state ");

$stmtLibrosOtrosEstados->bindParam(':user_id', $userId);
$stmtLibrosOtrosEstados->bindParam(':user_state', $userState);
$stmtLibrosOtrosEstados->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/styleall.css">
    <title>SwitchBook - Inicio</title>
</head>
<body>
   
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">SwitchBook</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Explorar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mis_libros.php">Mis libros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Comunidad</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $userName = obtenerNombreUsuario();
                        echo '<li class="nav-item"><span class="nav-link">¡Hola, ' . $userName . '!</span></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="register.php">Registrarse</a></li>';
                    }
                    ?>
                </ul>
                
            </div>
        </div>
    </nav>

   
    
    
    
   

<div class="container mt-5">
    <h2>Explora los diferentes libros</h2>
    <div class="row">
        <?php
        while ($libroOtroEstado = $stmtLibrosOtrosEstados->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            
            // Mostrar la imagen
            $libroId = $libroOtroEstado['libro_id'];
            $imagen_ruta = "public/media/portadas/" . $libroId . ".jpg"; // Puedes ajustar la extensión según el tipo de imagen que estés utilizando
            
            if (file_exists($imagen_ruta)) {
                echo '<img src="' . $imagen_ruta . '" class="img-fluid rounded-start" alt="Portada del libro">';
            } else {
                echo 'Imagen no encontrada';
            }

            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $libroOtroEstado['nombre_libro'] . '</h5>';
            echo '<p class="card-text">' . (isset($libroOtroEstado['motivo_cambio']) ? $libroOtroEstado['motivo_cambio'] : 'Sin motivo') . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>



    <script src="public/js/bootstrap.min.js"></script>
</body>
</html>
