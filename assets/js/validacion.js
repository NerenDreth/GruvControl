$(document).ready(function() {
    console.log("✅ Validación cargada");
    
    $('form').on('submit', function(e) {
        let nombre = $('input[name="nombre"]').val().trim();
        let codigo = $('input[name="codigo_inventario"]').val().trim();
        let ubicacion = $('input[name="ubicacion"]').val().trim();
        let estado = $('select[name="estado"]').val();
        let errores = [];
        
        // Limpiar estilos anteriores
        $('input, select').css('border-color', '#504945');
        
        if(nombre === '') {
            errores.push('⚠️ El nombre del equipo es requerido');
            $('input[name="nombre"]').css('border-color', '#cc241d');
        }
        
        if(codigo === '') {
            errores.push('⚠️ El código de inventario es requerido');
            $('input[name="codigo_inventario"]').css('border-color', '#cc241d');
        }
        
        if(ubicacion === '') {
            errores.push('⚠️ La ubicación es requerida');
            $('input[name="ubicacion"]').css('border-color', '#cc241d');
        }
        
        if(estado === '' || estado === 'Seleccione un estado') {
            errores.push('⚠️ Debe seleccionar un estado');
            $('select[name="estado"]').css('border-color', '#cc241d');
        }
        
        if(errores.length > 0) {
            e.preventDefault();
            alert(errores.join('\n'));
            return false;
        }
        
        return true;
    });
});