<?php
require_once '../models/Accommodation.php';
session_start();

class AccommodationController
{
    public static function handleRequest()
    {
        $action = $_REQUEST['action'] ?? 'index';

        if (isset($_SESSION['id_user']) && isset($_SESSION['role'])) {
            $userId = $_SESSION['id_user'];
            $role = $_SESSION['role'];
        }

        $accommodationModel = new Accommodation();

        switch ($action) {
            case 'index':
                self::listAllAccommodations($accommodationModel);
                break;

            case 'list':
                self::listAccommodationsUser($accommodationModel, $userId, $role);
                break;

            case 'add':
                self::addAccommodationToUser($accommodationModel, $userId, $role);
                break;

            case 'remove':
                self::removeAccommodationFromUser($accommodationModel, $userId, $role);
                break;

            case 'create':
                self::createAccommodation($accommodationModel, $role);
                break;

            default:
                header("Location: ../controllers/AccommodationController.php?action=index");
                exit();
        }
    }

    private static function listAllAccommodations($accommodationModel)
    {
        // Obtener todos los alojamientos
        $accommodations = $accommodationModel->getAll();

        // Incluir la vista para pasar datos
        include '../views/accommodations/index.php';
        exit();
    }

    private static function listAccommodationsUser($accommodationModel, $userId, $role)
    {
        if ($role == 'user') {
            $accommodations = $accommodationModel->getByUser($userId, $role);
            include "../views/users/user_dashboard.php";
        } else {
            echo "No tienes permisos para ver alojamientos.";
        }
    }

    private static function addAccommodationToUser($accommodationModel, $userId, $role)
    {
        $accommodationId = $_POST['accommodation_id'] ?? null;

        if (!$accommodationId) {
            $_SESSION['message'] = [
                'title' => 'ID de alojamiento no proporcionado.',
                'icon' => 'error'
            ];
            header("Location: ../controllers/AccommodationController.php?action=index");
            exit();
        }

        // Verificamos si el alojamiento ya está en la cuenta
        if ($accommodationModel->isAccommodationAdded($userId, $accommodationId)) {
            $_SESSION['message'] = [
                'title' => '¡Este alojamiento ya está añadido a tu cuenta.!',
                'icon' => 'warning'
            ];
            header("Location: ../controllers/AccommodationController.php?action=index");
            exit();
        }

        // Si no está entonces lo agregamos
        $data = [
            'userId' => $userId,
            'accommodationId' => $accommodationId,
            'role' => $role,
        ];

        if ($accommodationModel->addAccommodationToUser($data)) {
            $_SESSION['message'] = [
                'title' => '¡Alojamiento agregado exitosamente!',
                'icon' => 'success'
            ];
            header("Location: ../controllers/AccommodationController.php?action=index");
            exit();
        } else {
            $_SESSION['message'] = [
                'title' => '¡Error al agregar alojamiento!',
                'icon' => 'error'
            ];
            header("Location: ../controllers/AccommodationController.php?action=index");
            exit();
        }
    }

    private static function removeAccommodationFromUser($accommodationModel, $userId, $role)
    {
        $accommodationId = $_POST['accommodation_id'] ?? null;

        if (!$accommodationId) {
            $_SESSION['message'] = [
                'title' => 'ID de alojamiento no proporcionado.',
                'icon' => 'error'
            ];
            header("Location: ../controllers/AccommodationController.php?action=list");
            exit();
        }

        $data = [
            'userId' => $userId,
            'accommodationId' => $accommodationId,
            'role' => $role,
        ];

        if ($accommodationModel->removeAccommodationFromUser($data)) {
            $_SESSION['message'] = [
                'title' => 'Alojamiento eliminado exitosamente!',
                'icon' => 'success'
            ];

            header("Location: ../controllers/AccommodationController.php?action=list");
            exit();
        } else {
            $_SESSION['message'] = [
                'title' => 'Error al eliminar alojamiento!',
                'icon' => 'error'
            ];

            header("Location: ../controllers/AccommodationController.php?action=list");
            exit();
        }
    }

    private static function createAccommodation($accommodationModel, $role)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($role != 'admin') {
                echo "No tienes permisos para agregar alojamientos.";
                return;
            }

            $data = [
                'name' => $_POST['name'] ?? '',
                'location' => $_POST['location'] ?? '',
                'description' => $_POST['description'] ?? '',
                'price' => $_POST['price'] ?? '',
                'image_url' => !empty($_POST['image_url']) ? $_POST['image_url'] : 'https://res.cloudinary.com/dpo0d4fre/image/upload/v1736783357/casa_luna_ys6dnk.jpg',
                'role' => $role,
            ];

            if (empty($data['name']) || empty($data['location']) || empty($data['description']) || empty($data['price']) || empty($data['image_url'])) {
                $_SESSION['message'] = [
                    'title' => 'Por favor complete los campos requeridos',
                    'icon' => 'error'
                ];

                header("Location: ../views/accommodations/add_accommodation.php");
                exit();
            }

            if ($accommodationModel->create($data)) {
                $_SESSION['message'] = [
                    'title' => 'Nuevo alojamiento guardado!',
                    'icon' => 'success'
                ];

                header("Location: ../controllers/AccommodationController.php?action=index");
                exit();
            } else {
                $_SESSION['message'] = [
                    'title' => 'Error al guardar alojamiento!',
                    'icon' => 'error'
                ];

                header("Location: ../views/accommodations/add_accommodation.php");
                exit();
            }
        }
    }
}

// Manejar la solicitud
AccommodationController::handleRequest();
