# Checklist de Rendimiento — Laravel

Revisa esto antes de dar por terminada una funcionalidad que maneje volumen no trivial de datos o tráfico.

## Consultas

- [ ] ¿Alguna colección devuelta carga relaciones sin `with()`/`load()`? (riesgo de N+1)
- [ ] ¿Hay consultas dentro de un loop que podrían convertirse en una sola consulta (`whereIn`, `loadCount`, etc.)?
- [ ] ¿Los campos usados en `WHERE`/`ORDER BY` frecuentes tienen índice en la migración?

## Caché

- [ ] ¿Hay una consulta costosa y poco cambiante que se repite en cada request y podría cachearse?
- [ ] Si se cachea, ¿existe una invalidación explícita cuando el dato subyacente cambia?

## Colas

- [ ] ¿Hay alguna operación lenta (email, llamada externa, generación de archivo) ejecutándose de forma síncrona dentro de la request?
- [ ] Si se movió a un Job, ¿el driver de cola configurado es real (no `sync`) en el entorno donde esto importa?

## Transacciones y atomicidad

- [ ] ¿Alguna operación multi-tabla podría dejar datos inconsistentes si falla a la mitad, y no está envuelta en `DB::transaction()`?

## Rate limiting

- [ ] ¿Los endpoints costosos o sensibles (uploads, envío de emails, login) tienen un límite de throttling más estricto que el resto de la API?
