<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GruvControl | Nuevo Usuario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #282828; font-family: 'JetBrains Mono', monospace; padding: 2rem; min-height: 100vh; }
        body.light { background: #fbf1c7; }
        .container { max-width: 600px; margin: 0 auto; }
        .card { background: #3c3836; border: 1px solid #504945; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3); }
        body.light .card { background: #ebdbb2; border-color: #d5c4a1; }
        .card-header { background: #98971a; padding: 1.25rem 1.5rem; border-bottom: 2px solid #d79921; display: flex; justify-content: space-between; align-items: center; }
        .card-header h3 { color: #282828; font-size: 1.25rem; font-weight: 600; }
        .card-body { padding: 1.75rem; }
        .form-label { display: block; margin-bottom: 0.5rem; color: #ebdbb2; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        body.light .form-label { color: #3c3836; }
        .form-control, .form-select { width: 100%; padding: 0.75rem 1rem; background: #282828; border: 1px solid #504945; border-radius: 10px; color: #ebdbb2; font-family: monospace; font-size: 0.85rem; transition: all 0.2s ease; }
        body.light .form-control, body.light .form-select { background: #fbf1c7; border-color: #d5c4a1; color: #3c3836; }
        .form-control:focus, .form-select:focus { outline: none; border-color: #458588; box-shadow: 0 0 0 3px rgba(69, 133, 136, 0.2); }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.5rem; font-family: monospace; font-size: 0.85rem; font-weight: 500; text-decoration: none; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; margin-right: 0.5rem; }
        .btn:hover { transform: translateY(-2px); }
        .btn-success { background: #98971a; color: #282828; }
        .btn-secondary { background: #928374; color: #282828; }
        body.light .btn-secondary { background: #d5c4a1; color: #3c3836; }
        .btn-group { margin-top: 1.5rem; }
        .mb-3 { margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>➕ CREAR NUEVO USUARIO</h3>
            <button id="themeToggle" class="btn btn-secondary" style="padding: 0.25rem 0.8rem;">🌓 Tema</button>
        </div>
        <div class="card-body">
            <form action="index.php?view=guardarUsuario" method="POST">
                <div class="mb-3"><label class="form-label">Usuario</label><input type="text" name="usuario" class="form-control" required autofocus></div>
                <div class="mb-3"><label class="form-label">Contraseña</label><input type="text" name="password" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Rol</label><select name="rol" class="form-select" required><option value="Administrador">👑 Administrador</option><option value="Tecnico" selected>🔧 Técnico</option></select></div>
                <div class="btn-group"><button type="submit" class="btn btn-success">✅ Guardar Usuario</button><a href="index.php?view=usuarios" class="btn btn-secondary">❌ Cancelar</a></div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('gruvboxTheme');
    if (savedTheme === 'light') { document.body.classList.add('light'); }
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('light');
            if (document.body.classList.contains('light')) {
                localStorage.setItem('gruvboxTheme', 'light');
                themeToggle.innerHTML = '🌙 Dark';
            } else {
                localStorage.setItem('gruvboxTheme', 'dark');
                themeToggle.innerHTML = '☀️ Light';
            }
        });
        themeToggle.innerHTML = document.body.classList.contains('light') ? '🌙 Dark' : '☀️ Light';
    }
});
</script>
</body>
</html>
