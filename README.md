<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## DESCRIPCION

Esta es una prueba tecnica de parte de la empresa Noc Noc y aqui detallo los pasos para la utilizacion correcta del backend

1. Clonar el repositorio
2. Instalar dependencias de composer con el comando composer install
3. Crear el archivo .env en base al archivo .env.example y llenar los datos de la base de datos
4. Generar el api key con el comando php artisan key:generate
5. Generar el link simbolico con el comando php artisan storage:link
6. Migrar la base de datos php artisan migrate con los seeders
7. Correr el proyecto con el comando php artisan serve

## NOTAS

1. Para el servicio de envio de correos electronicos hice la prueba usando mailtrap
2. En los seeders se encuentra el usuario administrador y los roles por lo que se pide realizarlos
