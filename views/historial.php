<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GruvControl | Historial de Mantenimiento</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #282828; font-family: 'JetBrains Mono', monospace; padding: 2rem; min-height: 100vh; }
        body.light { background: #fbf1c7; }
        .container { max-width: 1200px; margin: 0 auto; }
        .card { background: #3c3836; border: 1px solid #504945; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3); margin-bottom: 1.5rem; }
        body.light .card { background: #ebdbb2; border-color: #d5c4a1; }
        .card-header { padding: 1rem 1.5rem; border-bottom: 1px solid #504945; display: flex; justify-content: space-between; align-items: center; }
        body.light .card-header { border-bottom-color: #d5c4a1; }
        .card-body { padding: 1.5rem; }
        .bg-success .card-header { background: #98971a; }
        .bg-primary .card-header { background: #458588; }
        .card-header h2, .card-header h4 { margin-bottom: 0; font-size: 1.1rem; color: #282828; }
        .text-muted { color: #a89984; font-size: 0.85rem; }
        body.light .text-muted { color: #7c6f64; }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.25rem; font-family: monospace; font-size: 0.85rem; text-decoration: none; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; }
        .btn:hover { transform: translateY(-2px); }
        .btn-secondary { background: #928374; color: #282828; }
        body.light .btn-secondary { background: #d5c4a1; color: #3c3836; }
        .btn-success { background: #98971a; color: #282828; }
        .form-label { display: block; margin-bottom: 0.5rem; color: #ebdbb2; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        body.light .form-label { color: #3c3836; }
        .form-control, .form-select { width: 100%; padding: 0.7rem 1rem; background: #282828; border: 1px solid #504945; border-radius: 10px; color: #ebdbb2; font-family: monospace; font-size: 0.85rem; }
        body.light .form-control, body.light .form-select { background: #fbf1c7; border-color: #d5c4a1; color: #3c3836; }
        .form-control:focus, .form-select:focus { outline: none; border-color: #458588; }
        textarea.form-control { resize: vertical; }
        .table { width: 100%; border-collapse: collapse; }
        .table thead th { background: #504945; padding: 0.75rem; text-align: left; font-size: 0.7rem; text-transform: uppercase; color: #ebdbb2; }
        body.light .table thead th { background: #d5c4a1; color: #3c3836; }
        .table tbody td { padding: 0.75rem; border-bottom: 1px solid #504945; font-size: 0.75rem; color: #bdae93; }
        body.light .table tbody td { color: #504945; border-bottom-color: #d5c4a1; }
        .table tbody tr:hover { background: #504945; }
        body.light .table tbody tr:hover { background: #d5c4a1; }
        .table tbody tr:hover td { color: #ebdbb2; }
        body.light .table tbody tr:hover td { color: #282828; }
        .alert { padding: 1rem; border-radius: 10px; background: rgba(215, 153, 33, 0.1); border-left: 4px solid #d79921; color: #ebdbb2; }
        body.light .alert { color: #3c3836; }
        .btn-group { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 1rem; }
        .row { display: flex; gap: 1rem; margin-bottom: 1rem; }
        .row > div { flex: 1; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div>
                <h2>🔧 Mantenimiento del Equipo</h2>
                <h4>📟 <?= htmlspecialchars($equipo['nombre']) ?></h4>
                <div class="text-muted">Estado actual: <strong><?= htmlspecialchars($equipo['estado']) ?></strong></div>
            </div>
            <div>
                <button id="themeToggle" class="btn btn-secondary" style="padding: 0.25rem 0.8rem;">🌓 Tema</button>
                <a href="index.php?view=listar" class="btn btn-secondary">← Volver</a>
            </div>
        </div>
    </div>
    
    <div class="card bg-success">
        <div class="card-header"><h2>📝 Registrar Nuevo Mantenimiento</h2></div>
        <div class="card-body">
            <form action="index.php?view=guardarMantenimiento" method="POST">
                <input type="hidden" name="equipo_id" value="<?= $equipo['id'] ?>">
                <div style="margin-bottom: 1rem;">
                    <label class="form-label">Trabajo realizado</label>
                    <textarea name="descripcion" class="form-control" rows="4" required></textarea>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="3"></textarea>
                </div>
                <div class="row">
                    <div><label class="form-label">Estado después del mantenimiento</label>
                        <select name="estado" class="form-select" required>
                            <option value="Operativo">🟢 Operativo</option>
                            <option value="Mantenimiento">🟡 Mantenimiento</option>
                            <option value="Dañado">🔴 Dañado</option>
                        </select>
                    </div>
                    <div><label class="form-label">Próximo mantenimiento</label>
                        <input type="date" name="fecha_proximo_mantenimiento" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">✅ Guardar Mantenimiento</button>
            </form>
        </div>
    </div>
    
    <div class="card bg-primary">
        <div class="card-header"><h2>📋 Historial de Mantenimientos</h2></div>
        <div class="card-body">
            <?php if(empty($historial)): ?>
                <div class="alert">📭 Aún no hay registros de mantenimiento para este equipo.</div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
    <tr><th>ID</th><th>Técnico</th><th>Trabajo Realizado</th><th>Observaciones</th><th>Estado</th><th>Fecha</th></tr>
</thead>
<tbody>
<?php foreach($historial as $registro): ?>
    <tr>
        <td><?= $registro['id'] ?></td>
        <td><?= htmlspecialchars($registro['tecnico_nombre'] ?? 'Usuario desconocido') ?></td>
        <td><?= htmlspecialchars($registro['descripcion']) ?></td>
        <td><?= htmlspecialchars($registro['observaciones']) ?></td>
        <td><?= htmlspecialchars($registro['estado']) ?></td>
        <td><?= $registro['fecha'] ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
                    </table>
                </div>
            <?php endif; ?>
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
