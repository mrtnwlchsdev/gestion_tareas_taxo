# Aplicacion para la gestión de distintas tareas

## Prueba de desarrollo | Todos los derechos reservados 2023

### Variables y funciones

- Las variables han sido nombrados utilizando el estilo de escritura snake_case
- Las funciones han sido identificadas utilizando el estilo de escritura camelCase

## Ejecutar proyecto

Clonar el proyecto

    git clone git@github.com:mrtnwlchsdev/gestion_tareas_taxo.git

Instalar dependencias

PHP

    composer install

JavaScript

    npm install

Desde la ruta del proyecto ejecutar 2 terminales.

En la primera terminal ejecutar el siguiente comando para levantar el servicio del front ** Por defecto se ejecuta en el puerto 5173 del localhost

    npm run dev

En la segunda terminal ejecutar el siguiente comando para levantar el servicio del back ** Por defecto se ejecuta en el puerto 8000 del localhost

    php artisan serve

La aplicacion es visualizada en la ruta donde se ejecuta el back.

La base de datos configurada por defecto para el proceso de prueba ha sido nombrada taxo, se debe realizar la configuración del .env para la la correcta conexión con la base de datos. Además se debe crear la base de datos (en mi caso utilice MySQL) antes de ejecutar la siguiente migración e iniciar a usar la aplicación.

    php artisan migrate:refresh
