### Prueba técnica Kuantaz

Lea detenidamente las instrucciones y síguelas al pie de la letra.

#### Consultar los siguientes endpoint:

- **Beneficios**
- **Filtros**
- **Fichas**

#### Explicación:

El endpoint **beneficios** trae todos los beneficios de un usuario que ha recibido por años. Estos beneficios tienen un monto y una fecha.

El endpoint **filtros** trae la información de cada beneficio. En él, podrás encontrar los montos mínimos y máximos, así como el ID de la ficha.

El endpoint **fichas** trae la información de una ficha en específico. Cada beneficio tiene una ficha.

La relación es la siguiente: un beneficio tiene un filtro, y un filtro tiene una ficha.

#### Se solicita un endpoint que contenga la siguiente información:

1. Beneficios ordenados por años. ✅
2. Monto total por año. ✅
3. Número de beneficios por año. ✅
4. Filtrar solo los beneficios que cumplan los montos máximos y mínimos. ✅
5. Cada beneficio debe traer su ficha. ✅
6. Se debe ordenar por año, de mayor a menor. ✅ 

Puedes ver cómo debe quedar en el siguiente [LINK](#).

### Suma Puntos si:

- Crear documentación con Swagger. ✅
- Uso de las Collection de Laravel. ✅
- Crear archivo Postman u otro. ✅
- Test unitarios. ✅
