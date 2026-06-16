<?php

class Equipo {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function obtenerTodos() {
        $stmt = $this->db->query(
            "SELECT e.*, u.usuario as responsable_nombre 
             FROM equipos e 
             LEFT JOIN usuarios u ON e.responsable_id = u.id 
             ORDER BY e.id DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($texto) {
        $stmt = $this->db->prepare(
            "SELECT e.*, u.usuario as responsable_nombre 
             FROM equipos e 
             LEFT JOIN usuarios u ON e.responsable_id = u.id 
             WHERE e.nombre LIKE ? 
             OR e.codigo_inventario LIKE ? 
             OR u.usuario LIKE ? 
             ORDER BY e.id DESC"
        );
        $busqueda = "%".$texto."%";
        $stmt->execute([$busqueda, $busqueda, $busqueda]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare(
            "SELECT e.*, u.usuario as responsable_nombre 
             FROM equipos e 
             LEFT JOIN usuarios u ON e.responsable_id = u.id 
             WHERE e.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrar($nombre, $estado, $codigo_inventario, $ubicacion, $responsable_id, $fecha_proximo_mantenimiento) {
        $stmt = $this->db->prepare(
            "INSERT INTO equipos (nombre, estado, codigo_inventario, ubicacion, responsable_id, fecha_mantenimiento, fecha_proximo_mantenimiento)
             VALUES (?, ?, ?, ?, ?, NOW(), ?)"
        );
        $resultado = $stmt->execute([$nombre, $estado, $codigo_inventario, $ubicacion, $responsable_id, $fecha_proximo_mantenimiento]);
        
        if($resultado){
            $this->registrarBitacora($_SESSION['usuario_id'], 'creó equipo '.$nombre);
        }
        return $resultado;
    }

    public function actualizar($id, $nombre, $estado, $codigo_inventario, $ubicacion, $responsable_id, $fecha_proximo_mantenimiento) {
        $stmt = $this->db->prepare(
            "UPDATE equipos 
             SET nombre = ?, estado = ?, codigo_inventario = ?, ubicacion = ?, responsable_id = ?, fecha_proximo_mantenimiento = ?
             WHERE id = ?"
        );
        return $stmt->execute([$nombre, $estado, $codigo_inventario, $ubicacion, $responsable_id, $fecha_proximo_mantenimiento, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM equipos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerHistorial($equipoId) {
    $stmt = $this->db->prepare(
        "SELECT h.*, u.usuario as tecnico_nombre 
         FROM historial_mantenimiento h 
         LEFT JOIN usuarios u ON h.usuario_id = u.id 
         WHERE h.equipo_id = ? 
         ORDER BY h.fecha DESC"
    );
    $stmt->execute([$equipoId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function registrarMantenimiento($equipoId, $usuario_id, $descripcion, $observaciones, $estado, $fechaProximo) {
    // Insertar en historial
    $stmt = $this->db->prepare(
        "INSERT INTO historial_mantenimiento (equipo_id, usuario_id, descripcion, observaciones, estado)
         VALUES (?, ?, ?, ?, ?)"
    );
    $resultado = $stmt->execute([$equipoId, $usuario_id, $descripcion, $observaciones, $estado]);
    
    if($resultado){
        // Actualizar el estado del equipo también
        $actualizarEquipo = $this->db->prepare(
            "UPDATE equipos 
             SET fecha_mantenimiento = NOW(), 
                 fecha_proximo_mantenimiento = ?,
                 estado = ?   -- <-- ESTA ES LA LÍNEA QUE FALTABA
             WHERE id = ?"
        );
        $actualizarEquipo->execute([$fechaProximo, $estado, $equipoId]);
        $this->registrarBitacora($usuario_id, 'registró mantenimiento del equipo '.$equipoId);
    }
    return $resultado;
}

    private function registrarBitacora($usuario_id, $accion) {
        $stmt = $this->db->prepare("INSERT INTO bitacora (usuario_id, accion) VALUES (?, ?)");
        return $stmt->execute([$usuario_id, $accion]);
    }

    public function obtenerBitacora() {
        $stmt = $this->db->query(
            "SELECT b.*, u.usuario 
             FROM bitacora b 
             LEFT JOIN usuarios u ON b.usuario_id = u.id 
             ORDER BY b.id DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Métodos para paginación y filtros
    public function obtenerTodosPaginados($pagina = 1, $limite = 10) {
        $offset = ($pagina - 1) * $limite;
        $stmt = $this->db->prepare(
            "SELECT e.*, u.usuario as responsable_nombre 
             FROM equipos e 
             LEFT JOIN usuarios u ON e.responsable_id = u.id 
             ORDER BY e.id DESC 
             LIMIT :limite OFFSET :offset"
        );
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarTodos() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM equipos");
        return (int)$stmt->fetchColumn();
    }

    public function buscarPaginado($texto, $pagina = 1, $limite = 10) {
        $offset = ($pagina - 1) * $limite;
        $busqueda = "%" . $texto . "%";
        $sql = "SELECT e.*, u.usuario as responsable_nombre 
                FROM equipos e 
                LEFT JOIN usuarios u ON e.responsable_id = u.id 
                WHERE e.nombre LIKE ? OR e.codigo_inventario LIKE ? OR u.usuario LIKE ? 
                ORDER BY e.id DESC 
                LIMIT :limite OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $busqueda, PDO::PARAM_STR);
        $stmt->bindValue(2, $busqueda, PDO::PARAM_STR);
        $stmt->bindValue(3, $busqueda, PDO::PARAM_STR);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarBusqueda($texto) {
        $busqueda = "%" . $texto . "%";
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM equipos e 
             LEFT JOIN usuarios u ON e.responsable_id = u.id 
             WHERE e.nombre LIKE ? OR e.codigo_inventario LIKE ? OR u.usuario LIKE ?"
        );
        $stmt->execute([$busqueda, $busqueda, $busqueda]);
        return $stmt->fetchColumn();
    }

    public function obtenerConFiltros($buscar = '', $estado = '', $orden = 'id_desc', $pagina = 1, $limite = 10) {
        $offset = ($pagina - 1) * $limite;
        $sql = "SELECT e.*, u.usuario as responsable_nombre FROM equipos e LEFT JOIN usuarios u ON e.responsable_id = u.id WHERE 1=1";
        
        if(!empty($estado)) {
            $sql .= " AND e.estado = '$estado'";
        }
        if(!empty($buscar)) {
            $sql .= " AND (e.nombre LIKE '%$buscar%' OR e.codigo_inventario LIKE '%$buscar%' OR u.usuario LIKE '%$buscar%')";
        }
        
        switch($orden) {
            case 'id_asc': $sql .= " ORDER BY e.id ASC"; break;
            case 'nombre_asc': $sql .= " ORDER BY e.nombre ASC"; break;
            case 'nombre_desc': $sql .= " ORDER BY e.nombre DESC"; break;
            case 'estado_asc': $sql .= " ORDER BY e.estado ASC"; break;
            case 'estado_desc': $sql .= " ORDER BY e.estado DESC"; break;
            default: $sql .= " ORDER BY e.id DESC";
        }
        
        $sql .= " LIMIT $limite OFFSET $offset";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarConFiltros($buscar = '', $estado = '') {
        $sql = "SELECT COUNT(*) FROM equipos e LEFT JOIN usuarios u ON e.responsable_id = u.id WHERE 1=1";
        if(!empty($estado)) $sql .= " AND e.estado = '$estado'";
        if(!empty($buscar)) $sql .= " AND (e.nombre LIKE '%$buscar%' OR e.codigo_inventario LIKE '%$buscar%' OR u.usuario LIKE '%$buscar%')";
        $stmt = $this->db->query($sql);
        return (int)$stmt->fetchColumn();
    }

    public function contarPorEstado($estado) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM equipos WHERE estado = ?");
        $stmt->execute([$estado]);
        return (int)$stmt->fetchColumn();
    }

    public function buscarEquiposLive($texto) {
        $stmt = $this->db->prepare(
            "SELECT e.*, u.usuario as responsable_nombre 
             FROM equipos e 
             LEFT JOIN usuarios u ON e.responsable_id = u.id 
             WHERE e.nombre LIKE ? OR e.codigo_inventario LIKE ? OR u.usuario LIKE ? 
             ORDER BY e.id DESC"
        );
        $busqueda = "%" . $texto . "%";
        $stmt->execute([$busqueda, $busqueda, $busqueda]);
        return $stmt;
    }
}
