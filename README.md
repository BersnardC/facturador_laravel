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
php artisan migrate

## Cargar data de prueba
Una vez levantado el proyecto: dirigirse a la ruta: localhost/seed (Cargará el seed con toda la data de prueba)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).