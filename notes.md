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

## Proyecciones de gastos
Generar la lógica respectiva.

## Proyecciones Financieras
## Contexto
Realizar los módulos de proyecciones financieras y de categorias de proyecciones financieras para poder administrar las proyecciones financieras las cuales pueden ser para proyectar un ahorro, inversión, deuda, pagos del mes, pagos de la quincena, etc.
## Observaciones
1. Se debe poder ver las proyecciones y categorias financieras de los usuarios.
2. Deben contar con su propio CRUD, donde se puedan crear, editar y eliminar.
3- La proyección puede ser para pagar deudas o establecer ahorros.
3. Las proyecciones pertenecen a un usuario y los usuarios pueden tener múltiples proyecciones.
4. La entidad se llama proyecciones_financieras y cuenta con nombre, descripción, meta y categoria.
5. Las categorías se encuentran en la entidad categorias_proyecciones, las proyecciones pertenecen a una categoria y las categorias pueden tener múltiples proyecciones.
6. La entidad categorias_proyecciones cuenta con nombre, descripción y deben poder personalizarse por los usuarios.
  Ejemplo de categorias_proyecciones:
    - Ahorro
    - Inversión
    - Vacaciones
    - Deuda
    - Pagos del mes
    - Pagos de la quincena
7. A las transacciones se le puede asignar una proyección financiera y una proyección financiera puede tener múltiples transacciones.
8. En transacciones para identificar si una transacción es ingreso o egreso se tiene una relación con la entidad tipo y esta a su vez tiene una relación con la entidad categorias_tipos, la lógica que se establece en el backend para identificar si una transacción es ingreso o egreso no es a través de su tipo, si no a través de la entidad catergorias_tipos que identifica si el tipo es un ingreso o un egreso, ya que los tipos son personalizables por los usuarios y se pueden ver como : ingresos, egresos, ingreso extra, egreso fijo, etc.
9. Si la transacción es de tipo ingreso y tiene una proyección financiera, se suma el importe de la transacción al importe de la meta de la proyección financiera y se resta al monto disponible del módulo de transacciones, si la transacción es de tipo egreso y tiene una proyección financiera, se resta el importe de la transacción al importe de la meta de la proyección financiera y se suma al monto disponible del módulo de transacciones.
10. El monto disponible del módulo de transacciones funciona actualmente por periodo especifico. 

## Objetivos
1. Suplir la necesidad de los usuarios de poder crear sus propias proyecciones financieras.
2. Poder ver el progreso de cada una de las proyecciones financieras.
3. El progreso de las proyecciones financieras debe ser calculado por el sistema.
4. Que a través de la entidad transacciones al asignarle a una transacción un tipo que sea de categoria ingreso o egreso y a su vez una proyección financiera se sume o reste de la meta de la proyección financiera seleccionada.

## Nota
Todas las entidades tienen por defecto fecha_creacion, fecha_actualizacion y fecha_eliminacion.
