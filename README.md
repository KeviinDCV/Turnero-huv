# Turnero HUV

Sistema de gestión de turnos para el Hospital Universitario del Valle.

## Acerca del Proyecto

Este proyecto es una aplicación web desarrollada en Laravel que implementa un sistema para la gestión de turnos. Permite a los administradores gestionar usuarios (asesores) y proporciona una interfaz para que los asesores atiendan a los usuarios, así como pantallas para visualizar el estado de los turnos en tiempo real.

## Características

-   **Panel de Administración:**
    -   Inicio de sesión seguro para administradores.
    -   Gestión de usuarios (CRUD): crear, leer, actualizar y eliminar asesores.
-   **Panel del Asesor:**
    -   Dashboard para la gestión de turnos asignados.
-   **Visualización Pública:**
    -   Pantalla de TV para mostrar los turnos llamados.
    -   Interfaz de quiosco/atril para que los usuarios soliciten un turno.
-   **Autenticación:**
    -   Sistema de login para personal autorizado (administradores y asesores).

## Requisitos

-   PHP >= 8.1
-   Composer
-   Node.js & NPM
-   Una base de datos (ej. MySQL, PostgreSQL)

## Guía de Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone <URL_DEL_REPOSITORIO>
    cd turnero-huv
    ```

2.  **Instalar dependencias de PHP:**
    ```bash
    composer install
    ```

3.  **Instalar dependencias de JavaScript:**
    ```bash
    npm install
    ```

4.  **Configurar el entorno:**
    -   Copia el archivo de ejemplo para las variables de entorno:
        ```bash
        cp .env.example .env
        ```
    -   Genera la clave de la aplicación:
        ```bash
        php artisan key:generate
        ```

5.  **Configurar la base de datos:**
    -   Abre el archivo `.env` y edita las siguientes variables con los datos de tu base de datos:
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=turnero_huv
        DB_USERNAME=root
        DB_PASSWORD=
        ```

6.  **Ejecutar las migraciones y seeders:**
    -   Este comando creará la estructura de la base de datos y registrará los datos iniciales (si existen seeders).
        ```bash
        php artisan migrate --seed
        ```

7.  **Compilar los assets:**
    ```bash
    npm run dev
    ```

8.  **Iniciar el servidor de desarrollo:**
    ```bash
    php artisan serve
    ```
    La aplicación estará disponible en `http://127.0.0.1:8000`.

## Rutas Principales de la Aplicación

-   `/admin`: Página de inicio de sesión para administradores.
-   `/dashboard`: Panel principal del administrador.
-   `/users`: Gestión de usuarios (CRUD).
-   `/asesor/dashboard`: Panel de control para los asesores.
-   `/turnos/inicio`: Página principal para la generación de turnos por parte del usuario.
-   `/tv`: Visualización de turnos para pantallas/televisores.
-   `/atril`: Interfaz para el quiosco de generación de turnos.

## Estructura de la Base de Datos

La tabla principal modificada para esta aplicación es `users`.

### Tabla `users`

| Campo              | Tipo                         | Descripción                                      |
| ------------------ | ---------------------------- | ------------------------------------------------ |
| `id`               | `bigint`, `unsigned`, `AI`   | Identificador único del usuario.                 |
| `nombre_completo`  | `varchar`                    | Nombre completo del usuario.                     |
| `correo_electronico`| `varchar`                   | Correo electrónico del usuario.                  |
| `rol`              | `enum('Administrador', 'Asesor')` | Rol del usuario en el sistema.                   |
| `cedula`           | `varchar`                    | Número de cédula del usuario.                    |
| `nombre_usuario`   | `varchar`                    | Nombre de usuario para el inicio de sesión.      |
| `password`         | `varchar`                    | Contraseña para el inicio de sesión.             |
| `remember_token`   | `varchar`                    | Token para la función "recordarme".              |
| `timestamps`       | `timestamp`                  | Fechas de creación y última actualización.       |
