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

# Análisis nuevos requerimientos módulo de transacciones
1. Debe haber un monto total disponible.
2. El monto disponible debe establecerse por ciclos de tiempo haciendo uso de la fecha de creación de la transacción.
3. El monto disponible se calcula en base al ciclo de tiempo y sus transacciones.
4. Si cambia el ciclo de tiempo debe actualizar el monto disponible.
5. El monto disponible se ve afectado por las transacciones tipo ingreso las cuales suman y las transacciones de tipo egreso las cuales restan.
6. Por defecto el ciclo de tiempo es el mes actual.
7. Si la transacción es de tipo ingreso y es una proyección financiera restar al monto disponible.
8. Si la transacción es de tipo egreso y es una proyección financiera sumar a el monto disponible.
9. El monto total no debe ser negativo.

## Notas
- Se plantea inicialmente hacer los cálculos desde el frontend. 
- Estoy abierto a otras propuestas que faciliten la implementación.
- Ahora existe la entidad tipos relacionada de muchos a uno con la entidad transacciones.
