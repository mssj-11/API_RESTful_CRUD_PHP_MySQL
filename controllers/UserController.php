<?php
// Se incluye el archivo que contiene la clase User para acceder a sus métodos y propiedades.
include_once '../models/User.php';

// Se instancia un objeto de la clase User.
$user = new User();

// Se obtiene el método HTTP de la solicitud actual (GET, POST, PUT, DELETE).
$request = $_SERVER["REQUEST_METHOD"];

// Se utiliza una estructura switch para manejar las diferentes operaciones CRUD según el método HTTP.
switch ($request) {
    case 'GET':
        // Se llama al método read() para obtener todos los usuarios.
        $stmt = $user->read();
        $num = $stmt->rowCount(); // Se cuenta cuántos registros devuelve la consulta.

        if ($num > 0) {
            // Si hay registros, se prepara una respuesta con los datos obtenidos.
            $response = array("message" => "ok", "data" => array());
            while ($result = $stmt->fetch()) {
                // Cada registro se agrega al array de datos.
                $response["data"][] = array(
                    "id" => $result->id,
                    "name" => $result->name,
                    "email" => $result->email,
                    "phone" => $result->phone,
                    "created_at" => $result->created_at
                );
            }

            // Se devuelve un código HTTP 200 (OK) con los datos en formato JSON.
            http_response_code(200);
            echo json_encode($response);
        } else {
            // Si no se encuentran usuarios, se responde con un código HTTP 404 (No encontrado).
            http_response_code(404);
            echo json_encode(array("message" => "No users found."));
        }
        break;

    case 'POST':
        // Se lee el cuerpo de la solicitud y se decodifica el JSON recibido.
        $data = json_decode(file_get_contents("php://input"));

        // Se verifica que los datos requeridos (name y email) no estén vacíos.
        if (!empty($data->name) && !empty($data->email)) {
            // Se asignan los datos recibidos a las propiedades del objeto User.
            $user->name = $data->name;
            $user->email = $data->email;
            $user->phone = $data->phone;

            // Se intenta crear un nuevo usuario en la base de datos.
            if ($user->create()) {
                // Si se crea exitosamente, se devuelve un código HTTP 201 (Creado).
                http_response_code(201);
                echo json_encode(array("message" => "User was created."));
            } else {
                // Si ocurre un error, se devuelve un código HTTP 503 (Servicio no disponible).
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create user."));
            }
        } else {
            // Si los datos son incompletos, se devuelve un código HTTP 400 (Solicitud incorrecta).
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create user. Data incomplete."));
        }
        break;

    case 'PUT':
        // Se lee y decodifica el JSON del cuerpo de la solicitud.
        $data = json_decode(file_get_contents("php://input"));

        // Se verifica que los datos requeridos (id, name, email) no estén vacíos.
        if (!empty($data->id) && !empty($data->name) && !empty($data->email)) {
            // Se asignan los datos al objeto User.
            $user->id = $data->id;
            $user->name = $data->name;
            $user->email = $data->email;
            $user->phone = $data->phone;

            // Se intenta actualizar el usuario en la base de datos.
            if($user->update()) {
                // Si se actualiza correctamente, se devuelve un código HTTP 200 (OK).
                http_response_code(200);
                echo json_encode(array("message" => "User was updated."));
            } else {
                // Si ocurre un error, se devuelve un código HTTP 503 (Servicio no disponible).
                http_response_code(503);
                echo json_encode(array("message" => "Unable to update user."));
            }
        } else {
            // Si los datos son incompletos, se devuelve un código HTTP 400 (Solicitud incorrecta).
            http_response_code(400);
            echo json_encode(array("message" => "Unable to update user. Data is incomplete."));
        }
        break;

    case 'DELETE':
        // Se lee y decodifica el JSON del cuerpo de la solicitud.
        $data = json_decode(file_get_contents("php://input"));
        $user->id = $data->id; // Se asigna el ID recibido al objeto User.

        // Se intenta eliminar el usuario en la base de datos.
        if ($user->delete()) {
            // Si se elimina correctamente, se devuelve un código HTTP 200 (OK).
            http_response_code(200);
            echo json_encode(array("message" => "User was deleted."));
        } else {
            // Si ocurre un error, se devuelve un código HTTP 503 (Servicio no disponible).
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete user."));
        }
        break;

    default:
        // Si se recibe un método HTTP no permitido, se devuelve un código HTTP 405 (Método no permitido).
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        break;
}