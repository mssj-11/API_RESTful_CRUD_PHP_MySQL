-- CREATE DATABASE IF NOT EXISTS: Crea la base de datos solo si no existe ya.
CREATE DATABASE IF NOT EXISTS api_restful_crud_php_mysql;


-- USE: Selecciona la base de datos para que los siguientes comandos se ejecuten dentro de ella.
USE api_restful_crud_php_mysql;


/*
    Creamos la tabla ´users´ con cinco campos para los datos de nuestros usuarios
*/
CREATE TABLE users
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL,
    phone      INT          NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);