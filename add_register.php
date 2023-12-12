<?php
session_start();
include_once('./include/dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrarme'])) {

    if ($_POST['contrasena'] !== $_POST['confirmar_contrasena']) {
        // Contraseñas no coinciden, muestra un mensaje de error
        $_SESSION['message'] = 'Las contraseñas no coinciden';
    } else {
        $database = new Connection();
        $bd = $database->open();

        try {
            // Cifrar la contraseña antes de almacenarla
            $hashed_password = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

            $stmt = $bd->prepare("INSERT INTO usuario(nombre, apellido, fecha_nacimiento, correo_electronico, contrasena, estado_pais, telefono, genero) VALUES(:nombre, :apellido, :fecha_nacimiento, :correo_electronico, :contrasena, :estado_pais, :telefono, :genero)");

            // Nos ayuda a darle a entender cuales son los marcadores o parametros. Si solo fuera uno, no sería necesario usan bind
            $stmt->bindParam(':nombre', $_POST['nombre']);
            $stmt->bindParam(':apellido', $_POST['apellido']);
            $stmt->bindParam(':fecha_nacimiento', $_POST['fecha_nacimiento']);
            $stmt->bindParam(':correo_electronico', $_POST['correo_electronico']);
            $stmt->bindParam(':contrasena', $hashed_password); // Usar la contraseña cifrada
            $stmt->bindParam(':estado_pais', $_POST['estado_pais']);
            $stmt->bindParam(':telefono', $_POST['telefono']);
            $stmt->bindParam(':genero', $_POST['genero']);

            $_SESSION['message'] = ($stmt->execute()) ? 'Usuario agregado correctamente' : 'Algo salió mal, no se registró correctamente el usuario';
        } catch (PDOException $e) {
            $_SESSION['message'] = $e->getMessage();
        }

        $database->close();
    }
} else {
    $_SESSION['message'] = 'Llene completamente el formulario';
}

header('location: login.php');
?>
