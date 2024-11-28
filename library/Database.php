<?php
// Incluye el archivo de configuración de Conexión a la DB
include_once '../config.php';

class Database
{
    // Propiedad estática que almacena la instancia única de la clase (patrón Singleton).
    private static $instance = null;

    // Propiedad que almacena la conexión PDO.
    private $pdo;

    // Constructor de la clase. Aquí se inicializa la conexión con la base de datos.
    public function __construct()
    {
        // Define el Data Source Name (DSN) para PDO con los valores de configuración.
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE;

        // Opciones para configurar la conexión PDO.
        $options = array(
            // Establece el juego de caracteres a UTF-8 para la conexión.
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
            // Define el modo de obtención de resultados como objetos.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            // Habilita el manejo de errores mediante excepciones.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            // Crea una nueva conexión PDO con el DSN, usuario, contraseña y opciones.
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
        } catch (PDOException $exception) {
            // Captura cualquier error al intentar conectarse y lanza una excepción con el mensaje del error.
            throw new Exception($exception->getMessage());
        }
    }

    // Método estático que implementa el patrón Singleton.
    public static function getInstance() {
        // Si no hay una instancia creada, crea una nueva.
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        // Devuelve la conexión PDO de la instancia única.
        return self::$instance->pdo;
    }
}