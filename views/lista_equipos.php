<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GruvControl | Inventario de Equipos</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/js/validacion.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #282828; font-family: 'JetBrains Mono', monospace; padding: 2rem; min-height: 100vh; }
        body.light { background: #fbf1c7; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #3c3836; }
        body.light .header { border-bottom-color: #ebdbb2; }
        .header h1 { color: #fbf1c7; font-size: 1.5rem; font-weight: 600; }
        body.light .header h1 { color: #3c3836; }
        .header h1 span { color: #d79921; }
        .header-sub { color: #928374; font-size: 0.8rem; margin-top: 0.25rem; }
        body.light .header-sub { color: #7c6f64; }
        .user-info { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; background: #3c3836; padding: 0.5rem 1rem; border-radius: 12px; border: 1px solid #504945; }
        body.light .user-info { background: #ebdbb2; border-color: #d5c4a1; }
        .user-badge { background: #504945; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; color: #ebdbb2; }
        body.light .user-badge { background: #d5c4a1; color: #3c3836; }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.25rem; font-family: monospace; font-size: 0.85rem; font-weight: 500; text-decoration: none; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary { background: #458588; color: #fbf1c7; }
        .btn-success { background: #98971a; color: #282828; }
        .btn-warning { background: #d79921; color: #282828; }
        .btn-danger { background: #cc241d; color: #fbf1c7; }
        .btn-secondary { background: #928374; color: #282828; }
        body.light .btn-secondary { background: #d5c4a1; color: #3c3836; }
        .btn-dark { background: #1d2021; color: #ebdbb2; border: 1px solid #504945; }
        .btn-info { background: #689d6a; color: #282828; }
        .btn-group { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card { background: #3c3836; border: 1px solid #504945; border-radius: 12px; padding: 1rem; text-align: center; transition: all 0.2s ease; }
        body.light .stat-card { background: #ebdbb2; border-color: #d5c4a1; }
        .stat-card:hover { border-color: #d79921; transform: translateY(-3px); }
        .stat-number { font-size: 2rem; font-weight: 700; color: #fe8019; }
        body.light .stat-number { color: #d79921; }
        .stat-label { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px; color: #a89984; margin-top: 0.5rem; }
        body.light .stat-label { color: #7c6f64; }
        .chart-card { background: #3c3836; border: 1px solid #504945; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; }
        body.light .chart-card { background: #ebdbb2; border-color: #d5c4a1; }
        .chart-card h5 { color: #ebdbb2; margin-bottom: 0.75rem; font-size: 0.85rem; }
        body.light .chart-card h5 { color: #3c3836; }
        .chart-container { max-height: 220px; width: 100%; }
        .alert-warning { background: rgba(215, 153, 33, 0.1); border-left: 4px solid #d79921; padding: 0.75rem 1rem; border-radius: 12px; margin-bottom: 1.5rem; }
        .alert-warning h5 { color: #d79921; margin-bottom: 0.5rem; font-size: 0.8rem; }
        .alert-item { color: #ebdbb2; font-size: 0.8rem; padding: 0.2rem 0; }
        body.light .alert-item { color: #3c3836; }
        .search-card { background: #3c3836; border: 1px solid #504945; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; }
        body.light .search-card { background: #ebdbb2; border-color: #d5c4a1; }
        .search-row { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1rem; align-items: center; }
        .search-input { flex: 1; padding: 0.6rem 1rem; background: #282828; border: 1px solid #504945; border-radius: 8px; color: #ebdbb2; font-family: monospace; font-size: 0.8rem; }
        body.light .search-input { background: #fbf1c7; border-color: #d5c4a1; color: #3c3836; }
        .search-input:focus { outline: none; border-color: #458588; }
        .loading { display: none; padding: 0.5rem; }
        .badge-info { background: #458588; color: #fbf1c7; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.65rem; }
        .form-label { display: block; margin-bottom: 0.5rem; color: #ebdbb2; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        body.light .form-label { color: #3c3836; }
        .form-control { width: 100%; padding: 0.5rem; background: #282828; border: 1px solid #504945; border-radius: 8px; color: #ebdbb2; font-family: monospace; font-size: 0.8rem; }
        body.light .form-control { background: #fbf1c7; border-color: #d5c4a1; color: #3c3836; }
        .filtros-row { display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end; }
        .filtros-row > div { flex: 1; min-width: 150px; }
        .table-card { background: #3c3836; border: 1px solid #504945; border-radius: 12px; overflow: hidden; }
        body.light .table-card { background: #ebdbb2; border-color: #d5c4a1; }
        .table-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem; border-bottom: 1px solid #504945; }
        body.light .table-header { border-bottom-color: #d5c4a1; }
        .table-header h5 { color: #ebdbb2; font-size: 0.85rem; }
        body.light .table-header h5 { color: #3c3836; }
        .badge-count { background: #504945; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.65rem; color: #ebdbb2; }
        body.light .badge-count { background: #d5c4a1; color: #3c3836; }
        .table { width: 100%; border-collapse: collapse; }
        .table thead th { background: #504945; padding: 0.7rem 0.8rem; text-align: left; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #ebdbb2; border-bottom: 2px solid #665c54; }
        body.light .table thead th { background: #d5c4a1; color: #3c3836; border-bottom-color: #bdae93; }
        .table tbody td { padding: 0.6rem 0.8rem; border-bottom: 1px solid #504945; font-size: 0.75rem; color: #bdae93; }
        body.light .table tbody td { color: #504945; border-bottom-color: #d5c4a1; }
        .table tbody tr:hover { background: #504945; }
        body.light .table tbody tr:hover { background: #d5c4a1; }
        .table tbody tr:hover td { color: #ebdbb2; }
        body.light .table tbody tr:hover td { color: #282828; }
        .badge { display: inline-block; padding: 0.15rem 0.5rem; border-radius: 20px; font-size: 0.6rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-success { background: #98971a; color: #282828; }
        .badge-warning { background: #d79921; color: #282828; }
        .badge-danger { background: #cc241d; color: #fbf1c7; }
        .date-danger { color: #cc241d; font-weight: 600; }
        .empty-state { text-align: center; padding: 2rem; color: #928374; font-size: 0.8rem; }
        .pagination-container { display: flex; justify-content: center; gap: 0.5rem; padding: 1rem; border-top: 1px solid #504945; flex-wrap: wrap; }
        body.light .pagination-container { border-top-color: #d5c4a1; }
        .toast-success { background-color: #98971a !important; }
        .toast-error { background-color: #cc241d !important; }
        .toast-info { background-color: #458588 !important; }
        @media (max-width: 768px) {
            body { padding: 1rem; }
            .table thead th, .table tbody td { padding: 0.4rem; font-size: 0.65rem; }
            .btn { padding: 0.3rem 0.8rem; font-size: 0.7rem; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
            .stat-number { font-size: 1.5rem; }
        }
        @media (max-width: 1024px) { .table { display: block; overflow-x: auto; } }
    </style>
</head>
<body>
<div class="container">

<?php
$totalGlobal = $totalGlobal ?? 0;
$operativosGlobal = $operativosGlobal ?? 0;
$mantenimientoGlobal = $mantenimientoGlobal ?? 0;
$danadosGlobal = $danadosGlobal ?? 0;
$pagina = $pagina ?? 1;
$totalPaginas = $totalPaginas ?? 1;
?>

<?php if(isset($_SESSION['toast'])): ?>
<script>
    toastr.options = {
        "positionClass": "toast-top-right",
        "timeOut": "3000",
        "closeButton": true
    };
    toastr.<?= $_SESSION['toast']['type'] ?>('<?= $_SESSION['toast']['message'] ?>');
</script>
<?php unset($_SESSION['toast']); endif; ?>

<!-- Header -->
<div class="header">
    <div>
        <h1>⚙️ GRUV <span>CONTROL</span></h1>
        <div class="header-sub">Sistema de Gestión de Mantenimiento Industrial</div>
    </div>
    <div class="user-info">
        <span class="user-badge">👤 <?= $_SESSION['usuario'] ?></span>
        <span class="user-badge">🔒 <?= $_SESSION['rol'] ?></span>
        <button id="themeToggle" class="btn btn-secondary" style="padding: 0.25rem 0.8rem;">🌓 Tema</button>
        <div class="btn-group">
            <?php if($_SESSION['rol'] == 'Administrador' || $_SESSION['rol'] == 'Tecnico'): ?>
                <a href="index.php?view=agregar" class="btn btn-success">➕ Nuevo Equipo</a>
            <?php endif; ?>
            <?php if($_SESSION['rol'] == 'Administrador'): ?>
                <a href="index.php?view=usuarios" class="btn btn-dark">👥 Usuarios</a>
                <a href="index.php?view=bitacora" class="btn btn-secondary">📋 Bitácora</a>
            <?php endif; ?>
            <a href="index.php?view=excel" class="btn btn-primary">📎 Exportar Excel</a>
            <a href="index.php?view=logout" class="btn btn-danger">🚪 Cerrar Sesión</a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card"><div class="stat-number"><?= $totalGlobal ?></div><div class="stat-label">Total Equipos</div></div>
    <div class="stat-card"><div class="stat-number" style="color: #98971a"><?= $operativosGlobal ?></div><div class="stat-label">Operativos</div></div>
    <div class="stat-card"><div class="stat-number" style="color: #d79921"><?= $mantenimientoGlobal ?></div><div class="stat-label">En Mantenimiento</div></div>
    <div class="stat-card"><div class="stat-number" style="color: #cc241d"><?= $danadosGlobal ?></div><div class="stat-label">Dañados / Baja</div></div>
</div>

<!-- Gráfico -->
<div class="chart-card">
    <h5>📊 EQUIPOS POR ESTADO</h5>
    <div class="chart-container"><canvas id="estadosChart"></canvas></div>
</div>

<!-- Alertas -->
<?php if(!empty($alertas)): ?>
<div class="alert-warning">
    <h5>⚠️ ALERTAS DE MANTENIMIENTO PREVENTIVO</h5>
    <?php foreach($alertas as $alerta): ?>
        <div class="alert-item"><?= $alerta ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Search -->
<div class="search-card">
    <div class="search-row">
        <input type="text" id="liveSearch" class="search-input" placeholder="🔍 Buscar en vivo..." autocomplete="off">
        <div id="loading" class="loading"><span class="badge-info">🔍 Buscando...</span></div>
        <a href="index.php?view=listar" class="btn btn-secondary">Limpiar</a>
    </div>
    
    <form method="GET" id="filtroForm" style="margin-top: 1rem;">
        <input type="hidden" name="view" value="listar">
        <div class="filtros-row">
            <div>
                <label class="form-label">📌 Filtrar por Estado</label>
                <select name="estado" class="form-control" onchange="this.form.submit()">
                    <option value="">Todos los estados</option>
                    <option value="Operativo" <?= ($_GET['estado'] ?? '') == 'Operativo' ? 'selected' : '' ?>>🟢 Operativo</option>
                    <option value="Mantenimiento" <?= ($_GET['estado'] ?? '') == 'Mantenimiento' ? 'selected' : '' ?>>🟡 Mantenimiento</option>
                    <option value="Dañado" <?= ($_GET['estado'] ?? '') == 'Dañado' ? 'selected' : '' ?>>🔴 Dañado</option>
                </select>
            </div>
            <div>
                <label class="form-label">🔄 Ordenar por</label>
                <select name="orden" class="form-control" onchange="this.form.submit()">
                    <option value="id_desc" <?= ($_GET['orden'] ?? 'id_desc') == 'id_desc' ? 'selected' : '' ?>>ID (Más reciente)</option>
                    <option value="id_asc" <?= ($_GET['orden'] ?? '') == 'id_asc' ? 'selected' : '' ?>>ID (Más antiguo)</option>
                    <option value="nombre_asc" <?= ($_GET['orden'] ?? '') == 'nombre_asc' ? 'selected' : '' ?>>Nombre (A - Z)</option>
                    <option value="nombre_desc" <?= ($_GET['orden'] ?? '') == 'nombre_desc' ? 'selected' : '' ?>>Nombre (Z - A)</option>
                    <option value="estado_asc" <?= ($_GET['orden'] ?? '') == 'estado_asc' ? 'selected' : '' ?>>Estado (A - Z)</option>
                    <option value="estado_desc" <?= ($_GET['orden'] ?? '') == 'estado_desc' ? 'selected' : '' ?>>Estado (Z - A)</option>
                </select>
            </div>
        </div>
    </form>
</div>

<!-- Table -->
<div class="table-card">
    <div class="table-header">
        <h5>📋 EQUIPOS REGISTRADOS</h5>
        <span class="badge-count"><?= count($equipos) ?> resultado(s)</span>
    </div>
    
    <?php if(empty($equipos)): ?>
        <div class="empty-state">No se encontraron equipos.</div>
    <?php else: ?>
    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr><th>ID</th><th>Código</th><th>Nombre</th><th>Ubicación</th><th>Responsable</th><th>Estado</th><th>Último Mant.</th><th>Próximo Mant.</th><th>Acciones</th></tr>
            </thead>
            <tbody>
            <?php foreach($equipos as $equipo): ?>
            <tr>
                <td><?= $equipo['id'] ?></td>
                <td><?= htmlspecialchars($equipo['codigo_inventario']) ?></td>
                <td><?= htmlspecialchars($equipo['nombre']) ?></td>
                <td><?= htmlspecialchars($equipo['ubicacion']) ?></td>
                <td><?= htmlspecialchars($equipo['responsable']) ?></td>
                <td>
                    <?php if($equipo['estado'] == 'Operativo') echo '<span class="badge badge-success">Operativo</span>';
                    elseif($equipo['estado'] == 'Mantenimiento') echo '<span class="badge badge-warning">Mantenimiento</span>';
                    else echo '<span class="badge badge-danger">Dañado</span>'; ?>
                </td>
                <td><?= $equipo['fecha_mantenimiento'] ?></td>
                <td>
                    <?php if(!empty($equipo['fecha_proximo_mantenimiento']) && strtotime($equipo['fecha_proximo_mantenimiento']) < strtotime(date('Y-m-d'))){
                        echo '<span class="date-danger">⚠️ ' . $equipo['fecha_proximo_mantenimiento'] . '</span>';
                    } else { echo $equipo['fecha_proximo_mantenimiento']; } ?>
                </td>
                <td>
                    <div class="btn-group">
                        <a href="index.php?view=historial&id=<?= $equipo['id'] ?>" class="btn btn-info" style="padding: 0.25rem 0.6rem; font-size: 0.65rem;">🔧 Mantenimiento</a>
                        <?php if($_SESSION['rol'] == 'Administrador'): ?>
                            <button onclick="confirmarEliminacion(<?= $equipo['id'] ?>)" class="btn btn-danger" style="padding: 0.25rem 0.6rem; font-size: 0.65rem;">🗑️ Eliminar</button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
    
    <!-- Paginación -->
    <?php if($totalPaginas > 1): ?>
    <div class="pagination-container">
        <?php if($pagina > 1): ?>
            <a href="?view=listar&pagina=<?= $pagina-1 ?>&buscar=<?= urlencode($_GET['buscar'] ?? '') ?>&estado=<?= urlencode($_GET['estado'] ?? '') ?>&orden=<?= urlencode($_GET['orden'] ?? 'id_desc') ?>" class="btn btn-secondary">◀ Anterior</a>
        <?php endif; ?>
        <?php for($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?view=listar&pagina=<?= $i ?>&buscar=<?= urlencode($_GET['buscar'] ?? '') ?>&estado=<?= urlencode($_GET['estado'] ?? '') ?>&orden=<?= urlencode($_GET['orden'] ?? 'id_desc') ?>" class="btn <?= $i == $pagina ? 'btn-primary' : 'btn-secondary' ?>" style="min-width: 35px; text-align: center;"><?= $i ?></a>
        <?php endfor; ?>
        <?php if($pagina < $totalPaginas): ?>
            <a href="?view=listar&pagina=<?= $pagina+1 ?>&buscar=<?= urlencode($_GET['buscar'] ?? '') ?>&estado=<?= urlencode($_GET['estado'] ?? '') ?>&orden=<?= urlencode($_GET['orden'] ?? 'id_desc') ?>" class="btn btn-secondary">Siguiente ▶</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const operativosGlobal = <?= $operativosGlobal ?>;
    const mantenimientoGlobal = <?= $mantenimientoGlobal ?>;
    const danadosGlobal = <?= $danadosGlobal ?>;
    const ctx = document.getElementById('estadosChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['🟢 Operativos', '🟡 Mantenimiento', '🔴 Dañados'],
            datasets: [{
                label: 'Cantidad de Equipos',
                data: [operativosGlobal, mantenimientoGlobal, danadosGlobal],
                backgroundColor: ['#98971a', '#d79921', '#cc241d'],
                borderWidth: 0,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { labels: { color: document.body.classList.contains('light') ? '#3c3836' : '#ebdbb2', font: { size: 10 } }, position: 'top' },
                tooltip: { backgroundColor: '#282828', titleColor: '#ebdbb2', bodyColor: '#bdae93', borderColor: '#d79921', borderWidth: 1 }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, color: '#a89984' }, grid: { color: '#504945' } },
                x: { ticks: { color: '#a89984' }, grid: { color: '#504945' } }
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('gruvboxTheme');
    if (savedTheme === 'light') document.body.classList.add('light');
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('light');
            localStorage.setItem('gruvboxTheme', document.body.classList.contains('light') ? 'light' : 'dark');
            themeToggle.innerHTML = document.body.classList.contains('light') ? '🌙 Dark' : '☀️ Light';
        });
        themeToggle.innerHTML = document.body.classList.contains('light') ? '🌙 Dark' : '☀️ Light';
    }
});

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar equipo?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        background: '#3c3836',
        color: '#ebdbb2',
        confirmButtonColor: '#cc241d',
        cancelButtonColor: '#928374',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?view=eliminar&id=' + id;
        }
    });
}

$(document).ready(function() {
    let timeout = null;
    $('#liveSearch').on('keyup', function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            let busqueda = $('#liveSearch').val();
            $.ajax({
                url: 'index.php?view=buscarLive',
                type: 'POST',
                data: { busqueda: busqueda },
                dataType: 'json',
                beforeSend: function() { $('#loading').fadeIn(); },
                success: function(data) {
                    $('#loading').fadeOut();
                    $('.table tbody').empty();
                    if(data.equipos.length === 0) {
                        $('.table tbody').append('<tr><td colspan="9" class="empty-state">No se encontraron equipos</td></tr>');
                    } else {
                        $.each(data.equipos, function(i, e) {
                            let estadoClass = (e.estado == 'Operativo') ? 'badge-success' : ((e.estado == 'Mantenimiento') ? 'badge-warning' : 'badge-danger');
                            let botonEliminar = '';
                            if (<?= $_SESSION['rol'] == 'Administrador' ? 'true' : 'false' ?>) {
                                botonEliminar = '<button onclick="confirmarEliminacion(' + e.id + ')" class="btn btn-danger" style="padding: 0.25rem 0.6rem; font-size: 0.65rem;">🗑️ Eliminar</button>';
                            }
                            let row = '<tr>' +
                                '<td>' + e.id + '</td>' +
                                '<td>' + escapeHtml(e.codigo_inventario) + '</td>' +
                                '<td>' + escapeHtml(e.nombre) + '</td>' +
                                '<td>' + escapeHtml(e.ubicacion) + '</td>' +
                                '<td>' + escapeHtml(e.responsable) + '</td>' +
                                '<td><span class="badge ' + estadoClass + '">' + e.estado + '</span></td>' +
                                '<td>' + (e.fecha_mantenimiento || '-') + '</td>' +
                                '<td>' + (e.fecha_proximo_mantenimiento || '-') + '</td>' +
                                '<td><div class="btn-group">' +
                                '<a href="index.php?view=historial&id=' + e.id + '" class="btn btn-info" style="padding: 0.25rem 0.6rem; font-size: 0.65rem;">🔧 Mantenimiento</a>' +
                                botonEliminar +
                                '</div></td>' +
                                '</tr>';
                            $('.table tbody').append(row);
                        });
                    }
                    $('.badge-count').text(data.equipos.length + ' resultado(s)');
                    $('.stat-number').eq(0).text(data.contadores.total);
                    $('.stat-number').eq(1).text(data.contadores.operativos).css('color', '#98971a');
                    $('.stat-number').eq(2).text(data.contadores.mantenimiento).css('color', '#d79921');
                    $('.stat-number').eq(3).text(data.contadores.danados).css('color', '#cc241d');
                },
                error: function() { $('#loading').fadeOut(); }
            });
        }, 300);
    });
    
    function escapeHtml(text) { 
        if(!text) return ''; 
        return text.replace(/[&<>]/g, function(m) { 
            if(m === '&') return '&amp;'; 
            if(m === '<') return '&lt;'; 
            if(m === '>') return '&gt;'; 
            return m; 
        }); 
    }
});
</script>

</body>
</html>
