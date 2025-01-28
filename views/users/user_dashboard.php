<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta de Usuario</title>
    <!-- css Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- iconos Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- script sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include '../views/layouts/header.php'; ?>
    <div class="container mt-5 py-5">
        <h1 class="text-center mb-5">Bienvenido/a <?php echo htmlspecialchars($userName); ?></h1>
        <!-- Mensaje que se mostrará al eliminar un alojamiento de la cuenta -->
        <?php
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            echo "<script>
                    Swal.fire({
                        position: 'top-end',
                        title: '{$message['title']}',
                        icon: '{$message['icon']}',
                        showConfirmButton: false,
                        timer: 2000
                    });
                  </script>";
            unset($_SESSION['message']); // Limpia la sesión
        }
        ?>
        <div class="row">
            <?php if (!empty($accommodations)): ?>
                <h2 class="mb-5">Mis Alojamientos Favoritos</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="align-middle">Imagen</th>
                                <th class="align-middle">Nombre</th>
                                <th class="align-middle">Ubicación</th>
                                <!-- En dispositivos pequeños ocultamos la descripción -->
                                <th class="align-middle d-none d-md-table-cell">Descripción</th>
                                <th class="align-middle">Precio</th>
                                <th class="align-middle">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($accommodations as $accommodation): ?>
                                <tr>
                                    <td class="align-middle"><img src="<?php echo htmlspecialchars($accommodation['image_url']); ?>" width="100px" height="auto" alt="<?= htmlspecialchars($accommodation['name']) ?>"></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($accommodation['name']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($accommodation['location']); ?></td>
                                    <td class="align-middle d-none d-md-table-cell"><?php echo htmlspecialchars($accommodation['description']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($accommodation['price']); ?></td>
                                    <td>
                                        <form action="../controllers/AccommodationController.php?action=remove" method="POST" id="remove-form-<?php echo $accommodation['id']; ?>">
                                            <input type="hidden" name="accommodation_id" value="<?php echo $accommodation['id']; ?>">
                                            <button type="button" class="btn btn-danger" onclick="confirmRemove(<?php echo $accommodation['id']; ?>)"><i class="bi bi-trash3-fill pe-1"></i>Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-muted">
                            <i class="bi bi-exclamation-circle text-danger"></i> No hay alojamientos favoritos.
                        </h5>
                        <p class="card-text">Explora alojamientos y agrega tus favoritos aquí.</p>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </div>
    <?php //include '../views/layouts/footer.php'; 
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmRemove(accommodationId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará el alojamiento de tu cuenta.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envía el formulario correspondiente
                    document.getElementById(`remove-form-${accommodationId}`).submit();
                }
            });
        }
    </script>

</body>

</html>