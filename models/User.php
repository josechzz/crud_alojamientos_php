<?php

require_once '../config/Connection.php';

class User {
    private $connection;

    public function __construct() {
        $this->connection = Connection::connect();
    }

    // método para obtener todos los usuarios
    public function all(){

        try {
            $query = $this->connection->query("SELECT id, name, email, role FROM users");
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                echo "No se encontraron usuarios.";
            }
            return $result;
        } catch (Exception $e) {
            die("Error al obtener usuarios: " . $e->getMessage());
        }
    }
    

    public function register($data) {
        try {
            // Verificar si el correo ya está registrado
            $checkQuery = "SELECT * FROM users WHERE email = :email";
            $checkStmt = $this->connection->prepare($checkQuery);
            $checkStmt->bindParam(':email', $data['email']);
            $checkStmt->execute();
    
            if ($checkStmt->rowCount() > 0) {
                // Si el correo ya existe, devolvemos un mensaje
                die("El correo ya está registrado. Por favor, utiliza otro correo.");
            }
    
            // Insertar nuevo usuario si el correo no está registrado
            $query = "INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password, :role)";
            $stmt = $this->connection->prepare($query);
    
            // Enlace de parámetros
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', password_hash($data['password'], PASSWORD_BCRYPT)); // Hash seguro
            $stmt->bindParam(':role', $data['role']);
    
            // Ejecutar la consulta y retornar el resultado
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error al registrar usuario: " . $e->getMessage());
        }
    }

    public function login($email, $password) {
        try {
            // Obtenemos los datos del usuario si el correo existe en la base de datos
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificamos las credenciales para iniciar sesión
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['id_user'] = $user['id'];
                $_SESSION['user'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                return true;
            }
            return false;
        } catch (PDOException $e) {
            die("Error al iniciar sesión " . $e->getMessage());
        }
    }
    
    
}
