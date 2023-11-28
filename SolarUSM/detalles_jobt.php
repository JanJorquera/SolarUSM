<?php
include("template/headert.php");
include "conexion.php";


if (isset($_GET['id_trabajo'])) {

    $id_trabajo = $_GET['id_trabajo'];

    $sql_trabajos = "SELECT * FROM trabajos_transportes WHERE id_transportes = '$id_trabajo'";
    $result_trabajos = $conn->query($sql_trabajos);
    $row = $result_trabajos->fetch_assoc();

    $run = $row['rut_contratista'];
    $info_contratista = "SELECT * FROM contratista WHERE runcontratista = '$run'";
    $result_info_contratista = $conn->query($info_contratista);
    $info = $result_info_contratista->fetch_assoc();


    //Procesar la solicitud si se hace clic en el botón
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["id_trabajo"]) && isset($_POST["solicitar_trabajo"])) {
            $id_trabajo = $_POST["id_trabajo"];
            $id_transportista = $_SESSION["idusuario"]['id_transportista'];

            //Consultar si ya existe una solicitud para este transportistas y trabajo
            $sql_check_solicitud = "SELECT * FROM solicitudes_trans WHERE id_transportista = '$id_transportista' AND id_transportes = '$id_trabajo'";
            $result_check_solicitud = $conn->query($sql_check_solicitud);

            if ($result_check_solicitud->num_rows == 0) {
                //Si no existe la solicitud, la insertamos
                $sql_insert_solicitud = "INSERT INTO solicitudes_trans (id_transportista, id_transportes) VALUES ('$id_transportista', '$id_trabajo')";
                $result_insert_solicitud = $conn->query($sql_insert_solicitud);

                if (!$result_insert_solicitud) {
                    echo "Error al insertar la solicitud: " . $conn->error;
                } else {
                        echo "<div class='message'>Has postulado exitosamente al trabajo: " . $row['nombre_trabajo'] . "</div>";

                }
            } else {
                echo "<div class='message2'>Ya has postulado a este trabajo.</div>";
            }
        }
    }
    
    $id_transportista = $_SESSION["idusuario"]['id_transportista'];

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/trabajos.css">
    <title>Imagen arriba, información abajo</title>

    <link rel="stylesheet" href="css/trabajos.css">

    <style>
        /* Estilo para la imagen en la parte superior */
        .imagen-superior {
            display: block;
            margin: 0 auto; /* Centra horizontalmente la imagen */
            max-width: 100%; /* Ajusta el ancho máximo de la imagen */
        }

        /* Estilo para el contenedor */
        .contenedor {
            text-align: center; /* Centra horizontalmente el contenido */
        }

        .message {
            background-color: #4CAF50; /* Fondo verde para indicar éxito */
            color: #fff; /* Texto blanco para contraste */
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
        }

        .message2 {
            background-color: #FFD700; /* Fondo verde para indicar éxito */
            color: black; /* Texto blanco para contraste */
            font-weight: bold;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
    
</head>
<body>
    <img class="card-img-top text-center" src="<?php echo $row['imagen_referencia'] ?>" alt="" style="max-width: 50%; display: block;
        margin: auto; margin-top: 20px;">

            <div class="card-body">
                <h4 class="card-title">Trabajo: <?php echo $row['nombre_trabajo'] ?></h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $row['detalle_trabajo'] ?></li>
                    <li class="list-group-item">Ubicacion: <?php echo $row['ubicacion'] ?></li>
                    <li class="list-group-item">Valor a pagar: $<?php echo $row['valor_pagar'] ?></li>
                    <li class="list-group-item">Fecha inicio: <?php echo $row['fecha_inicio'] ?></li>
                    <li class="list-group-item">Fecha termino: <?php echo $row['fecha_termino'] ?></li>
                    <li class="list-group-item">Hora inicio jornada: <?php echo $row['hora_inicio'] ?></li>
                    <li class="list-group-item">Hora termino jornada: <?php echo $row['hora_fin'] ?></li>
                    <li class="list-group-item">Capacidad mínima que debe tener el vehículo: <?php echo $row['capacidad_minima'] ?></li>
                </ul>

                <?php
                    $nombre = $info['nombre'] ?? '-'; // Si $info['nombre'] es null, se establece como guion.
                    $telcontacto = $info['telcontacto'] ?? '-';
                    $contacto = $info['contacto'] ?? '-';
                    $whatsapp = $info['whatsapp'] ?? '-';
                    $correo = $info['correo'] ?? '-';
                ?>

                <h4 class="card-title"><br>Oferta creada por: <?php echo $nombre ?></h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Telefono contacto: <?php echo $telcontacto ?></li>
                    <li class="list-group-item">Telefono contacto alternativo: <?php echo $contacto ?></li>
                    <li class="list-group-item">Telefono whatsapp: <?php echo $whatsapp ?></li>
                    <li class="list-group-item">Correo: <?php echo $correo ?></li>
                </ul>
                
                <br>
                <?php
                    
                    $sql_check_solicitud = "SELECT * FROM solicitudes_trans WHERE id_transportista = '$id_transportista' AND id_transportes = '{$row['id_transportes']}'";
                    $result_check_solicitud = $conn->query($sql_check_solicitud);

                    if ($result_check_solicitud->num_rows == 0) {
                        //Si no se ha solicitado, mostrar el botón
                        ?>
                        <form method='POST'>
                            <input type='hidden' name='id_trabajo' value='<?php echo $row['id_transportes']; ?>'>
                            <button class="btn-solicitar" type='submit' name='solicitar_trabajo'>Solicitar Trabajo</button>
                        </form>
                    <?php }   else {?>
                        <!-- #Si ya se ha solicitado, mostrar mensaje y botón bloqueado -->
                        <button class='btn-solicitado' disabled>Solicitado</button> 
                    <?php }  ?>
            </div>

</body>
</html>

<?php } ?>