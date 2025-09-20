<?php
require_once('../config.php');
require_once('inc/header.php');
require_once('../classes/registerareas.php');

// Verificar si el docente_id está presente en la URL
if (!isset($_GET['docente_id'])) {
    echo "<script>alert('No se ha especificado un docente.'); window.location.href = 'registerDocente.php';</script>";
    exit();
}

$docente_id = $_GET['docente_id'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Área para el Docente</title>
    <style>
        /* Estilos generales de la página */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
            display: inline-block;
        }

        select,
        button,
        input[type="hidden"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .alert {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Registrar Área para el Docente</h2>
        <form action="registerareas.php" method="post">
            <!-- Campo oculto para el ID del docente -->
            <input type="hidden" name="docente_id" value="<?php echo $docente_id; ?>">

            <!-- Selección del tipo de área -->
            <div class="form-group">
                <label for="area">Área:</label>
                <select name="area" required>
                    <option value="Practicas">Prácticas</option>
                    <option value="Horas Internas">Horas Interas</option>
                    <option value="Vinculacion">Vinculación</option>
                </select>
            </div>
            <!-- Campo para ingresar el nombre del proyecto -->
            <div class="form-group">
                <label for="nombre_proyecto">Nombre del Proyecto:</label>
                <input type="text" name="nombre_proyecto" required>
            </div>


            <!-- Botón para enviar el formulario -->
            <div class="form-group">
                <button type="submit">Guardar Área</button>
            </div>
        </form>
    </div>
</body>

</html>