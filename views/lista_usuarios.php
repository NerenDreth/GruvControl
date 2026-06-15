<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GruvControl | Gestión de Usuarios</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #282828; font-family: 'JetBrains Mono', monospace; padding: 2rem; min-height: 100vh; }
        body.light { background: #fbf1c7; }
        .container { max-width: 1200px; margin: 0 auto; }
        .card { background: #3c3836; border: 1px solid #504945; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3); }
        body.light .card { background: #ebdbb2; border-color: #d5c4a1; }
        .card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #504945; display: flex; justify-content: space-between; align-items: center; }
        body.light .card-header { border-bottom-color: #d5c4a1; }
        .card-body { padding: 1.5rem; }
        .d-flex { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; width: 100%; }
        h2 { color: #fbf1c7; font-size: 1.35rem; }
        body.light h2 { color: #3c3836; }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.25rem; font-family: monospace; font-size: 0.85rem; text-decoration: none; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; }
        .btn:hover { transform: translateY(-2px); }
        .btn-success { background: #98971a; color: #282828; }
        .btn-secondary { background: #928374; color: #282828; }
        body.light .btn-secondary { background: #d5c4a1; color: #3c3836; }
        .btn-warning { background: #d79921; color: #282828; }
        .btn-danger { background: #cc241d; color: #fbf1c7; }
        .btn-sm { padding: 0.3rem 0.8rem; font-size: 0.7rem; }
        .btn-group { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .table thead th { background: #504945; padding: 0.85rem 1rem; text-align: left; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #ebdbb2; border-bottom: 2px solid #665c54; }
        body.light .table thead th { background: #d5c4a1; color: #3c3836; border-bottom-color: #bdae93; }
        .table tbody td { padding: 0.85rem 1rem; border-bottom: 1px solid #504945; font-size: 0.8rem; color: #bdae93; }
        body.light .table tbody td { color: #504945; border-bottom-color: #d5c4a1; }
        .table tbody tr:hover { background: #504945; }
        body.light .table tbody tr:hover { background: #d5c4a1; }
        .table tbody tr:hover td { color: #ebdbb2; }
        body.light .table tbody tr:hover td { color: #282828; }
        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.65rem; font-weight: 600; }
        .badge-admin { background: #458588; color: #fbf1c7; }
        .badge-tecnico { background: #689d6a; color: #282828; }
        .btn-disabled { background: #504945; color: #928374; cursor: not-allowed; }
        body.light .btn-disabled { background: #d5c4a1; color: #7c6f64; }
        .table-responsive { overflow-x: auto; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <h2>👥 GESTIÓN DE USUARIOS</h2>
                <div>
                    <button id="themeToggle" class="btn btn-secondary" style="padding: 0.25rem 0.8rem;">🌓 Tema</button>
                    <a href="index.php?view=nuevoUsuario" class="btn btn-success">➕ Nuevo Usuario</a>
                    <a href="index.php?view=listar" class="btn btn-secondary">← Volver</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>ID</th><th>Usuario</th><th>Rol</th><th>Fecha Creación</th><th>Acciones</th></tr></thead>
                    <tbody>
                        <?php foreach($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['id'] ?></td>
                            <td><?= htmlspecialchars($usuario['usuario']) ?></td>
                            <td><span class="badge <?= $usuario['rol'] == 'Administrador' ? 'badge-admin' : 'badge-tecnico' ?>"><?= $usuario['rol'] == 'Administrador' ? '👑 Administrador' : '🔧 Técnico' ?></span></td>
                            <td><?= $usuario['fecha_creacion'] ?></td>
                            <td><div class="btn-group">
                                <a href="index.php?view=editarUsuario&id=<?= $usuario['id'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                                <?php if($usuario['usuario'] != $_SESSION['usuario']): ?>
                                    <a href="index.php?view=eliminarUsuario&id=<?= $usuario['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar usuario?')">🗑️ Eliminar</a>
                                <?php else: ?>
                                    <span class="btn btn-sm btn-disabled">👤 Usuario Actual</span>
                                <?php endif; ?>
                            </div></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
