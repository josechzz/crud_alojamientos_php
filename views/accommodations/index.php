<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alojamientos</title>
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
        <h1 class="text-center mb-5">Lista de Alojamientos</h1>
        <div class="row">
            <?php if ($userRole == "admin"): ?>
                <div class="col-md-4 mb-4">
                    <a class="btn btn-primary" href="../views/accommodations/add_accommodation.php" role="button"><i class="bi bi-plus-circle pe-1"></i>Nuevo Alojamiento</a>
                </div>
            <?php endif; ?>
        </div>
        <!-- Mensaje que se mostrará al agregar un alojamiento a la cuenta de usuario -->
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
                <?php foreach ($accommodations as $accommodation): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($accommodation['image_url']) ?>" class="card-img-top" width="auto" height="250px" alt="<?= htmlspecialchars($accommodation['name']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($accommodation['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($accommodation['description']) ?></p>
                                <p class="text-muted">Ubicación: <?= htmlspecialchars($accommodation['location']) ?></p>
                                <p class="text-success">Precio: $<?= htmlspecialchars($accommodation['price']) ?> por noche</p>
                            </div>
                            <?php if ($userRole === "user"): ?>
                                <div class="card-footer">
                                    <!-- Formulario para agregar alojamiento a la cuenta de -->
                                    <form action="../controllers/AccommodationController.php?action=add" method="POST">
                                        <input type="hidden" name="accommodation_id" value="<?php echo $accommodation['id']; ?>">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-heart-fill pe-1"></i>Agregar a mi cuenta</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-muted">
                            <i class="bi bi-exclamation-circle text-danger"></i> ¡No hay alojamientos disponibles.!
                        </h5>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php //include '../views/layouts/footer.php'; 
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>