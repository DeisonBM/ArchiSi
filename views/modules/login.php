<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArchiSi | Login</title>
    <link href="views/img/asignar.png" rel="icon">
    <link href="views/img/asignar.png" rel="apple-touch-icon">
    <style>
        :root {
            --primary-color: #192d84;
            --accent-color: #f9050b;
            --gray-color: #8b8b8b;
            --green-color: #348d31;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 1rem;
        }

        .logo {
            max-width: 200px;
            height: auto;
        }

        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--gray-color);
        }

        input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--gray-color);
            border-radius: 4px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: var(--accent-color);
        }

        .error-message {
            color: var(--accent-color);
            text-align: center;
            margin-top: 1rem;
            display: none;
        }
    </style>

    <div class="login-container">
        <div class="logo-container">
            <img src="views/img/logo.png" alt="ArchiSi Logo" class="logo">
        </div>
        <h2>Iniciar Sesión</h2>
        <form method="post" action="index.php">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <div id="errorMessage" class="error-message">
            Usuario o contraseña incorrectos. Por favor, intente de nuevo.
        </div>
    </div>


