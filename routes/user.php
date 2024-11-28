<?php

// Permite el acceso desde cualquier origen (Cross-Origin Resource Sharing - CORS).
// Esto permite que cualquier dominio pueda hacer solicitudes a esta API.
header("Access-Control-Allow-Origin: *");

// Especifica que el contenido de la respuesta será en formato JSON y en codificación UTF-8.
// Esto asegura que el cliente (por ejemplo, un navegador o una aplicación) pueda interpretar correctamente los datos.
header("Content-Type: application/json; charset=UTF-8");

// Permite los métodos HTTP especificados para acceder a este recurso: GET, POST, PUT y DELETE.
// Esto es importante para las APIs RESTful, que suelen utilizar estos métodos para manejar los recursos.
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Especifica cuánto tiempo (en segundos) los navegadores deben almacenar en caché las respuestas a las solicitudes de CORS.
// En este caso, las respuestas pueden ser almacenadas durante 3600 segundos (1 hora).
header("Access-Control-Max-Age: 3600");

// Incluye el archivo que maneja la lógica del controlador para los usuarios, permitiendo la ejecución de operaciones CRUD.
include_once '../controllers/UserController.php';