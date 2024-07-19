<?php
include 'conexion.php';

// Inicializar variables
$mes_seleccionado = "";
$mes1_seleccionado = "";
$mes2_seleccionado = "";
$resultados_mostrados = false;
$resultados_dos_meses_mostrados = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_registro'])) {
        $nombre_supervisor = $_POST['nombre_supervisor'];
        $fecha = $_POST['fecha'];
        $mes = $_POST['mes'];
        $horas_extras = $_POST['horas_extras'];

        $sql = "INSERT INTO registros (nombre_supervisor, fecha, mes, horas_extras)
        VALUES ('$nombre_supervisor', '$fecha', '$mes', '$horas_extras')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro añadido exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error al añadir el registro',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>";
        }
    } elseif (isset($_POST['mes_seleccionado'])) {
        $mes_seleccionado = $_POST['mes_seleccionado'];
        $resultados_mostrados = true;
    } elseif (isset($_POST['submit_dos_meses'])) {
        $mes1_seleccionado = $_POST['mes1_seleccionado'];
        $mes2_seleccionado = $_POST['mes2_seleccionado'];
        $resultados_dos_meses_mostrados = true;
    } elseif (isset($_POST['delete_mes'])) {
        $mes_a_eliminar = $_POST['delete_mes'];
        $sql = "DELETE FROM registros WHERE mes='$mes_a_eliminar'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Mes eliminado exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error al eliminar el mes',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>";
        }
    } elseif (isset($_POST['delete_registro'])) {
        $registro_id = $_POST['delete_registro'];
        $sql = "DELETE FROM registros WHERE id='$registro_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro eliminado exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error al eliminar el registro',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Horas Extras</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a1a;
            color: #f0f0f0;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
        }
        .card {
            background-color: #2a2a2a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px #0f0;
        }
        .card h2 {
            color: #0f0;
            text-shadow: 0 0 5px #0f0;
        }
        .form-control {
            background-color: #333;
            color: #fff;
            border: none;
        }
        .form-control:focus {
            background-color: #444;
            color: #fff;
        }
        .btn-custom {
            background-color: #0f0;
            color: #000;
            border: none;
        }
        .btn-custom:hover {
            background-color: #00e600;
        }
        .toggle-theme {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #0f0;
            color: #000;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .table {
            background-color: #2a2a2a;
        }
        .table th, .table td {
            color: #fff;
        }
        .table thead th {
            background-color: #0f0;
            color: #000;
        }
    </style>
