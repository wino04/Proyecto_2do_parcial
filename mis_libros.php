<?php
session_start();
include_once('funciones.php'); // Incluye el archivo funciones.php

// Obtén el ID del usuario actual desde la sesión
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$userId = $_SESSION['user_id'];




// Consulta los libros del usuario desde la tabla "librosusuarios"
$database = new Connection();
$bd = $database->open();

if (isset($_GET['eliminar'])) {
    $libroIdEliminar = $_GET['eliminar'];
    // Realiza la lógica de eliminación en la base de datos (debes implementarla)
    eliminarLibro($libroIdEliminar);
    // Redirecciona a la misma página para actualizar la vista
    header('Location: mis_libros.php');
    exit();
}


$stmtLibrosUsuario = $bd->prepare("SELECT librosusuarios.*, libro.titulo FROM librosusuarios INNER JOIN libro ON librosusuarios.libro_id = libro.id WHERE librosusuarios.usuario_id = :user_id");
$stmtLibrosUsuario->bindParam(':user_id', $userId);
$stmtLibrosUsuario->execute();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/styleall.css">

    <title>SwitchBook - Mis libros</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">SwitchBook</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    // Verificar si el usuario está autenticado (puedes tener tu propia lógica de autenticación)
                    if (isset($_SESSION['user_id'])) {
                        // Obtener el nombre del usuario desde la sesión
                        $userName = obtenerNombreUsuario(); // Debes implementar esta función
                        echo '<li class="nav-item"><span class="nav-link">¡Hola, ' . $userName . '!</span></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>';
                    } else {
                        // Si no está autenticado, mostrar enlaces de inicio de sesión o registro
                        echo '<li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="register.php">Registrarse</a></li>';
                    }
                    ?>
                </ul>

            </div>
        </div>
    </nav>

    <h2>Agregar libros</h2>
    <div>
        <div class="container row">
            <div class="row g-3">

                <form action="procesar_agregar_libro.php" method="POST" enctype="multipart/form-data" class="row">
                    <div class="col-md-6">
                        <label for="titulo" class="form-label">Nombre del libro</label>
                        <select type="text" name="titulo" id="titulo" class="form-control" required autofocus>
                            <?php
                        // Conéctate a la base de datos y selecciona los nombres de libros
                        $database = new Connection();
                        $bd = $database->open();

                        $stmt = $bd->query("SELECT titulo FROM libro");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['titulo'] . '">' . $row['titulo'] . '</option>';
                        }

                        $database->close();
                        ?>
                        </select>
                    </div>
                   
                    <div class="col-md-6">
                        <label for="motivo_cambio" class="form-label">Descripción/Motivo del cambio</label>
                        <input type="text" name="motivo_cambio" class="form-control" required autofocus>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" name="agregar">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h2>Mis libros</h2>
    <?php
        while ($libroUsuario = $stmtLibrosUsuario->fetch(PDO::FETCH_ASSOC)) {
        ?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-2">
                <?php
            $libroId = $libroUsuario['libro_id'];
            $imagen_ruta = "public/media/portadas/" . $libroId . ".jpg"; // Puedes ajustar la extensión según el tipo de imagen que estés utilizando
            
            if (file_exists($imagen_ruta)) {
                echo '<img src="' . $imagen_ruta . '" class="img-fluid rounded-start" alt="Portada del libro">';
            } else {
                echo 'Imagen no encontrada';
            }
            ?>
            </div>
            <div class="col-md-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $libroUsuario['titulo']; ?></h5>
                    <p class="card-text" id="motivo_<?php echo $libroUsuario['id']; ?>">
                        <?php echo $libroUsuario['motivo_cambio']; ?>
                    </p>
                    <form action="delete_libro.php" method="POST">
                        <input type="hidden" name="libroId" value="<?php echo $libroUsuario['id']; ?>">

                    </form>
                    <form action="edit_libro.php" method="POST">
                        <input type="hidden" name="libroId" value="<?php echo $libroUsuario['id']; ?>">
                        <a class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editModal_<?php echo $libroUsuario['id']; ?>">Editar</a>

                        <div class="modal fade" id="editModal_<?php echo $row['id']; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar descripción del
                                            libro/Motivo de cambio</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST"
                                            action="edit_libro.php? id=<?php echo $libroUsuario['id']; ?>">

                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    <label class="control-label">Motivo:</label>
                                                    <input type="text" class="form-control" name="nuevoMotivo"
                                                        value="<?php echo $row['motivo_cambio']; ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" name="editar"
                                                    class="btn btn-primary">Guardar</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>



                    <a class="btn btn-danger"
                        href="delete_libro.php?id=<?php echo $libroUsuario['libro_id']; ?>">Eliminar</a>

                    </form>

                    



                </div>
            </div>
        </div>
    </div>

    <?php
    }
    $database->close();
    ?>

<div class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


    <script src="public/js/bootstrap.min.js"></script>

</body>

</html>