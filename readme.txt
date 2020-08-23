Esta demo ha sido desarrollada con las siguientes herramientas:
- XAMPP
- PHP 7.3.11
- PostgreSQL 10)
- Materialize v1.0.0
- jQuery v3.4.1
- Google Chrome

Paso 1. Crear una base de datos llamada kafekali y luego hacer la importación con el archivo database.sql

Paso 2. Modificar las credenciales necesarias para la conexión con la base de datos (ubicadas en core/helpers/database.php):
    Servidor: localhost (127.0.0.1)
    Usuario: postgres
    Contraseña: ricaldone
    Puerto por defecto (5432)

Paso 3. Ingresar al sitio web que se desea visualizar.
    Inicio del sitio privado (al ingresar por primera vez se pedirá crear un usuario):
        localhost/kafekali/views/dashboard/
    Inicio del sitio público:
        localhost/kafekali/views/commerce/