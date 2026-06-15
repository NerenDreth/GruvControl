<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GruvControl | Iniciar Sesión</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/js/validacion.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #282828;
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        /* Login Card */
        .login-container {
            max-width: 450px;
            width: 100%;
        }
        
        .login-card {
            background: #3c3836;
            border-radius: 16px;
            border: 1px solid #665c54;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }
        
        .login-header {
            background: #504945;
            padding: 1.75rem;
            text-align: center;
            border-bottom: 2px solid #d79921;
        }
        
        .login-header h1 {
            color: #fbf1c7;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.5px;
        }
        
        .login-header p {
            color: #bdae93;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #ebdbb2;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-input {
            width: 100%;
            padding: 0.85rem 1rem;
            background: #282828;
            border: 1px solid #665c54;
            border-radius: 10px;
            color: #ebdbb2;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #458588;
            box-shadow: 0 0 0 3px rgba(69, 133, 136, 0.2);
        }
        
        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: #98971a;
            border: none;
            border-radius: 10px;
            color: #282828;
            font-family: 'JetBrains Mono', monospace;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-login:hover {
            background: #d79921;
            transform: translateY(-2px);
        }
        
        .alert-error {
            background: rgba(204, 36, 29, 0.15);
            border-left: 4px solid #cc241d;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            color: #cc241d;
            font-size: 0.85rem;
        }
        
        .login-footer {
            text-align: center;
            padding: 1rem 2rem 2rem;
            color: #928374;
            font-size: 0.7rem;
        }
        
        /* Retro scanline effect */
        .login-card {
            position: relative;
        }
        
        .login-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                0deg,
                rgba(0, 0, 0, 0.05) 0px,
                rgba(0, 0, 0, 0.05) 2px,
                transparent 2px,
                transparent 4px
            );
            pointer-events: none;
            border-radius: 16px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>⚙️ GRUV CONTROL</h1>
                <p>Gestión de Mantenimiento Industrial</p>
            </div>
            
            <div class="login-body">
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert-error">
                        ⚠️ Usuario o contraseña incorrectos
                    </div>
                <?php endif; ?>
                
                <form action="index.php?view=validarLogin" method="POST">
                    <div class="form-group">
                        <label class="form-label">Usuario</label>
                        <input 
                            type="text" 
                            name="usuario" 
                            class="form-input" 
                            placeholder="admin / tecnico"
                            required
                            autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Contraseña</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="••••••••"
                            required>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        ➤ INGRESAR
                    </button>
                </form>
            </div>
            
            <div class="login-footer">
                Sistema de Gestión de Mantenimiento Preventivo
            </div>
        </div>
    </div>
</body>
</html>