</head>
<body>
    <button class="toggle-theme" onclick="toggleTheme()">&#9788;</button>
    <div class="container">
        <div class="card">
            <h2 class="text-center">Registro de Horas Extras</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                    <label for="nombre_supervisor">Nombre del Supervisor</label>
                    <input type="text" class="form-control" id="nombre_supervisor" name="nombre_supervisor" required>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>
                <div class="form-group">
                    <label for="mes">Mes</label>
                    <input type="text" class="form-control" id="mes" name="mes" required>
                </div>
                <div class="form-group">
                    <label for="horas_extras">Horas Extras</label>
                    <input type="number" class="form-control" id="horas_extras" name="horas_extras" required>
                </div>
                <button type="submit" class="btn btn-custom btn-block" name="submit_registro">Registrar</button>
            </form>
        </div>
        <div class="card mt-5">
            <h2 class="text-center">Consultar Horas Extras por Mes</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                    <label for="mes_seleccionado">Seleccionar Mes</label>
                    <select class="form-control" id="mes_seleccionado" name="mes_seleccionado" required>
                        <option value="" disabled selected>Seleccione un mes</option>
                        <?php
                        include 'conexion.php';
                        $sql = "SELECT DISTINCT mes FROM registros";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['mes'] . "'>" . $row['mes'] . "</option>";
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom btn-block">Consultar</button>
            </form>
        </div>
        <?php if ($resultados_mostrados) { ?>
        <div class="card mt-5">
            <h2 class="text-center">Horas Extras para el Mes de <?php echo $mes_seleccionado; ?></h2>
            <?php
            include 'conexion.php';
            $sql = "SELECT id, nombre_supervisor, fecha, horas_extras FROM registros WHERE mes='$mes_seleccionado'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table table-bordered'><thead class='thead-dark'><tr><th>Supervisor</th><th>Fecha</th><th>Horas</th><th>Acción</th></tr></thead><tbody>";
                $total_horas = 0;
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["nombre_supervisor"]. "</td><td>" . $row["fecha"]. "</td><td>" . $row["horas_extras"]. "</td><td>
                        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' style='display:inline;'>
                            <input type='hidden' name='delete_registro' value='" . $row['id'] . "'>
                            <button type='submit' class='btn btn-danger'>Eliminar</button>
                        </form>
                    </td></tr>";
                    $total_horas += $row["horas_extras"];
                }
                echo "</tbody></table>";
                echo "<p class='text-center'>Total de Horas Extras: " . $total_horas . "</p>";
            } else {
                echo "<p class='text-center'>No hay resultados</p>";
            }

            $conn->close();
            ?>
        </div>
        <?php } ?>
        <div class="card mt-5">
            <h2 class="text-center">Consultar Horas Extras de Dos Meses</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                    <label for="mes1_seleccionado">Seleccionar Primer Mes</label>
                    <select class="form-control" id="mes1_seleccionado" name="mes1_seleccionado" required>
                        <option value="" disabled selected>Seleccione un mes</option>
                        <?php
                        include 'conexion.php';
                        $sql = "SELECT DISTINCT mes FROM registros";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['mes'] . "'>" . $row['mes'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mes2_seleccionado">Seleccionar Segundo Mes</label>
                    <select class="form-control" id="mes2_seleccionado" name="mes2_seleccionado" required>
                        <option value="" disabled selected>Seleccione un mes</option>
                        <?php
                        include 'conexion.php';
                        $sql = "SELECT DISTINCT mes FROM registros";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['mes'] . "'>" . $row['mes'] . "</option>";
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom btn-block" name="submit_dos_meses">Consultar</button>
            </form>
        </div>
        <?php if ($resultados_dos_meses_mostrados) { ?>
        <div class="card mt-5">
            <h2 class="text-center">Horas Extras para los Meses de <?php echo $mes1_seleccionado; ?> y <?php echo $mes2_seleccionado; ?></h2>
            <?php
            include 'conexion.php';
            $sql = "SELECT id, nombre_supervisor, fecha, horas_extras FROM registros WHERE mes='$mes1_seleccionado' OR mes='$mes2_seleccionado'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table table-bordered'><thead class='thead-dark'><tr><th>Supervisor</th><th>Fecha</th><th>Horas</th><th>Acción</th></tr></thead><tbody>";
                $total_horas = 0;
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["nombre_supervisor"]. "</td><td>" . $row["fecha"]. "</td><td>" . $row["horas_extras"]. "</td><td>
                        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' style='display:inline;'>
                            <input type='hidden' name='delete_registro' value='" . $row['id'] . "'>
                            <button type='submit' class='btn btn-danger'>Eliminar</button>
                        </form>
                    </td></tr>";
                    $total_horas += $row["horas_extras"];
                }
                echo "</tbody></table>";
                echo "<p class='text-center'>Total de Horas Extras: " . $total_horas . "</p>";
            } else {
                echo "<p class='text-center'>No hay resultados</p>";
            }

            $conn->close();
            ?>
        </div>
        <?php } ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function toggleTheme() {
            const body = document.body;
            const themeButton = document.querySelector('.toggle-theme');
            if (body.style.backgroundColor === 'white') {
                body.style.backgroundColor = '#1a1a1a';
                body.style.color = '#f0f0f0';
                themeButton.style.backgroundColor = '#0f0';
                themeButton.style.color = '#000';
                document.querySelectorAll('.card').forEach(card => card.style.backgroundColor = '#2a2a2a');
                document.querySelectorAll('.form-control').forEach(input => {
                    input.style.backgroundColor = '#333';
                    input.style.color = '#fff';
                });
                document.querySelectorAll('.table').forEach(table => table.style.backgroundColor = '#2a2a2a');
                document.querySelectorAll('.table th, .table td').forEach(cell => cell.style.color = '#fff');
                document.querySelectorAll('.table thead th').forEach(cell => cell.style.backgroundColor = '#0f0');
                themeButton.innerHTML = '&#9788;';
            } else {
                body.style.backgroundColor = 'white';
                body.style.color = 'black';
                themeButton.style.backgroundColor = '#000';
                themeButton.style.color = '#fff';
                document.querySelectorAll('.card').forEach(card => card.style.backgroundColor = '#fff');
                document.querySelectorAll('.form-control').forEach(input => {
                    input.style.backgroundColor = '#f9f9f9';
                    input.style.color = '#000';
                });
                document.querySelectorAll('.table').forEach(table => table.style.backgroundColor = '#fff');
                document.querySelectorAll('.table th, .table td').forEach(cell => cell.style.color = '#000');
                document.querySelectorAll('.table thead th').forEach(cell => cell.style.backgroundColor = '#f0f0f0');
                themeButton.innerHTML = '&#9790;';
            }
        }
    </script>
</body>
</html>
