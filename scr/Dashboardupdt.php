<?php
// Incluir el archivo de conexión
include('db_connect.php');

// Verificar si el usuario está autenticado (por ejemplo, si se ha guardado su sesión)
session_start();

// Asegurarse de que el usuario ha iniciado sesión y tiene el tipo de usuario 'actualizar'
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirige si no está logueado
    exit();
}

// Consultar los datos del usuario logueado
$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id = :id');
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

// Verificar que el usuario es del tipo 'actualizar'
if ($user['tipo_usuario'] !== 'actualizar') {
    echo "Acceso no autorizado.";
    exit();
}

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Spa Serenidad, un espacio para relajarte y cuidar de tu bienestar.">
    <meta name="author" content="Spa Serenidad">
    <title>Dashboard Actualizar - Spa Serenidad</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      body {
        background-color: #ffe5ec;
        color: black;
      }

      .gradient-custom-2 {
        background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
      }

      .card {
        border-radius: 1rem;
        border: none;
      }

      .btn-primary {
        background-color: #fb6f92;
        border-color: #fb6f92;
      }

      .btn-primary:hover {
        background-color: #ffb3c5;
        border-color: #ffb3c5;
      }
    </style>
  </head>
  <body>

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Spa Serenidad</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="Dashboardupdt.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container py-5">
      <div class="row">
        <div class="col-md-12">
          <div class="card rounded-3 text-black">
            <div class="card-body p-md-5 mx-md-4">
              <h4 class="text-center">Bienvenido al Panel de Actualización, <?php echo htmlspecialchars($user['name']); ?>!</h4>
              <p class="lead">Aquí podrás actualizar los contenidos de la plataforma.</p>

              <div class="mt-4">
                <h5>Formulario de Actualización de Contenido</h5>
                <form action="update_content.php" method="POST">
                  <div class="mb-3">
                    <label for="siteTitle" class="form-label">Nuevo Título del Sitio</label>
                    <input type="text" class="form-control" id="siteTitle" name="siteTitle" placeholder="Nuevo título del sitio" required />
                  </div>
                  <div class="mb-3">
                    <label for="siteDescription" class="form-label">Nueva Descripción del Sitio</label>
                    <textarea class="form-control" id="siteDescription" name="siteDescription" rows="3" placeholder="Nueva descripción del sitio" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Actualizar Contenido</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- FOOTER -->
    <footer class="container">
      <p class="float-end"><a href="#">Volver arriba</a></p>
      <p>&copy; 2023 Spa Serenidad. &middot; <a href="#">Política de Privacidad</a> &middot; <a href="#">Términos</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
