# Periodos
Anexar la tabla de Periodos

## Descripción
1. Generar una relación entre transacciones(movimientos), donde un periodo pueda tener varios movimientos
2. (relación una a muchos)
3. Verificar la opción de ciclar los periodos, para que sean automaticos y vuelvan a generarse al finalizar el actual
4. Permitir al usuario crear sus propios periodos

# Transacciones(movimientos)
1. En el dashboard agrupar los registros por fechas
2. Al agrupar los registros por fecha (periodos) hacer las operaciones aritmeticas correspondientes (suma, resta)

# Análisis de siguiente paso en el módulo de transacciones
1. Debe haber un monto total de transacciones.
2. En el módulo de transacciones los ingresos suman y los egresos restan a el monto total.
2. Debe ser por ciclos de tiempo haciendo uso de la fecha de creación de la transacción.
3. Por defecto el ciclo de tiempo es el mes actual.
4. Si la transacción es de tipo ingreso y es una proyección financiera restar en transacciones.
5. Si la transacción es de tipo egreso y es una proyección financiera sumar en transacciones.
6. El monto total no debe ser negativo.
