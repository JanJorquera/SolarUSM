<?php
include("template/headerc.php");
include "conexion.php";

$id = $_GET['id_temporero'];

// Preparar la consulta SQL
$query = "SELECT * FROM temporeros WHERE id_temporero = '$id'";
$result_temporero = $conn->query($query);
$result = $result_temporero->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos del Trabajador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 20px; /* Ajustado a 20px en lugar de 30px */
            margin-bottom: 10px; /* Agregado un margin-bottom más pequeño */
        }
        h2 {
            text-align: center;
            color: #333;
        }
        p {
            margin-bottom: 10px;
            line-height: 1.6;
            color: #555;
        }
        strong {
            font-weight: bold;
            color: #333;
        }
        .not-found {
            color: #FF0000;
            font-weight: bold;
        }
        img {
            width: 100px;
            display: block;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($result): ?>
            <h2>Datos del Trabajador:</h2>
            <br>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($result['nombre_usuario'])?></p>
            <p><strong>Fecha de Nacimiento:</strong> <?= htmlspecialchars($result['fecha_nac']) ?></p>
            <p><strong>Ciudad:</strong> <?= htmlspecialchars($result['ciudad']) ?></p>
            <p><strong>Dirección:</strong> <?= htmlspecialchars($result['direccion']) ?></p>
            <p><strong>Teléfono:</strong> <?= htmlspecialchars($result['telefono']) ?></p>
            <p><strong>Previsión:</strong> <?= htmlspecialchars($result['sistema_prevision']) ?></p>
            <p><strong>Salud:</strong> <?= htmlspecialchars($result['sistema_salud']) ?></p>
            <p><strong>Jubilado:</strong> <?= htmlspecialchars($result['jubilacion'] ? 'Sí' : 'No') ?></p>
            <p><strong>Detalle Jubilación:</strong> <?= htmlspecialchars($result['detalle_jubilacion']) ?></p>
            <p><strong>Años:</strong> <?= htmlspecialchars($result['experiencia']) ?></p>
            <p><strong>Detalle Exp:</strong> <?= htmlspecialchars($result['detalle_experiencia']) ?></p>

            <?php if (!empty($result['foto1'])): ?>
                <div>
                    <img src="<?php echo $result['foto1'] ?>" alt="Cédula identidad cara 1/Visa cara 1 no encontrada" style="width: 100%; height: auto;">
                    <br>
                    <a href="<?php echo $result['foto1'] ?>" download="nombre_archivo">Cédula identidad cara 1/Visa cara 1</a>
                </div>
            <?php else: ?>
                <p class="not-found">Foto no encontrada</p>
            <?php endif; ?>
            
            <?php if (!empty($result['foto2'])): ?>
                <div>
                    <img src="<?php echo $result['foto2'] ?>" alt="Cédula identidad cara 2/Visa cara 2 no encontrada" style="width: 100%; height: auto;">
                    <br>
                    <a href="<?php echo $result['foto1'] ?>" download="nombre_archivo">Cédula identidad cara 2/Visa cara 2</a>
                </div>
            <?php else: ?>
                <p class="not-found">Foto 2 no encontrada</p>
            <?php endif; ?>
            
        <?php else: ?>
            <p>Trabajador no encontrado</p>
        <?php endif; ?>
    </div>
</body>
</html>