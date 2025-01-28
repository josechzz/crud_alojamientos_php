# CRUD Alojamientos y gestión de Usuarios en PHP

## Descripción
Este proyecto es una aplicación web simple que permita realizar operaciones CRUD de alojamientos y gestión de usuarios, en una base de datos MySQL utilizando PHP.
Cuenta con una vista general de los alojamientos guardados en la base de datos a la cuál pueden acceder sin iniciar sesión, un login para inicio de sesión y también permite registrar nuevos usuarios.

se manejan 2 tipos de usuarios: admin y user, cada uno tiene tareas diferentes por ejemplo, el administrador solo puede agregar alojamientos a la base de datos y ver todos los alojamientos, mientras el usuario normal puede ver los alojamientos, agregarlos a su cuenta como favoritos y eliminarlos de su cuenta, este usuario tiene su propia vista de cuenta de usuario desde la cuál puede ver los alojamientos que añadió y removerlos.

## Indicaciones
1. Se necesita tener instalados los siguientes programas:
   - XAMPP
   - Workbench (opcional)
   - Visual Studio Code o el editor de código preferido
     
2. Clonar el reposirorio o descargarlo como un archivo comprimido .zip, se debe ubicar la carpeta del proyecto dentro de la carpeta htdocs de su instalación de XAMPP
   Ejemplo:
   ```C:\xampp\htdocs\CRUD_alojamientos_php```
   
3. Inicie los servicion de Apache y MySql en XAMPP 
   
4. Generar la Base de datos
   Abra phpMyAdmin en su navegador ```(http://localhost/phpmyadmin/)``` luego importe el script de la base de datos ubicada en la carpeta database dentro del proyecto y ejecute el script
   para poder generar la base de datos.
   
   * Si lo prefiere puede hacer este mismo paso utilizando el programa workbench.
   
5. Abra la carpeta del proyecto en visual studio code
   
   Para poder probar el sistema lo primero es configurar las variables de entorno con sus credenciales de la base de datos.
   para ello ubíquese en la raíz del proyecto y cree un archivo .env luego habra el archivo .env.example que está dentro del proyecto, copie y pegue su contenido en el archivo que usted
   creó y modifique los valores de las variables según las credenciales de su base de datos y guarde los cambios.
   
6. Pruebe el sistema
   Una vez configurado todo abra su navegador e ingrese la url de su proyecto
   Ejemplo:
   ```
   http://localhost/CRUD_alojamientos_php/
   ```
7. Credenciales para iniciar sesión
   - Administrador
     correo: admin@example.com
     contraseña: 12345
     
   - Usuario
     correo: user@example.com
     contraseña: 12345

   Si lo prefiere puede registrarse e iniciar sesión con sus credenciales

## Tecnologías utilizadas
- PHP
- MySQL
- XAMPP
- HTML
- BOOTSTRAP
- WORKBENCH
  
## Autor
José Miguel Chávez Hernández<br>

