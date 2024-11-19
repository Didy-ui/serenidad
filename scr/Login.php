<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Spa Serenidad, un espacio para relajarte y cuidar de tu bienestar.">
  <meta name="author" content="Spa Serenidad">
  <title>Login - Spa Serenidad</title>

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

    footer {
      background-color: #ffb3c5;
      padding: 1rem 0;
    }

    footer p, footer a {
      color: #0026ff !important;
    }

    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <!-- HEADER -->

  <?php
// Iniciar sesión
session_start();

// Incluir la conexión a la base de datos
include('Conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Verificar el usuario en la base de datos
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE nombre_usuario = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Guardar el usuario en la sesión
        $_SESSION['user'] = $user['nombre_usuario'];

        // Redireccionar según el tipo de usuario
        if ($user['tipo_usuario'] === 'admin') {
            header('Location: Dashboardadmin.php');
        } elseif ($user['tipo_usuario'] === 'actualizar') {
            header('Location: Dashboardupdt.php');
        } else {
            echo 'Tipo de usuario no autorizado.';
        }
        exit();
    } else {
        echo 'Credenciales incorrectas';
    }
}
?>

  <!-- LOGIN FORM -->
  <section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">

                  <div class="text-center">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp" style="width: 185px;" alt="logo">
                    <h4 class="mt-1 mb-5 pb-1">Equipo Spa Serenidad</h4>
                  </div>

                  <form method="POST">
                    <p>Por favor ingresa a tu cuenta</p>

                    <div class="form-outline mb-4">
                      <input type="text" id="form2Example11" class="form-control" name="username" placeholder="Nombre de usuario" required />
                      <label class="form-label" for="form2Example11">Usuario</label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" id="form2Example22" class="form-control" name="password" required />
                      <label class="form-label" for="form2Example22">Contraseña</label>
                    </div>

                    <div class="text-center pt-1 mb-5 pb-1">
                      <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Log in</button>
                      <a class="text-muted" href="#!">Olvidaste tu contraseña?</a>
                    </div>

                    <div class="d-flex align-items-center justify-content-center pb-4">
                      <p class="mb-0 me-2">No tienes cuenta?</p>
                      <button type="button" class="btn btn-outline-danger">Crear cuenta</button>
                    </div>

                  </form>

                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                  <h4 class="mb-4">Somos más que una empresa</h4>
                  <p class="small mb-0"> Nos dedicamos a ofrecer una atención integral que combine técnicas avanzadas y naturales para promover la relajación, la salud y la belleza.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="container">
    <p class="float-end"><a href="#">Volver arriba</a></p>
    <p>&copy; 2023 Spa Serenidad. &middot; <a href="#">Política de Privacidad</a> &middot; <a href="#">Términos</a></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>



