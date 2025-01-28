<?php
require_once __DIR__ . '/env.php';

class Connection {

    // método para conectarnos a la bd
    public static function connect() {
        try {
            // Cargar variables de entorno si no se han cargado
            loadEnv(__DIR__ . '/../.env');

            $host = getenv('DB_HOST');
            $db_name = getenv('DB_NAME');
            $user_name = getenv('DB_USER');
            $password = getenv('DB_PASS');
            $port = getenv('DB_PORT');

            if (!$host || !$db_name || !$user_name) {
                throw new Exception('Faltan variables de entorno necesarias.');
            }

            // Crear una conexión PDO
            $conn = new PDO(
                "mysql:host=$host;port=$port;dbname=$db_name",
                $user_name,
                $password
            );

            // Configurar el modo de errores de PDO
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
            
        } catch (PDOException $e) {
            echo "Error al conectarse a la base de datos: " . $e->getMessage();
            exit();
        }catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    }
}
