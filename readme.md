# Sistema Educativo - Proyecto PHP

Este proyecto es un sistema educativo diseñado en PHP que permite gestionar usuarios, cursos, materias, tareas, calificaciones y estudiantes mediante una base de datos MySQL. Está desarrollado para funcionar con **XAMPP** y utiliza **PHP** como lenguaje principal.

---

## Requisitos previos

Antes de ejecutar el proyecto, asegúrate de tener instalado lo siguiente:

1. **XAMPP**: Para ejecutar el servidor web y la base de datos MySQL.
2. **Navegador web**: Para acceder a la interfaz del sistema.
3. **PHP**: Configurado en XAMPP.
4. **Editor de texto/código**: Para editar archivos, como Visual Studio Code o Sublime Text.

---

## Configuración inicial

### 1. Crear la base de datos
Sigue estos pasos para crear la base de datos:

1. Abre **phpMyAdmin** o tu administrador de base de datos preferido (se recomienda DBeaver).
2. Crea una base de datos llamada `SistemaEducativo` si no existe:
    ```sql
    CREATE DATABASE IF NOT EXISTS SistemaEducativo;
    USE SistemaEducativo;
    ```
3. Copia y pega el siguiente script en la consola de SQL para crear todas las tablas necesarias:

    ```sql
    -- Tabla de Usuarios
    DROP TABLE IF EXISTS Usuarios;
    CREATE TABLE Usuarios (
        id VARCHAR(8) PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        correo VARCHAR(100) UNIQUE NOT NULL,
        contrasenia VARCHAR(255) NOT NULL,
        cedula CHAR(10) UNIQUE NOT NULL,
        rol ENUM('admin', 'profesor', 'estudiante') NOT NULL,
        fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- Tabla de Profesores
    DROP TABLE IF EXISTS Profesores;
    CREATE TABLE Profesores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id VARCHAR(8) NOT NULL,
        especialidad VARCHAR(100),
        FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE CASCADE
    );

    -- Tabla de Cursos
    DROP TABLE IF EXISTS Cursos;
    CREATE TABLE Cursos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        profesor_id INT,
        FOREIGN KEY (profesor_id) REFERENCES Profesores(id) ON DELETE SET NULL
    );

    -- Tabla de Materias
    DROP TABLE IF EXISTS Materias;
    CREATE TABLE Materias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        curso_id INT NOT NULL,
        FOREIGN KEY (curso_id) REFERENCES Cursos(id) ON DELETE CASCADE
    );

    -- Tabla de Clases
    DROP TABLE IF EXISTS Clases;
    CREATE TABLE Clases (
        id INT AUTO_INCREMENT PRIMARY KEY,
        materia_id INT NOT NULL,
        fecha DATE NOT NULL,
        tema VARCHAR(100),
        FOREIGN KEY (materia_id) REFERENCES Materias(id) ON DELETE CASCADE
    );

    -- Tabla de Estudiantes
    DROP TABLE IF EXISTS Estudiantes;
    CREATE TABLE Estudiantes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id VARCHAR(8) NOT NULL,
        matricula VARCHAR(20) UNIQUE NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE CASCADE
    );

    -- Tabla de Tareas
    DROP TABLE IF EXISTS Tareas;
    CREATE TABLE Tareas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        clase_id INT NOT NULL,
        descripcion TEXT NOT NULL,
        fecha_entrega DATE NOT NULL,
        FOREIGN KEY (clase_id) REFERENCES Clases(id) ON DELETE CASCADE
    );

    -- Tabla de Calificaciones
    DROP TABLE IF EXISTS Calificaciones;
    CREATE TABLE Calificaciones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tarea_id INT NOT NULL,
        estudiante_id INT NOT NULL,
        calificacion DECIMAL(5,2) NOT NULL,
        comentarios TEXT,
        FOREIGN KEY (tarea_id) REFERENCES Tareas(id) ON DELETE CASCADE,
        FOREIGN KEY (estudiante_id) REFERENCES Estudiantes(id) ON DELETE CASCADE
    );

    -- Tabla de Inscripciones
    DROP TABLE IF EXISTS Inscripciones;
    CREATE TABLE Inscripciones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        estudiante_id INT NOT NULL,
        curso_id INT NOT NULL,
        fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (estudiante_id) REFERENCES Estudiantes(id) ON DELETE CASCADE,
        FOREIGN KEY (curso_id) REFERENCES Cursos(id) ON DELETE CASCADE
    );

    -- Tabla de estudiantes_tareas
    DROP TABLE IF EXISTS estudiantes_tareas;
    CREATE TABLE estudiantes_tareas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        estudiante_id INT NOT NULL,
        tarea_id INT NOT NULL,
        estado ENUM('entregada', 'atrasada'),
        FOREIGN KEY (estudiante_id) REFERENCES Estudiantes(id) ON DELETE CASCADE,
        FOREIGN KEY (tarea_id) REFERENCES Tareas(id) ON DELETE CASCADE
    );

    -- Triggers
    DELIMITER $$

    CREATE TRIGGER generar_id_usuario
    BEFORE INSERT ON Usuarios
    FOR EACH ROW
    BEGIN
        IF CHAR_LENGTH(NEW.cedula) <> 10 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La cédula debe tener 10 dígitos.';
        END IF;
        SET NEW.id = CONCAT('2511', SUBSTRING(NEW.cedula, -4));
    END$$

    DELIMITER ;

    DELIMITER $$

    CREATE TRIGGER generar_correo_usuario
    BEFORE INSERT ON Usuarios
    FOR EACH ROW
    BEGIN
        IF NEW.nombre IS NULL OR LOCATE(' ', NEW.nombre) = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El nombre debe incluir al menos un espacio para separar el apellido.';
        END IF;

        IF CHAR_LENGTH(NEW.cedula) <> 10 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La cédula debe tener 10 dígitos.';
        END IF;

        SET @primera_letra = LOWER(SUBSTRING(NEW.nombre, 1, 1));
        SET @apellido = LOWER(SUBSTRING_INDEX(NEW.nombre, ' ', -1));
        SET @ultimos_digitos = SUBSTRING(NEW.cedula, -4);
        SET NEW.correo = CONCAT(@primera_letra, @apellido, @ultimos_digitos, '@uta.edu.ec');
    END$$

    DELIMITER ;
    ```

