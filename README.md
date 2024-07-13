# CRUD de productos con autenticación de usuarios

## Requisitos

- PHP 8.3
- Node 21.1.0
- Composer

## Instalación

1. Clonar el repositorio: `git clone https://github.com/tu-usuario/tu-repositorio.git`

2. Instalar dependencias: `composer install`

3. Copiar el archivo de configuración: `cp .env.example .env`

4. Generar la clave de la aplicación: `php artisan key:generate`

5. Configurar la base de datos en el archivo `.env`

6. Ejecutar las migraciones: `php artisan migrate`

## Ejecutar la aplicación
`php artisan serve`

La aplicación estará disponible en `http://localhost:8000`

## Pruebas

Para ejecutar las pruebas: `php artisan test`

## Características principales

- CRUD completo para productos
- Autenticación de usuarios
- Pruebas automatizadas para validar la funcionalidad
