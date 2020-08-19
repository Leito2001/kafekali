Esta demo ha sido desarrollada con las siguientes herramientas:
- WAPP v7.3.11 (PHP 7.3.11 / PostgreSQL 11.5)
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
        localhost/kafekali2/views/dashboard/
    Inicio del sitio público:
        localhost/kafekali2/views/commerce/

Si se opta por utilizar XAMPP en lugar de WAPP, es necesario acceder a la dirección C:\xampp\php y hacer lo siguiente:
1. Ubicar y abrir el archvio php.ini
2. Buscar la línea ;extension=pdo_pgsql
3. Borrar el ; que esta al inicio de la línea
4. Guardar los cambios y cerrar el archivo
5. Reiniciar Apache

Para realizar lo anterior es necesario que Apache de WAPP no este funcionando (hay que detener el servicio).