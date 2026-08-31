---
name: laravel-avanzado
description: >
  Aplica prácticas avanzadas de Laravel que complementan un endpoint REST ya bien construido: colas y jobs para trabajo diferido, events/listeners para desacoplar efectos secundarios, transacciones de base de datos para operaciones atómicas, caching de consultas costosas, rate limiting, y notifications. Usa esta skill SIEMPRE que el usuario mencione trabajo en background, colas, jobs, eventos, transacciones multi-tabla, caché, límites de peticiones (throttling), o notificaciones (email/SMS/push) dentro de un proyecto Laravel — como complemento a la skill `laravel-api-rest`, no como reemplazo.
---

# Laravel Avanzado

Esta skill es un complemento de `laravel-api-rest`, no un sustituto. Mientras esa skill cubre la estructura de un endpoint (Request → Policy → Resource → Controlador → Tests), esta cubre las piezas que entran en juego cuando la lógica de negocio crece: trabajo diferido, desacoplamiento de efectos secundarios, atomicidad, rendimiento y límites de uso.

## Cuándo usarla

- El usuario menciona que algo debe ejecutarse en segundo plano (enviar un email, procesar un archivo, generar un reporte) sin bloquear la respuesta al cliente.
- Hay una acción que debería disparar varios efectos secundarios independientes (ej. "al crear un pedido: notificar, actualizar inventario, registrar en analytics").
- Una operación toca varias tablas y debe ser todo-o-nada.
- Un endpoint consulta datos costosos que no cambian a cada request.
- El proyecto necesita limitar cuántas peticiones puede hacer un cliente en un período.
- Se necesita enviar una notificación (email, SMS, push) de forma estructurada, no un mail ad-hoc.

Si la tarea es simplemente construir un endpoint CRUD estándar, usa `laravel-api-rest` — no fuerces conceptos de esta skill donde no aportan valor.

## Principios que debe seguir siempre

1. **No optimices ni desacoples prematuramente.** Si una acción es simple y no tiene efectos secundarios reales, no la conviertas en Job/Event solo por "buena práctica" — eso agrega complejidad innecesaria. Usa estas herramientas cuando el problema real las justifica (lentitud, necesidad de desacoplar, atomicidad real).
2. **Toda operación multi-tabla que deba ser atómica va en una transacción explícita**, no confíes en que "probablemente no falle".
3. **Todo Job debe ser idempotente cuando sea razonablemente posible** (que ejecutarlo dos veces por error de reintento no duplique efectos, ej. no crear un pedido dos veces).
4. **Cachear con invalidación explícita**, nunca dejar caché sin una estrategia clara de cuándo se refresca — un dato cacheado y nunca invalidado es un bug esperando pasar.

## Colas y Jobs

Usa un Job cuando la operación es lenta (llamada externa, procesamiento pesado) y no necesita bloquear la respuesta al usuario.

```php
class ProcessOrderExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function handle(): void
    {
        // procesamiento pesado, ej. generar PDF o exportar a un servicio externo
    }
}

ProcessOrderExport::dispatch($order);
```

- Define `$tries` y `$backoff` si el Job puede fallar por causas transitorias (ej. timeout de una API externa).
- Usa `failed()` en el Job para manejar el caso de fallo definitivo (ej. notificar, registrar).
- En desarrollo, confirma que el proyecto tenga un driver de cola real configurado (`database`, `redis`) — el driver `sync` ejecuta todo de forma síncrona y oculta problemas de diseño del Job.

## Events y Listeners

Úsalos para desacoplar efectos secundarios de una acción principal, especialmente cuando hay más de un efecto o el efecto no es esencial para que la operación principal se considere exitosa.

```php
event(new OrderCreated($order));

class SendOrderConfirmation
{
    public function handle(OrderCreated $event): void
    {
        Notification::send($event->order->user, new OrderConfirmed($event->order));
    }
}
```

- Si el efecto secundario es lento, el Listener debe implementar `ShouldQueue` para que se procese en background.
- No abuses de Events para lógica que es parte esencial de la operación (ej. calcular el total del pedido) — eso va directo en el Service/Action, no como efecto desacoplado.

## Transacciones de base de datos

Cualquier operación que escriba en más de una tabla y deba ser todo-o-nada:

```php
DB::transaction(function () use ($data) {
    $order = Order::create($data);
    $order->items()->createMany($data['items']);
    $order->user->decrement('credit_balance', $order->total);
});
```

- Si necesitas ejecutar un Job o disparar un Event solo después de que la transacción se confirme, usa `DB::afterCommit()` o el Job/Listener con `ShouldQueueAfterCommit` (o dispara el evento fuera de la transacción, después del `DB::transaction()`).

## Caching

```php
$products = Cache::remember('products.featured', now()->addHours(6), function () {
    return Product::where('featured', true)->get();
});
```

- Invalida el caché explícitamente cuando el dato subyacente cambia (`Cache::forget('products.featured')` en el mismo Service/Observer que actualiza el producto), no dependas solo del TTL si el dato cambia por acción del usuario.
- Para datos por-usuario, incluye el ID en la clave de caché (`"user.{$id}.dashboard"`) para no mezclar datos entre usuarios.

## Rate Limiting

```php
Route::middleware(['throttle:api'])->group(function () {
    // rutas
});

// límite custom
RateLimiter::for('uploads', function (Request $request) {
    return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
});
```

- Aplica límites más estrictos a endpoints costosos o sensibles (login, envío de emails, uploads) que al resto de la API.
- Devuelve el error 429 estándar de Laravel (ya incluye headers `Retry-After`) — no lo reemplaces por un manejo custom salvo necesidad real.

## Notifications

Usa el sistema de Notifications de Laravel para cualquier email/SMS/push estructurado, en vez de un `Mail::send()` disperso por el código.

```php
class OrderConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirmación de tu pedido')
            ->line("Tu pedido #{$this->order->id} fue confirmado.");
    }
}
```

- Implementa `ShouldQueue` en la Notification si el canal es lento (email, push) para no bloquear la request.
- Usa el canal `database` cuando el proyecto necesita mostrar notificaciones dentro de la propia app, no solo enviarlas por fuera.

## Referencias

- `references/checklist-rendimiento.md` — checklist rápido de rendimiento (N+1, caché, colas) a revisar antes de dar por terminada una funcionalidad con alto volumen esperado.
