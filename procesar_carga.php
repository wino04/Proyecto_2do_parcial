<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
        $targetDir = "uploads/"; // Directorio donde se almacenarán las fotos
        $targetFile = $targetDir . basename($_FILES["foto"]["name"]);

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];

        if (in_array($imageFileType, $allowedFormats)) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile)) {
                echo "La foto se subió correctamente.";
            } else {
                echo "Hubo un error al subir la foto.";
            }
        } else {
            echo "Solo se permiten archivos JPG, JPEG, PNG o GIF.";
        }
    } else {
        echo "Por favor, selecciona una foto.";
    }
}
?>
