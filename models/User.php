<?php
// Incluye la clase Database para manejar la conexión a la base de datos.
include_once '../library/Database.php';

// Define la clase User, que representa el modelo para interactuar con la tabla "users".
class User
{
    // Propiedad para almacenar la conexión PDO.
    private $pdo;

    // Propiedades públicas que representan las columnas de la tabla "users".
    public $id;    // ID del usuario.
    public $name;  // Nombre del usuario.
    public $email; // Correo electrónico del usuario.
    public $phone; // Número de teléfono del usuario.

    // Constructor de la clase. Obtiene la instancia de la base de datos mediante el patrón Singleton.
    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    // Método para leer todos los registros de la tabla "users".
    public function read()
    {
        // Consulta SQL para seleccionar todos los registros de la tabla.
        $query = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($query); // Prepara la consulta para su ejecución.
        $stmt->execute(); // Ejecuta la consulta.
        return $stmt; // Devuelve el objeto de resultados.
    }

    // Método para crear un nuevo registro en la tabla "users".
    public function create()
    {
        // Sanitiza los datos de entrada para evitar inyecciones SQL y otros problemas.
        $this->name = filter_var($this->name, FILTER_SANITIZE_STRING);
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        $this->phone = filter_var($this->phone, FILTER_SANITIZE_NUMBER_INT);

        // Consulta SQL para insertar un nuevo registro en la tabla.
        $query = "INSERT INTO users SET name=:name, email=:email, phone=:phone";
        $stmt = $this->pdo->prepare($query); // Prepara la consulta.

        // Asigna los valores sanitizados a los parámetros de la consulta.
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);

        // Ejecuta la consulta y devuelve true si se realiza con éxito.
        if ($stmt->execute()) {
            return true;
        }
        return false; // Devuelve false si la ejecución falla.
    }

    // Método para actualizar un registro existente en la tabla "users".
    public function update()
    {
        // Sanitiza los datos de entrada.
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $this->name = filter_var($this->name, FILTER_SANITIZE_STRING);
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        $this->phone = filter_var($this->phone, FILTER_SANITIZE_NUMBER_INT);

        // Solo realiza la actualización si el ID es válido.
        if ($this->id > 0) {
            // Consulta SQL para actualizar un registro basado en el ID.
            $query = "UPDATE users SET name=:name, email=:email, phone=:phone WHERE id=:id";
            $stmt = $this->pdo->prepare($query); // Prepara la consulta.

            // Asigna los valores sanitizados a los parámetros de la consulta.
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            // Ejecuta la consulta y devuelve true si se realiza con éxito.
            if ($stmt->execute()) {
                return true;
            }
        }
        return false; // Devuelve false si la ejecución falla o el ID no es válido.
    }

    // Método para eliminar un registro de la tabla "users".
    public function delete()
    {
        // Sanitiza el ID de entrada.
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);

        // Solo realiza la eliminación si el ID es válido.
        if ($this->id > 0) {
            // Consulta SQL para eliminar un registro basado en el ID.
            $query = "DELETE FROM users WHERE id=:id";
            $stmt = $this->pdo->prepare($query); // Prepara la consulta.

            // Asigna el valor sanitizado del ID al parámetro de la consulta.
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            // Ejecuta la consulta y devuelve true si se realiza con éxito.
            if ($stmt->execute()) {
                return true;
            }
        }
        return false; // Devuelve false si la ejecución falla o el ID no es válido.
    }
}