<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="estilo1.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: url('https://www.scappino.com/media/magestore/storepickup/images/tag/l/i/liver_test.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
        }

        #pide-online {
            background-color: rgba(150, 138, 159, 0.8);
            padding: 50px 20px;
        }

        #pide-online form {
            margin-bottom: 200px;
        }

        /* Añadí estos estilos para que coincidan con los estilos previos */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ffffff;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <header>
        <!-- Encabezado omitido para evitar duplicación de código -->
    </header>

    <section>
        <!-- Contenido del héroe omitido para evitar duplicación de código -->
    </section>

    <section id="pide-online">
        <div>
            <form action='' method='post'>
                <p>
                    Nombre o ID del producto:
                    <input type='text' name='busquedacodigo' pattern='[A-Za-z0-9\s]{4,20}' title='Un código válido consiste en una cadena con 4 a 20 caracteres, cada uno de los cuales es una letra o un dígito'>
                    <input type='submit' value='Buscar'>
                </p>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Imagen</th>
                            <th>Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Ruta del archivo CSV
                        $csvFile = 'productos_liverpool.csv';

                        // Inicializar la variable $codigo_producto
                        $codigo_producto = "";

                        // Verificar si se ha enviado un formulario
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Obtener el valor del input
                            $codigo_producto = $_POST["busquedacodigo"];
                        }

                        // Abre el archivo CSV en modo lectura
                        $file = fopen($csvFile, 'r');

                        // Verifica si se pudo abrir el archivo
                        if ($file !== false) {
                            // Inicializar variables para la suma
                            $sumaCasillas = 0;
                            $sumaPrecios = 0;

                            // Lee cada línea del archivo CSV
                            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                                // Verifica si coincide el código de producto
                                if ($codigo_producto == $data[0] || strpos($data[1], $codigo_producto) !== false) {
                                    echo "<tr>
                                            <td>{$data[0]}</td>
                                            <td>{$data[1]}</td>
                                            <td>{$data[2]}</td>
                                            <td><img src='Imagenes/{$data[0]}.jpeg' alt='Imagen del producto' height='200px'></td>
                                            <td><input type='checkbox' name='casilla_{$data[0]}'></td>
                                        </tr>";

                                    // Recorrer las casillas marcadas y sumar precios
                                    if (isset($_POST['casilla_' . $data[0]]) && $_POST['casilla_' . $data[0]] == 'on') {
                                        $sumaCasillas++;
                                        $sumaPrecios += floatval($data[2]); // Sumar el precio (convierte a número flotante)
                                    }
                                }
                            }

                            // Cierra el archivo CSV
                            fclose($file);
                        } else {
                            echo "Error al abrir el archivo CSV.";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Botón de calcular dentro del formulario principal -->
                <input type='hidden' name='sumaCasillas' value='<?php echo $sumaCasillas; ?>'>
                <input type='hidden' name='sumaPrecios' value='<?php echo $sumaPrecios; ?>'>
                <button type='submit'>Calcular</button>
            </form>

            <?php
            // Verificar si se ha enviado el formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Mostrar resultados
                echo "<p>Articulos en Carrito: $sumaCasillas</p>";
                echo "<p>Total: $sumaPrecios</p>";
            }
            ?>
        </div>
    </section>
</body>

</html>

