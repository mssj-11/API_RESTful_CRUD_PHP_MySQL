# API RESTful con CRUD en PHP y MySQL usando PDO


**API Restful** con operaciones CRUD (Crear, Leer, Actualizar y Eliminar) utilizando PHP con PDO (PHP Data Objects) y MySQL.


# CRUD

CRUD es un acrónimo que se refiere a las cuatro operaciones básicas que se pueden realizar en una base de datos:

| **Operación** | **SQL**   | **Método HTTP** |
|---------------|-----------|-----------------|
| **Create:** Agregar nuevos registros a la base de datos. | INSERT   | POST            |
| **Read:** Leer registros de la base de datos.           | SELECT   | GET             |
| **Update:** Modificar registros existentes en la base de datos. | UPDATE   | PUT             |
| **Delete:** Borrar registros de la base de datos.       | DELETE   | DELETE          |


#   Estructura del proyecto
```
├── API_RESTful_CRUD_PHP_MySQL
│   ├── controllers
│   │   └── UserController.php
│   ├── library
│   │   └── Database.php
│   ├── models
│   │   └── User.php
│   ├── routes
│   │   └── user.php
│   └── config.php
```

#   Archivos

## `config.php`:
Creamos el archivo `config.php`, donde colocaremos los datos de conexión a nuestra base de datos.


##  `Database.php`:
Creamos el archivo `library/Database.php` con una clase PHP responsable de hacer la conexión con la base de datos. En la clase usamos el patrón de diseño **Singleton** para devolver una instancia de la conexión y evitar que se generen múltiples conexiones
#### Explicación General

- **Patrón Singleton**:
  - Este código usa el patrón Singleton para asegurarse de que solo haya una instancia de la conexión a la base de datos en todo el ciclo de vida de la aplicación.

- **Clase `Database`**:
  - Contiene las propiedades y métodos necesarios para manejar la conexión con la base de datos.

- **Método `getInstance`**:
  - Este método asegura que solo se cree una instancia de la clase y devuelve la conexión PDO.
  - Es útil para evitar conexiones múltiples a la base de datos.

- **Uso de PDO**:
  - PDO es una biblioteca de PHP que permite trabajar con bases de datos de manera segura y abstracta.
  - Se configura para:
    - Usar UTF-8 como juego de caracteres.
    - Lanzar excepciones en caso de errores.
    - Devolver resultados como objetos por defecto.



##  `User.php`:
Para el manejo de los datos, vamos a usar un modelo llamado `User` que se ubicará en el archivo `models/User.php`. En esta clase primero creamos una instancia de la conexión en la propiedad `$this->pdo`, luego de ello creamos cuatro métodos para el manejo de los datos.

### Explicación del Modelo

- `read()`: Devuelve el listado de usuarios.
- `create()`: Crea un nuevo usuario en la tabla.
- `update()`: Modifica los datos de un usuario.
- `delete()`: Elimina los datos de un usuario seleccionado.

# Explicación del Archivo `User.php`

Este archivo define la clase `User`, que representa el modelo para interactuar con la tabla `users` de la base de datos. Incluye métodos básicos para realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) utilizando PHP y PDO.

## Características Principales

### 1. **Sanitización de Datos**
- Antes de interactuar con la base de datos, los datos de entrada se filtran utilizando `filter_var`.
- Esto protege contra:
  - Inyecciones SQL.
  - Datos inválidos o maliciosos.

### 2. **Uso de `PDO`**
- La clase utiliza PDO (PHP Data Objects) para manejar las operaciones de la base de datos.
- Ventajas de PDO:
  - Seguridad al usar consultas preparadas.
  - Compatibilidad con múltiples motores de bases de datos.
  - Configuración robusta para manejo de errores y codificación.

### 3. **Patrón Active Record**
- La clase implementa un patrón similar a Active Record, donde cada instancia de la clase `User` representa una fila de la tabla `users`.
- Los métodos de la clase permiten interactuar directamente con los registros de la base de datos.

### 4. **Validación de ID**
- Antes de realizar operaciones sensibles como actualización o eliminación, se valida que el ID sea mayor a 0.
- Esto evita errores en la base de datos y asegura que las operaciones se realicen sobre registros válidos.

## Métodos Incluidos

