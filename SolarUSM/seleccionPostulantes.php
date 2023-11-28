<?php
include("template/headerc.php");
//session_start();
$id = $_SESSION["idusuario"];
if (isset($_POST['aceptar'])) {
    $id_solicitud = $_POST['id_solicitud'];
    $sql = "UPDATE solicitudes SET estado_solicitud = true WHERE id_solicitud = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_solicitud);
    $stmt->execute();
    /*
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
    echo "Solicitud Aceptada";
    echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
    echo "</div>";*/
    echo "<div class='message'> Temporero seleccionado </div>";
}
if (isset($_POST['rechazar'])) {
    $id_solicitud = $_POST['id_solicitud'];
    $sql = "UPDATE solicitudes SET estado_solicitud = false WHERE id_solicitud = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_solicitud);
    $stmt->execute();
    /*
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
    echo "Solicitud Rechazada";
    echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
    echo "</div>";*/
    echo "<div class='message2'> Temporero rechazado </div>";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <title>Contratista</title>
    <style>
        /* Estilo para la tabla */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        /* Estilo para las celdas de la tabla */
        table, th, td {
            border: 1px solid black; /* Agrega un borde a todas las celdas */
        }
        /* Estilo para los encabezados de la tabla */
        th {
            background-color: #f2f2f2; /* Color de fondo */
        }
        .message {
            background-color: #4CAF50; /* Fondo verde para indicar éxito */
            color: #fff; /* Texto blanco para contraste */
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .message2 {
            background-color: #FFD700;
            color: black; /* Texto blanco para contraste */
            font-weight: bold;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<h2 style="text-align: center; margin-bottom: 10px;">Postulantes</h2>
    <?php
        /*
        // Consulta SQL para seleccionar todas las solicitudes de forma alternativa (Más simple pero no entrega los nombres).
        //$sql = "SELECT id_solicitud, nombre_trabajo, id_temporero FROM (SELECT soli.id_solicitud, soli.id_temporero, soli.id_trabajo, traba.nombre_trabajo, traba.runcontratista FROM solicitudes AS soli, trabajos AS traba WHERE soli.id_trabajo = traba.id_trabajo) AS combinada WHERE combinada.runcontratista = ?";
        // Consulta SQL para seleccionar todas las solicitudes.
        $sql = "SELECT id_solicitud, nombre_usuario, nombre_trabajo FROM (SELECT solinombre.id_solicitud, solinombre.nombre_usuario, traba.nombre_trabajo, traba.runcontratista FROM (SELECT soli.id_trabajo, soli.id_solicitud, temp.nombre_usuario FROM solicitudes AS soli, temporeros AS temp WHERE soli.id_temporero = temp.id_temporero) AS solinombre, trabajos AS traba WHERE solinombre.id_trabajo = traba.id_trabajo) AS combinada WHERE combinada.runcontratista = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            echo '<div style="margin-top: 20px;">';
            echo "<table>";
            echo "<tr><th>Nombre Trabajo</th><th>Nombre del Temporero</th><th>Aceptar</th><th>Rechazar</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nombre_trabajo'] . "</td>";
                echo "<td>" . $row['nombre_usuario'] . "</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='id_solicitud' value='" . $row['id_solicitud'] . "'>";
                echo "<input type='submit' name='aceptar' value='Aceptar'>";
                echo "</form>";
                echo "</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='id_solicitud' value='" . $row['id_solicitud'] . "'>";
                echo "<input type='submit' name='rechazar' value='Rechazar'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table";
            echo '</div>';
        }
        */
    ?>
    <?php
    // Consulta SQL para seleccionar todas las solicitudes.
    $sql = "SELECT id_solicitud, nombre_usuario, id_temporero, nombre_trabajo, estado_solicitud FROM (SELECT solinombre.id_solicitud, solinombre.nombre_usuario, solinombre.id_temporero, traba.nombre_trabajo, traba.runcontratista, solinombre.estado_solicitud FROM (SELECT soli.id_trabajo, soli.id_solicitud, soli.estado_solicitud, soli.id_temporero, temp.nombre_usuario FROM solicitudes AS soli, temporeros AS temp WHERE soli.id_temporero = temp.id_temporero) AS solinombre, trabajos AS traba WHERE solinombre.id_trabajo = traba.id_trabajo) AS combinada WHERE combinada.runcontratista = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo '<div style="margin-top: 20px;">';
        echo "<table>";
        echo "<tr><th>Nombre Trabajo</th><th>Nombre del Temporero</th><th>Aceptar</th><th>Rechazar</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['nombre_trabajo'] . "</td>";
            echo "<td><a href='perfiltemp.php?id_temporero=" . $row['id_temporero'] . "'>" . $row['nombre_usuario'] . "</a></td>";
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='id_solicitud' value='" . $row['id_solicitud'] . "'>";
            
            // Mostrar el botón Aceptar solo si el estado es null o false
            if ($row['estado_solicitud'] === null || $row['estado_solicitud'] === 0) {
                echo "<input type='submit' name='aceptar' value='Aceptar'>";
            } else {
                echo "<button type='button' disabled>Aceptar</button>";
            }

            echo "</form>";
            echo "</td>";
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='id_solicitud' value='" . $row['id_solicitud'] . "'>";

            // Mostrar el botón Rechazar solo si el estado es null o true
            if ($row['estado_solicitud'] === null || $row['estado_solicitud'] === 1) {
                echo "<input type='submit' name='rechazar' value='Rechazar'>";
            } else {
                echo "<button type='button' disabled>Rechazar</button>";
            }

            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table";
        echo '</div>';
    }
    ?>
</body>
</html>