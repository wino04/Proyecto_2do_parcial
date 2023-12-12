<?php
include_once('./include/dbconn.php');

function obtenerNombreUsuario() {
    
    $userId = $_SESSION['user_id'];

    // Realiza una consulta para obtener el nombre del usuario según su ID
    $database = new Connection();
    $bd = $database->open();

    $stmt = $bd->prepare("SELECT nombre FROM usuario WHERE id = :user_id");
    $stmt->bindParam(':user_id', $userId); 
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cierra la conexión a la base de datos
    $database->close();

    // Retorna el nombre del usuario
    return $userData['nombre'];
}

function obtenerNombreImagenDesdeBD($libroId) {
    $database = new Connection();
    $bd = $database->open();

    $stmt = $bd->prepare("SELECT foto_libro FROM librosusuarios WHERE libro_id = :libro_id");
    $stmt->bindParam(':libro_id', $libroId);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $database->close();

    if ($result) {
        return $result['foto_libro'];
    } else {
        return false; // O maneja el caso en que no encuentre la imagen
    }
}


function obtenerEstadoUsuario($userId) {
    return 'EJEMPLO_ESTADO';
    $database->close();

    return $userData['nombre'];
}


?>
