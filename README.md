# ArchiSid

ArchiSid es un sistema de gestión de libros archivisticos desarrollado en PHP para facilitar el manejo de libros, usuarios y préstamos. Este proyecto incluye módulos para asignación de libros, devoluciones, autenticación de usuarios y mucho más.

<div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
    <img src="https://github.com/user-attachments/assets/4d104acc-a86e-456f-8c07-3f62d11f26e7" alt="Vista 1" style="width: 200px; height: auto;">
    <img src="https://github.com/user-attachments/assets/0bb2b756-8505-4f8b-8e6f-862e86c13a34" alt="Vista 2" style="width: 200px; height: auto;">
    <img src="https://github.com/user-attachments/assets/955d39e5-f27b-4599-89c0-f364b6a172e9" alt="Vista 3" style="width: 200px; height: auto;">
</div>

## Características
- **Gestor de usuarios**: permite registrar y autenticar usuarios con roles.
- **Asignación de libros**: administra préstamos de libros con registro de estados.
- **Devolución de libros**: controla los libros pendientes y registra devoluciones.
- **Seguridad**: manejo de sesiones y roles para proteger las funcionalidades.
- **Diseño modular**: facilita la extensión y mantenimiento del sistema.

## Tecnologías utilizadas
- **PHP**: lenguaje principal del backend.
- **MySQL**: base de datos para almacenar información de usuarios, libros y préstamos.
- **HTML/CSS/Bootstrap**: para el diseño y la estructura del frontend.
- **JavaScript**: para la interactividad en la interfaz de usuario.

## Instalación
Sigue estos pasos para instalar y ejecutar el proyecto localmente:

1. **Clona este repositorio**:
   ```bash
   git clone https://github.com/tu-usuario/ArchiSid.git
   ```

2. **Configura el servidor local**:
   - Utiliza [XAMPP](https://www.apachefriends.org/) o cualquier otro servidor local compatible con PHP.
   - Copia la carpeta del proyecto al directorio `htdocs` (o equivalente en tu servidor).

3. **Importa la base de datos**:
   - Abre phpMyAdmin.
   - Crea una base de datos llamada `archisid`.
   - Importa el archivo SQL ubicado en `database/archisid.sql`.

4. **Configura el archivo de conexión a la base de datos**:
   - Edita el archivo `config/database.php` con las credenciales de tu servidor local:
     ```php
     <?php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'archisid');
     define('DB_USER', 'tu_usuario');
     define('DB_PASS', 'tu_contraseña');
     ?>
     ```

5. **Accede al sistema**:
   - Abre tu navegador y ve a `http://localhost/ArchiSid`.

## Uso
1. Inicia sesión con un usuario administrador para gestionar libros y usuarios.
2. Asigna libros a los usuarios y gestiona las devoluciones desde los módulos correspondientes.
3. Consulta el estado de los préstamos y realiza reportes según sea necesario.

## Contribuciones
Si deseas contribuir al proyecto, sigue estos pasos:

1. Haz un fork del repositorio.
2. Crea una rama con la función o corrección que deseas realizar:
   ```bash
   git checkout -b mi-rama
   ```
3. Realiza los cambios y haz commits descriptivos.
4. Envía un pull request con una descripción detallada de tus cambios.

## Licencia
Este proyecto está bajo la licencia MIT. Consulta el archivo `LICENSE` para más información.

---

© 2024 ArchiSid. Todos los derechos reservados.

