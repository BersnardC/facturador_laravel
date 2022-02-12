## Requerimientos del proyecto
 - Apache
 - Mysql
 - PHP 7++
 - Recomendaciones (XAMP o WAMP)
 - Colocar carpeta del proyecto en htdocs (Xampp)

## Instalar dependencias
composer install

## Archivo .env
Duplicar archivo .env.example y renombrar a .env

## Configurar DB
Ir al archivo .env  y configurar credenciales de base de datos mysql (host, usuario, password, db, puerto)

## Correr migraciones
*php artisan migrate*

## Cargar data de prueba
- Ejecutar *php artisan serve* en la raíz del proyecto

- Una vez levantado el proyecto: dirigirse a la ruta: http://127.0.0.1:8000/seed en el navegador (Cargará el seed con toda la data de prueba)

- http://127.0.0.1:8000/ para probar el proyecto

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).