<?php
require_once '../config/Connection.php';

class Accommodation
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    // Consultas a la tabla accommodations

    // Obtener todos los alojamientos
    public function getAll()
    {
        try {
            $query = "SELECT * FROM accommodations";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los alojamientos: " . $e->getMessage();
        }
    }

    // Obtener alojamiento por id
    public function getById($id)
    {
        try {
            $query = "SELECT * FROM accommodations WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener el alojamiento: " . $e->getMessage();
        }
    }

    // Agregar nuevo alojamiento
    public function create($data)
    {
        try {
            if ($data['role'] == 'admin') {
                $query = "INSERT INTO accommodations (name, location, description, price, image_url) VALUES (:name, :location, :description, :price, :image_url)";
                $stmt = $this->connection->prepare($query);
                $stmt->bindParam(':name', $data['name']);
                $stmt->bindParam(':location', $data['location']);
                $stmt->bindParam(':description', $data['description']);
                $stmt->bindParam(':price', $data['price']);
                $stmt->bindParam(':image_url', $data['image_url']);
                return $stmt->execute();
            } else {
                echo "No tienes permisos para agregar alojamientos ";
            }
        } catch (PDOException $e) {
            echo "Error al Guardar un nuevo alojamiento: " . $e->getMessage();
        }
    }

    // Consultas a la tabla user_accommodations

    // Obtener alojamientos por usuario logueado
    public function getByUser($userId, $role)
    {
        try {
            if ($role == 'user') {
                $query = $this->connection->prepare("
                SELECT a.* 
                FROM accommodations a
                INNER JOIN user_accommodations ua ON a.id = ua.id_accommodation
                WHERE ua.id_user = :user_id
                ");
                $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $query->execute();

                return $query->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo "No tienes permisos para ver los alojamientos ";
            }
        } catch (PDOException $e) {
            echo "Error al obtener alojamientos: " . $e->getMessage();
            return [];
        }
    }

    // Verificar si el alojamiento ya existe en la cuenta del usuario
    public function isAccommodationAdded($userId, $accommodationId)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM user_accommodations 
        WHERE id_user = :userId AND id_accommodation = :accommodationId";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':accommodationId', $accommodationId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0; // Retorna true si el alojamiento ya está añadido
        } catch (PDOException $e) {
            echo "Error al verificar alojamiento en su cuenta de usuario: " . $e->getMessage();
            return false;
        }
    }

    // Agregar un alojamiento al usuario
    public function addAccommodationToUser($data)
    {
        try {
            if ($data['role'] == 'user') {
                $query = $this->connection->prepare("
                INSERT INTO user_accommodations (id_user, id_accommodation) 
                VALUES (:user_id, :accommodation_id)
                ");
                $query->bindParam(':user_id', $data['userId'], PDO::PARAM_INT);
                $query->bindParam(':accommodation_id', $data['accommodationId'], PDO::PARAM_INT);
                return $query->execute();
            } else {
                echo "No tienes permisos para añadir alojamiento ";
            }
        } catch (PDOException $e) {
            echo "Error al agregar alojamiento a su cuenta de usuario: " . $e->getMessage();
            return false;
        }
    }

    // Eliminar un alojamiento del usuario
    public function removeAccommodationFromUser($data)
    {
        try {
            if ($data['role'] == 'user') {
                $query = $this->connection->prepare("
                DELETE FROM user_accommodations 
                WHERE id_user = :user_id AND id_accommodation = :accommodation_id
                ");
                $query->bindParam(':user_id', $data['userId'], PDO::PARAM_INT);
                $query->bindParam(':accommodation_id', $data['accommodationId'], PDO::PARAM_INT);
                return $query->execute();
            } else {
                echo "No tienes permisos para remover alojamiento ";
            }
        } catch (PDOException $e) {
            echo "Error al eliminar alojamiento de su cuenta de usuario: " . $e->getMessage();
            return false;
        }
    }
}
