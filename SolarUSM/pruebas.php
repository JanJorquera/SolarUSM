<?php
include "conexion.php";

// Subir la imagen y almacenarla en la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n_imagen = $_FILES["imagen"]["name"];
    $archivo = $_FILES["imagen"]["tmp_name"];

    $ruta = "./imagenes/" . $n_imagen;
    $base_datos = "imagenes/" . $n_imagen;

    move_uploaded_file($archivo, $ruta);
    // Insertar datos en la tabla "contratista"
    $sql = "INSERT INTO imagenes (dir) VALUES (?)";
    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Enlazar los parámetros
        $stmt->bind_param("s", $base_datos);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo '
            <script>
            alert("Datos ingresados exitosamente");
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Los datos no pudieron ser ingresados");
            </script>
            ';
        }
    }
}
    $id = 2;
    $query = "SELECT * FROM imagenes WHERE id = '$id'";
    $result = $conn->query($query);
    $result = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir y Mostrar Imágenes</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="formFile">Ingrese una imagen</label>
            <input type="file" name="imagen" required>
        </div>
        <button type="submit">Enviar datos</button>
    </form>
    <div>
        <img src="<?php echo $result['dir'] ?>" alt="...">
    </div>
</body>
</html>