### - **`read()`**
  - Consulta todos los registros de la tabla `users`.
  - Devuelve un objeto PDOStatement con los resultados.

### - **`create()`**
  - Inserta un nuevo registro en la tabla.
  - Sanitiza los valores de entrada (`name`, `email`, `phone`) antes de realizar la operación.

### - **`update()`**
  - Actualiza un registro existente en la tabla `users`.
  - Sanitiza los valores de entrada (`id`, `name`, `email`, `phone`).
  - Solo ejecuta la operación si el ID es válido.

### - **`delete()`**
  - Elimina un registro de la tabla basado en el ID.
  - Sanitiza el valor del ID y verifica su validez antes de ejecutar la operación.

## Notas Profesionales
1. **Seguridad**:
   - El uso de consultas preparadas y sanitización protege contra vulnerabilidades comunes como inyección SQL.
   
2. **Robustez**:
   - Se valida la entrada de datos, especialmente los IDs, para evitar operaciones erróneas.
   
3. **Compatibilidad**:
   - Al usar PDO, este código puede adaptarse fácilmente a otros motores de bases de datos.

4. **Mejoras Posibles**:
   - Agregar manejo detallado de excepciones para capturar errores específicos durante las operaciones CRUD.
   - Incorporar validación adicional para formatos de correo electrónico y números de teléfono.



##  `UserController.php`:
Creamos el archivo `controllers/UserController.php` con la clase que controle los métodos HTTP solicitados. Notar que la solicitud y respuesta están en formato JSON por lo que usamos `json_decode` y `json_encode`, además se usa `http_response_code` para devolver status HTTP correcto.
### Explicación del Controlador
Este código es un controlador que implementa las operaciones CRUD para la entidad `User` utilizando métodos HTTP estándar. Se sigue una estructura profesional que incluye validaciones, manejo de excepciones, y respuestas HTTP claras y significativas. La clase está diseñada para integrarse fácilmente en una API RESTful.


##  `user.php`:
### Explicación del Enrutamiento
Creamos el archivo `routes/user.php` donde agregamos los headers necesarios para recibir y responder datos en formato JSON y los métodos HTTP aceptados, finalmente incluimos el controlador que va a procesar las solicitudes.


##  `.htaccess`:
### Explicación de la Ruta amigable
En el archivo `.htaccess`, configuramos las reglas de reescritura para las URLs amigables.


#   Pruebas de uso
Ejecuta el servidor Apache y accede a la API en:
`http://localhost/API_RESTful_CRUD_PHP_MySQL/user/`

# Uso de la API

La API RESTful soporta las siguientes operaciones: **GET**, **POST**, **PUT**, y **DELETE**. Aquí te explico cómo utilizarlas.


### La API soporta las siguientes operaciones:

#### GET `/user/`
-   Devuelve una lista de todos los usuarios.

#### POST `/user/`
-   Crea un nuevo usuario. Se debe enviar un JSON con los campos `name`, `email` y `phone`.
-   Campos obligatorios: `name` y `email`.

#### PUT `/user/`
-   Actualiza un usuario existente. Se debe enviar un JSON con los campos `id`, `name`, `email` y `phone`.
-   Campos obligatorios: `id`, `name` y `email`.

#### DELETE `/user/`
-   Elimina un usuario por su `id`.
-   Campo obligatorio: `id`

##  Ejemplo de uso:
```json
{
  "id": "1",
  "name": "Miguel Linares",
  "email": "miguel.linares@example.com",
  "phone": "5578512340"
}
```


# Consideraciones Adicionales de la API
## CORS (Cross-Origin Resource Sharing)
La API permite solicitudes de cualquier origen (CORS). Esto significa que se pueden realizar solicitudes desde cualquier dominio o servidor externo. 
La API soporta solicitudes desde cualquier origen (`Access-Control-Allow-Origin: *`).

## Métodos Permitidos: 
La API permite solicitudes con los métodos HTTP GET, POST, PUT, DELETE.

## Headers:
-   `Content-Type: application/json`: La API espera recibir y enviar datos en formato JSON.

-   `Access-Control-Allow-Methods`: Especifica los métodos permitidos (GET, POST, PUT, DELETE).

-   `Access-Control-Max-Age`: Establece el tiempo máximo de validez de la pre-solicitud CORS (en segundos).