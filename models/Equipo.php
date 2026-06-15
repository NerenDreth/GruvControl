<?php

class Equipo {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function obtenerTodos() {

        $stmt = $this->db->query(
            "SELECT * FROM equipos ORDER BY id DESC"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($texto) {

        $stmt = $this->db->prepare(
            "SELECT *
             FROM equipos
             WHERE nombre LIKE ?
             OR codigo_inventario LIKE ?
             OR responsable LIKE ?
             ORDER BY id DESC"
        );

        $busqueda = "%".$texto."%";

        $stmt->execute([
            $busqueda,
            $busqueda,
            $busqueda
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {

        $stmt = $this->db->prepare(
            "SELECT * FROM equipos WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrar(
        $nombre,
        $estado,
        $codigo_inventario,
        $ubicacion,
        $responsable,
        $fecha_proximo_mantenimiento
    ) {

        $stmt = $this->db->prepare(
            "INSERT INTO equipos
            (
                nombre,
                estado,
                codigo_inventario,
                ubicacion,
                responsable,
                fecha_mantenimiento,
                fecha_proximo_mantenimiento
            )
            VALUES (?, ?, ?, ?, ?, NOW(), ?)"
        );

        $resultado = $stmt->execute([
            $nombre,
            $estado,
            $codigo_inventario,
            $ubicacion,
            $responsable,
            $fecha_proximo_mantenimiento
        ]);

        if($resultado){
            $this->registrarBitacora(
                $_SESSION['usuario'],
                'creó equipo '.$nombre
            );
        }

        return $resultado;
    }

    public function actualizar(
        $id,
        $nombre,
        $estado,
        $codigo_inventario,
        $ubicacion,
        $responsable,
        $fecha_proximo_mantenimiento
    ) {

        $stmt = $this->db->prepare(
            "UPDATE equipos
            SET
                nombre = ?,
                estado = ?,
                codigo_inventario = ?,
                ubicacion = ?,
                responsable = ?,
                fecha_proximo_mantenimiento = ?
            WHERE id = ?"
        );

        return $stmt->execute([
            $nombre,
            $estado,
            $codigo_inventario,
            $ubicacion,
            $responsable,
            $fecha_proximo_mantenimiento,
            $id
        ]);
    }

    public function eliminar($id) {

        $stmt = $this->db->prepare(
            "DELETE FROM equipos WHERE id = ?"
        );

        return $stmt->execute([$id]);
    }

    public function obtenerHistorial($equipoId) {

        $stmt = $this->db->prepare(
            "SELECT *
             FROM historial_mantenimiento
             WHERE equipo_id = ?
             ORDER BY fecha DESC"
        );

        $stmt->execute([$equipoId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarMantenimiento(
        $equipoId,
        $tecnico,
        $descripcion,
        $observaciones,
        $estado,
        $fechaProximo
    ) {

        $stmt = $this->db->prepare(
            "INSERT INTO historial_mantenimiento
            (
                equipo_id,
                tecnico,
                descripcion,
                observaciones,
                estado
            )
            VALUES (?, ?, ?, ?, ?)"
        );

        $resultado = $stmt->execute([
            $equipoId,
            $tecnico,
            $descripcion,
            $observaciones,
            $estado
        ]);

        if($resultado){

            $actualizarEquipo = $this->db->prepare(
                "UPDATE equipos
                 SET
                    fecha_mantenimiento = NOW(),
                    fecha_proximo_mantenimiento = ?
                 WHERE id = ?"
            );

            $actualizarEquipo->execute([
                $fechaProximo,
                $equipoId
            ]);

            $this->registrarBitacora(
                $_SESSION['usuario'],
                'registró mantenimiento del equipo '.$equipoId
            );
        }

        return $resultado;
    }

    private function registrarBitacora($usuario, $accion) {

        $stmt = $this->db->prepare(
            "INSERT INTO bitacora
            (
                usuario,
                accion
            )
            VALUES (?, ?)"
        );

        return $stmt->execute([
            $usuario,
            $accion
        ]);
    }

    public function obtenerBitacora() {

        $stmt = $this->db->query(
            "SELECT *
             FROM bitacora
             ORDER BY id DESC"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ========== MÉTODOS PARA PAGINACIÓN ==========
    
    public function obtenerTodosPaginados($pagina = 1, $limite = 10) {
        $offset = ($pagina - 1) * $limite;
        $stmt = $this->db->prepare("SELECT * FROM equipos ORDER BY id DESC LIMIT :limite OFFSET :offset");
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
    
    $sql = "SELECT * FROM equipos 
            WHERE nombre LIKE :busqueda 
            OR codigo_inventario LIKE :busqueda 
            OR responsable LIKE :busqueda 
            ORDER BY id DESC 
            LIMIT :limite OFFSET :offset";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
    $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

   public function contarBusqueda($texto) {
    $busqueda = "%" . $texto . "%";
    $stmt = $this->db->prepare(
        "SELECT COUNT(*) FROM equipos 
         WHERE nombre LIKE :busqueda 
         OR codigo_inventario LIKE :busqueda 
         OR responsable LIKE :busqueda"
    );
    $stmt->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn();
}
// ========== MÉTODOS CON FILTROS Y ORDENAMIENTO ==========

public function obtenerConFiltros($buscar = '', $estado = '', $orden = 'id_desc', $pagina = 1, $limite = 10) {
    $offset = ($pagina - 1) * $limite;
    
    // Construcción simple de la consulta
    $sql = "SELECT * FROM equipos WHERE 1=1";
    
    if(!empty($estado)) {
        $sql .= " AND estado = '$estado'";
    }
    
    if(!empty($buscar)) {
        $sql .= " AND (nombre LIKE '%$buscar%' OR codigo_inventario LIKE '%$buscar%' OR responsable LIKE '%$buscar%')";
    }
    
    // Ordenamiento
    switch($orden) {
        case 'id_asc': $sql .= " ORDER BY id ASC"; break;
        case 'nombre_asc': $sql .= " ORDER BY nombre ASC"; break;
        case 'nombre_desc': $sql .= " ORDER BY nombre DESC"; break;
        case 'estado_asc': $sql .= " ORDER BY estado ASC"; break;
        case 'estado_desc': $sql .= " ORDER BY estado DESC"; break;
        default: $sql .= " ORDER BY id DESC";
    }
    
    $sql .= " LIMIT $limite OFFSET $offset";
    
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function contarConFiltros($buscar = '', $estado = '') {
    $sql = "SELECT COUNT(*) FROM equipos WHERE 1=1";
    
    if(!empty($estado)) {
        $sql .= " AND estado = '$estado'";
    }
    
    if(!empty($buscar)) {
        $sql .= " AND (nombre LIKE '%$buscar%' OR codigo_inventario LIKE '%$buscar%' OR responsable LIKE '%$buscar%')";
    }
    
    $stmt = $this->db->query($sql);
    return (int)$stmt->fetchColumn();
}

    // Contar equipos por estado específico (global)
    public function contarPorEstado($estado) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM equipos WHERE estado = ?");
        $stmt->execute([$estado]);
        return (int)$stmt->fetchColumn();
    }
}
