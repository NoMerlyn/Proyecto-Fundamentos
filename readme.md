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
3. Realiza un restore de base de datos desde el archivo dump-sistemaeducativo-xxxxxxxxxx
4. Comprueba que el nombre de la base de datos en el archivo cone.php corresponda al nombre de la base de datos que creaste.

### 2. Configuración de la conexión a la base de datos

1.  Localiza el archivo `cone.php` en la carpeta `php` del proyecto.
2.  Verifica que los datos de conexión son correctos para tu instalación de XAMPP:
    ```php
       <?php
    function Conexion(): PDO{
        $server='localhost';
        $usuario="usuario";
        $clave="";
        try{
            $con=new PDO("mysql:host=".$server."; dbname=sisedu",$usuario,$clave );
        }catch(PDOException $e){
        }
        return $con;
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

Si deseas contribuir al proyecto, por favor crea un _fork_ y envía un _pull request_. Asegúrate de seguir las buenas prácticas de desarrollo PHP.

---
