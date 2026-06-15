<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GruvControl | Editar Equipo</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #282828; font-family: 'JetBrains Mono', monospace; padding: 2rem; min-height: 100vh; }
        body.light { background: #fbf1c7; }
        .container { max-width: 900px; margin: 0 auto; }
        .card { background: #3c3836; border: 1px solid #504945; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3); }
        body.light .card { background: #ebdbb2; border-color: #d5c4a1; }
        .card-header { background: #d79921; padding: 1.25rem 1.5rem; border-bottom: 2px solid #98971a; display: flex; justify-content: space-between; align-items: center; }
        .card-header h3 { color: #282828; font-size: 1.25rem; font-weight: 600; }
        .card-body { padding: 1.75rem; }
        .form-label { display: block; margin-bottom: 0.5rem; color: #ebdbb2; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        body.light .form-label { color: #3c3836; }
        .form-control, .form-select { width: 100%; padding: 0.75rem 1rem; background: #282828; border: 1px solid #504945; border-radius: 10px; color: #ebdbb2; font-family: monospace; font-size: 0.85rem; transition: all 0.2s ease; }
        body.light .form-control, body.light .form-select { background: #fbf1c7; border-color: #d5c4a1; color: #3c3836; }
        .form-control:focus, .form-select:focus { outline: none; border-color: #458588; box-shadow: 0 0 0 3px rgba(69, 133, 136, 0.2); }
        .row { display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.5rem; }
        .col-md-6 { flex: 1; min-width: 200px; }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.5rem; font-family: monospace; font-size: 0.85rem; font-weight: 500; text-decoration: none; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; margin-right: 0.5rem; }
        .btn:hover { transform: translateY(-2px); }
        .btn-warning { background: #d79921; color: #282828; }
        .btn-secondary { background: #928374; color: #282828; }
        body.light .btn-secondary { background: #d5c4a1; color: #3c3836; }
        .btn-group { margin-top: 1.5rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>✏️ EDITAR EQUIPO</h3>
            <button id="themeToggle" class="btn btn-secondary" style="padding: 0.25rem 0.8rem;">🌓 Tema</button>
        </div>
        <div class="card-body">
            <form action="index.php?view=actualizar" method="POST">
                <input type="hidden" name="id" value="<?= $equipo['id'] ?>">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Nombre del Equipo</label>
                        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($equipo['nombre']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Código de Inventario</label>
                        <input type="text" name="codigo_inventario" class="form-control" value="<?= htmlspecialchars($equipo['codigo_inventario']) ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Ubicación</label>
                        <input type="text" name="ubicacion" class="form-control" value="<?= htmlspecialchars($equipo['ubicacion']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Responsable</label>
                        <input type="text" name="responsable" class="form-control" value="<?= htmlspecialchars($equipo['responsable']) ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="Operativo" <?= $equipo['estado'] == 'Operativo' ? 'selected' : '' ?>>🟢 Operativo</option>
                            <option value="Mantenimiento" <?= $equipo['estado'] == 'Mantenimiento' ? 'selected' : '' ?>>🟡 Mantenimiento</option>
                            <option value="Dañado" <?= $equipo['estado'] == 'Dañado' ? 'selected' : '' ?>>🔴 Dañado</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Próximo Mantenimiento</label>
                        <input type="date" name="fecha_proximo_mantenimiento" class="form-control" value="<?= $equipo['fecha_proximo_mantenimiento'] ?>">
                    </div>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-warning">💾 Guardar Cambios</button>
                    <a href="index.php?view=listar" class="btn btn-secondary">❌ Cancelar</a>
                </div>
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
