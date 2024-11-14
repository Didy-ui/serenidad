<?php
// procesar_login.php

// Simulación de autenticación con usuarios y contraseñas actualizadas
$usuarios = [
    'admin_user' => 'admin123', // Contraseña del usuario administrador
    'update_user' => 'update123' // Contraseña del usuario de actualización
];

// Capturamos los datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Verificamos si el usuario ingresado existe en el arreglo y si la contraseña coincide
if (isset($usuarios[$username]) && $usuarios[$username] === $password) {
    if ($username === 'admin_user') {
        // Mostrar el contenido del dashboard de administración directamente si el usuario es admin_user
        ?>
        <!doctype html>
        <html lang="es">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Dashboard de Administración - Spa Serenidad</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <style>
                body {
                    background-color: #f7f9fc;
                }
                .sidebar {
                    height: 100vh;
                    background-color: #343a40;
                    color: white;
                }
                .sidebar .nav-link {
                    color: #adb5bd;
                }
                .sidebar .nav-link:hover {
                    color: white;
                }
            </style>
        </head>
        <body>

        <?php
        // Conexión a la base de datos en XAMPP
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "spa_serenidad";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Obtener datos para el resumen de compras por tratamiento
        $compras = [];
        $tratamientos = [];
        $query_compras = "SELECT tratamientos.nombre, COUNT(servicios.id_tratamiento) as compras 
                        FROM tratamientos 
                        LEFT JOIN servicios ON tratamientos.id_tratamiento = servicios.id_tratamiento 
                        GROUP BY tratamientos.nombre";
        $result_compras = $conn->query($query_compras);
        if ($result_compras->num_rows > 0) {
            while($row = $result_compras->fetch_assoc()) {
                $tratamientos[] = $row['nombre'];
                $compras[] = $row['compras'];
            }
        }

        // Obtener datos para la gestión de usuarios
        $usuarios = [];
        $query_usuarios = "SELECT id, nombre, tipo_usuario FROM usuarios";
        $result_usuarios = $conn->query($query_usuarios);
        if ($result_usuarios->num_rows > 0) {
            while($row = $result_usuarios->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
        ?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-2 d-none d-md-block bg-dark sidebar">
                    <div class="position-sticky">
                        <h4 class="text-center py-4">Admin Panel</h4>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#overview">Resumen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#user-management">Gestión de Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#content-management">Gestión de Contenidos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#image-upload">Subida de Imágenes</a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Panel de Administración</h1>
                    </div>

                    <!-- Section: Overview -->
                    <div id="overview" class="my-5">
                        <h3>Resumen de Compras por Tratamiento</h3>
                        <canvas id="purchaseChart" width="400" height="200"></canvas>
                    </div>

                    <!-- Section: User Management -->
                    <div id="user-management" class="my-5">
                        <h3>Gestión de Usuarios</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo de Usuario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($usuarios as $user): ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= $user['nombre'] ?></td>
                                        <td><?= $user['tipo_usuario'] ?></td>
                                        <td><button class="btn btn-danger btn-sm">Eliminar</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Section: Content Management -->
                    <div id="content-management" class="my-5">
                        <h3>Gestión de Contenidos</h3>
                        <form>
                            <div class="mb-3">
                                <label for="siteTitle" class="form-label">Título del Sitio</label>
                                <input type="text" class="form-control" id="siteTitle" placeholder="Nuevo título del sitio">
                            </div>
                            <div class="mb-3">
                                <label for="siteDescription" class="form-label">Descripción del Sitio</label>
                                <textarea class="form-control" id="siteDescription" rows="3" placeholder="Nueva descripción del sitio"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>

                    <!-- Section: Image Upload -->
                    <div id="image-upload" class="my-5">
                        <h3>Subida de Imágenes</h3>
                        <form>
                            <div class="mb-3">
                                <label for="fileUpload" class="form-label">Sube una imagen</label>
                                <input class="form-control" type="file" id="fileUpload">
                            </div>
                            <button type="submit" class="btn btn-success">Subir Imagen</button>
                        </form>
                    </div>
                </main>
            </div>
        </div>

        <script>
            // Chart.js para mostrar el resumen de compras por tratamiento
            const ctx = document.getElementById('purchaseChart').getContext('2d');
            const purchaseChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($tratamientos) ?>,
                    datasets: [{
                        label: 'Número de Compras',
                        data: <?= json_encode($compras) ?>,
                        backgroundColor: ['#ff8fab', '#fb6f92', '#ffe5ec', '#ffb4a2', '#ffafcc'],
                        borderColor: ['#e63946', '#d62828', '#f4a261', '#ffb4a2', '#ffafcc'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

        <?php $conn->close(); ?>
        </body>
        </html>
        <?php
    } elseif ($username === 'update_user') {
        header("Location: Dashboardupdt.php");
        exit;
    }
} else {
    // Si las credenciales no son correctas, redirigimos al usuario al modal de login con un mensaje de error
    header("Location: index.php?login_error=1");
    exit;
}
?>