### 2. Configuración de la conexión a la base de datos

1. Localiza el archivo `cone.php` en la carpeta `php` del proyecto.
2. Verifica que los datos de conexión son correctos para tu instalación de XAMPP:
    ```php
    <?php
    $host = 'localhost';
    $user = 'root'; // Usuario por defecto de MySQL
    $password = ''; // Contraseña por defecto de XAMPP
    $database = 'SistemaEducativo';

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    ?>
    ```

---

## Cómo ejecutar el proyecto

1. Abre **XAMPP Control Panel** y asegúrate de iniciar los servicios de **Apache** y **MySQL**.
2. Copia el proyecto en la carpeta `htdocs` de tu instalación de XAMPP.
3. Abre tu navegador y navega a: 
   ```
   http://localhost/[nombre_de_tu_carpeta]
   ```
4. Sigue las instrucciones en la interfaz del sistema para usar sus funcionalidades.

---

## Funcionalidades principales

1. **Gestión de usuarios**: Crear, leer, actualizar y eliminar usuarios con roles específicos. (POR HACER - ADMIN)
2. **Gestión de cursos y materias**: Asignar profesores, inscribir estudiantes, y relacionar materias. (POR HACER - ADMIN)
3. **Gestión de tareas y calificaciones**: Crear clases, crear tareas, registrar calificaciones y comentarios. (LISTO, POR VALIDAR - PROFESOR)
4. **Gestión de estudiantes**: Inscribir estudiantes y verificar entregas. (POR HACER- ADMIN)
5. **Panel para estudiante**: Envio de tareas, visualizacion de calificaciones (POR HACER - ESTUDIANTE)

---

## Contribuciones

Si deseas contribuir al proyecto, por favor crea un *fork* y envía un *pull request*. Asegúrate de seguir las buenas prácticas de desarrollo PHP.

---