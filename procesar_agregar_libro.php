<?php
session_start();
include_once('include/dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    // Paso 1: Obtener el ID del usuario actual desde la sesión
    $userId = $_SESSION['user_id'];

    // Paso 2: Obtener el ID del libro
    $nombreLibro = $_POST['titulo'];
    $database = new Connection();
    $bd = $database->open();

    // Consultar el ID del libro por su nombre
    $stmtLibro = $bd->prepare("SELECT id FROM libro WHERE titulo = :nombre");
    $stmtLibro->bindParam(':nombre', $nombreLibro);
    $stmtLibro->execute();
    $libro = $stmtLibro->fetch(PDO::FETCH_ASSOC);

    if (!$libro) {
        // El libro no existe, manejar el error o agregar lógica según sea necesario
        echo "Error: El libro no existe en la base de datos.";
        exit();
    }

    $libroId = $libro['id'];


    $motivoCambio = $_POST['motivo_cambio'];

    $stmtInsert = $bd->prepare("INSERT INTO librosusuarios (usuario_id, libro_id, foto_libro, motivo_cambio) VALUES (:usuario_id, :libro_id, :foto_libro, :motivo_cambio)");
    $stmtInsert->bindParam(':usuario_id', $userId);
    $stmtInsert->bindParam(':libro_id', $libroId);
    $stmtInsert->bindParam(':foto_libro', $fotoLibro);
    $stmtInsert->bindParam(':motivo_cambio', $motivoCambio);

    if ($stmtInsert->execute()) {
        echo "Libro agregado correctamente.";
    } else {
        echo "Error al agregar el libro.";
    }

    $_SESSION['message'] = '¡Tu libro se ha guardado correctamente!';
    $_SESSION['message_type'] = 'Success!';


    // Cerrar la conexión a la base de datos
    $database->close();
}
?>
