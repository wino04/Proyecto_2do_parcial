<?php
session_start();
include_once('include/dbconn.php');

if (isset($_POST['editar'])) {
    $database = new Connection();
    $db = $database->open();

    try {
        $id = $_POST['libroId']; // Cambié de $_GET a $_POST para obtener el ID
        $nuevoMotivo = $_POST['nuevoMotivo']; // Ajusta el nombre del campo según tu formulario

        // Modifica la consulta para actualizar el motivo_cambio en lugar de pieza, marca, etc.
        $sql = "UPDATE librosusuarios SET motivo_cambio = '$nuevoMotivo' WHERE id = '$id'";

        $_SESSION['message'] = ($db->exec($sql)) ? 'Libro actualizado correctamente' : 'No se pudo actualizar correctamente';
    } catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    $database->close();
} else {
    $_SESSION['message'] = 'Completa correctamente el formulario';
}

// Redirige a la página de libros después de editar
header('location: mis_libros.php');
?>
