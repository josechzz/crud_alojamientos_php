<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- css Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- iconos Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- script sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
            <a href="../../controllers/AccommodationController.php?action=index"><i class="bi bi-arrow-left"></i></a>
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <!-- Mensaje de credenciales incorrectas -->
            <?php
            session_start();
            if (isset($_SESSION['message'])) {
                $message = $_SESSION['message'];
                echo "<script>
                    Swal.fire({
                        title: '{$message['title']}',
                        text: '{$message['text']}',
                        icon: '{$message['icon']}',
                        confirmButtonText: 'Ok'
                    });
                  </script>";
                unset($_SESSION['message']); // Limpia la sesión
            }
            ?>

            <form action="../../controllers/AuthController.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Correo" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>

                <button type="submit" name="action" value="login" class="btn btn-primary w-100">
                    Iniciar Sesión
                </button>
            </form>

            <div class="text-center mt-3">
                <p class="mb-0">¿No tienes cuenta?
                    <a href="register.php" class="text-decoration-none">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>