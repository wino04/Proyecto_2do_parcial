    function editarMotivo(libroId) {
        var nuevoMotivo = prompt("Edita el motivo/descripción:");
        if (nuevoMotivo !== null && nuevoMotivo !== "") {
            // Puedes utilizar AJAX para enviar la nueva descripción/motivo al servidor y actualizar la base de datos
            // Aquí solo actualizamos el contenido en el frontend para demostración
            document.getElementById("motivo_" + libroId).innerText = nuevoMotivo
        }
    }

