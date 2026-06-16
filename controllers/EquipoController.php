<?php

require_once 'models/Equipo.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EquipoController {

private $modelo;

public function __construct($pdo) {
$this->modelo = new Equipo($pdo);
}

public function index() {
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 10;

$buscar = $_GET['buscar'] ?? '';
$estado = $_GET['estado'] ?? '';
$orden = $_GET['orden'] ?? 'id_desc';

// Obtener equipos paginados para la tabla
$equipos = $this->modelo->obtenerConFiltros($buscar, $estado, $orden, $pagina, $limite);

// Calcular total de equipos para la paginación
$total = $this->modelo->contarConFiltros($buscar, $estado);
$totalPaginas = ceil($total / $limite);

// ========== ESTADÍSTICAS GLOBALES (NO dependen de la página) ==========
$totalGlobal = $this->modelo->contarTodos();
$operativosGlobal = $this->modelo->contarPorEstado('Operativo');
$mantenimientoGlobal = $this->modelo->contarPorEstado('Mantenimiento');
$danadosGlobal = $this->modelo->contarPorEstado('Dañado');

// Calcular alertas de mantenimiento
$alertas = [];
foreach($equipos as $equipo){
if(empty($equipo['fecha_proximo_mantenimiento'])){
continue;
}
$dias = floor(
(strtotime($equipo['fecha_proximo_mantenimiento']) - strtotime(date('Y-m-d'))) / 86400
);
if($dias < 0){
$alertas[] = '🔴 '.$equipo['nombre'].' - vencido hace '.abs($dias).' día(s)';
} elseif($dias <= 7){
$alertas[] = '🟡 '.$equipo['nombre'].' - vence en '.$dias.' día(s)';
}
}

require_once 'views/lista_equipos.php';
}

public function guardar() {

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$this->modelo->registrar(
$_POST['nombre'],
$_POST['estado'],
$_POST['codigo_inventario'],
$_POST['ubicacion'],
$_POST['responsable'],
$_POST['fecha_proximo_mantenimiento']
);
}

header('Location: index.php?view=listar');
exit;
}

public function editar($id) {

$equipo = $this->modelo->obtenerPorId($id);

require_once 'views/editar_equipo.php';
}

public function actualizar() {

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$this->modelo->actualizar(
$_POST['id'],
$_POST['nombre'],
$_POST['estado'],
$_POST['codigo_inventario'],
$_POST['ubicacion'],
$_POST['responsable'],
$_POST['fecha_proximo_mantenimiento']
);
}

header('Location: index.php?view=listar');
exit;
}

public function eliminar($id) {

$this->modelo->eliminar($id);

header('Location: index.php?view=listar');
exit;
}

public function historial($id) {

$equipo = $this->modelo->obtenerPorId($id);

$historial = $this->modelo->obtenerHistorial($id);

require_once 'views/historial.php';
}

public function guardarMantenimiento() {

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$this->modelo->registrarMantenimiento(
$_POST['equipo_id'],
$_SESSION['usuario'],
$_POST['descripcion'],
$_POST['observaciones'],
$_POST['estado'],
$_POST['fecha_proximo_mantenimiento']
);

header(
'Location: index.php?view=historial&id=' .
$_POST['equipo_id']
);

exit;
}   
}
public function bitacora() {

$bitacora = $this->modelo->obtenerBitacora();

require_once 'views/bitacora.php';

}

public function exportarExcel() {
// Obtener todos los equipos
$equipos = $this->modelo->obtenerTodos();

$excel = new Spreadsheet();
$hoja = $excel->getActiveSheet();

// Títulos en negrita
$hoja->setCellValue('A1', 'ID');
$hoja->setCellValue('B1', 'Código');
$hoja->setCellValue('C1', 'Nombre');
$hoja->setCellValue('D1', 'Ubicación');
$hoja->setCellValue('E1', 'Responsable');
$hoja->setCellValue('F1', 'Estado');
$hoja->setCellValue('G1', 'Fecha Último Mantenimiento');
$hoja->setCellValue('H1', 'Próximo Mantenimiento');

// Aplicar negrita a los títulos
$hoja->getStyle('A1:H1')->getFont()->setBold(true);

// Datos
$fila = 2;
foreach($equipos as $equipo){
$hoja->setCellValue('A'.$fila, $equipo['id']);
$hoja->setCellValue('B'.$fila, $equipo['codigo_inventario']);
$hoja->setCellValue('C'.$fila, $equipo['nombre']);
$hoja->setCellValue('D'.$fila, $equipo['ubicacion']);
$hoja->setCellValue('E'.$fila, $equipo['responsable']);
$hoja->setCellValue('F'.$fila, $equipo['estado']);
$hoja->setCellValue('G'.$fila, $equipo['fecha_mantenimiento']);
$hoja->setCellValue('H'.$fila, $equipo['fecha_proximo_mantenimiento']);
$fila++;
}

// Autoajustar ancho de columnas
foreach(range('A', 'H') as $col) {
$hoja->getColumnDimension($col)->setAutoSize(true);
}

// Limpiar buffer de salida
ob_end_clean();

// Headers para descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="equipos_' . date('Y-m-d') . '.xlsx"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public');

$writer = new Xlsx($excel);
$writer->save('php://output');
exit;
}

public function buscarLive() {
    header('Content-Type: application/json');
    
    $busqueda = $_POST['busqueda'] ?? '';
    $equipos = [];
    
    if(!empty($busqueda)) {
        $stmt = $this->modelo->db->prepare(
            "SELECT * FROM equipos 
             WHERE nombre LIKE ? 
             OR codigo_inventario LIKE ? 
             OR responsable LIKE ? 
             ORDER BY id DESC"
        );
        $busquedaParam = "%" . $busqueda . "%";
        $stmt->execute([$busquedaParam, $busquedaParam, $busquedaParam]);
        $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $equipos = $this->modelo->obtenerTodos();
    }
    
    // Contadores para las tarjetas
    $total = 0;
    $operativos = 0;
    $mantenimiento = 0;
    $danados = 0;
    
    foreach($equipos as $e) {
        $total++;
        if($e['estado'] == 'Operativo') $operativos++;
        elseif($e['estado'] == 'Mantenimiento') $mantenimiento++;
        else $danados++;
    }
    
    echo json_encode([
        'equipos' => $equipos,
        'contadores' => [
            'total' => $total,
            'operativos' => $operativos,
            'mantenimiento' => $mantenimiento,
            'danados' => $danados
        ]
    ]);
    exit;

    public function buscarLive() {
    header('Content-Type: application/json');
    
    $busqueda = $_POST['busqueda'] ?? '';
    
    if(!empty($busqueda)) {
        $stmt = $this->modelo->buscarEquiposLive($busqueda);
        $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $equipos = $this->modelo->obtenerTodos();
    }
    
    $total = count($equipos);
    $operativos = 0;
    $mantenimiento = 0;
    $danados = 0;
    
    foreach($equipos as $e) {
        if($e['estado'] == 'Operativo') $operativos++;
        elseif($e['estado'] == 'Mantenimiento') $mantenimiento++;
        else $danados++;
    }
    
    echo json_encode([
        'equipos' => $equipos,
        'contadores' => ['total' => $total, 'operativos' => $operativos, 'mantenimiento' => $mantenimiento, 'danados' => $danados]
    ]);
    exit;
}
}

}