<?php
$isLoggedIn = isset($_SESSION['id_user']); // Verifica si el usuario está autenticado
?>

<footer class="bg-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center ">
                <p class="mb-0">© <?php echo date("Y"); ?> Alojamientos. Todos los derechos reservados.</p>
                <p>
                    <?php if ($isLoggedIn): ?>
                        <a href="#" class="text-decoration-none">Política de Privacidad</a> | 
                        <a href="#" class="text-decoration-none">Términos y Condiciones</a>
                    <?php else: ?>
                        <a href="#" class="text-decoration-none">Política de Privacidad</a>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
