function initTipoProyeccionSelect() {
    var selectorProyeccion = document.getElementById('proyeccion_financiera_id');
    var selectorTipo       = document.getElementById('tipo_id');

    if (!selectorProyeccion || !selectorTipo || selectorTipo.disabled) return;

    var opcionesOriginales = Array.from(selectorTipo.options)
        .filter(function (opcion) { return opcion.value !== ''; })
        .map(function (opcion) {
            return {
                value:      opcion.value,
                categoria:  opcion.dataset.categoria,
                texto:      opcion.text,
                seleccionada: opcion.selected,
            };
        });

    function actualizarOpcionesDeTipo() {
        var tieneProyeccion    = selectorProyeccion.value !== '';
        var valorSeleccionado  = selectorTipo.value;

        while (selectorTipo.options.length > 1) selectorTipo.remove(1);

        if (tieneProyeccion) {
            var opcionActual = opcionesOriginales.find(function (opcion) {
                return opcion.value === valorSeleccionado;
            });
            var categoriaSeleccionada = opcionActual ? opcionActual.categoria : null;

            var categoriasAgregadas = {};
            opcionesOriginales.forEach(function (opcion) {
                if (categoriasAgregadas[opcion.categoria]) return;
                categoriasAgregadas[opcion.categoria] = true;

                var nuevaOpcion = new Option(
                    opcion.categoria == 1 ? 'Aporte a meta' : 'Retiro de meta',
                    opcion.value
                );
                nuevaOpcion.dataset.categoria = opcion.categoria;
                selectorTipo.add(nuevaOpcion);
            });

            for (var indice = 0; indice < selectorTipo.options.length; indice++) {
                if (selectorTipo.options[indice].dataset.categoria == categoriaSeleccionada) {
                    selectorTipo.options[indice].selected = true;
                    break;
                }
            }
        } else {
            opcionesOriginales.forEach(function (opcion) {
                var opcionRestaurada = new Option(opcion.texto, opcion.value);
                opcionRestaurada.dataset.categoria = opcion.categoria;
                opcionRestaurada.selected = opcion.value === valorSeleccionado;
                selectorTipo.add(opcionRestaurada);
            });
        }
    }

    selectorProyeccion.addEventListener('change', actualizarOpcionesDeTipo);
    actualizarOpcionesDeTipo();
}

document.addEventListener('DOMContentLoaded', initTipoProyeccionSelect);
