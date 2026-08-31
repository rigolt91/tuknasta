# Base de datos y modelos

MySQL 8. 26 migraciones. Modelos en `app/Models/`.

## Tablas

### Núcleo de usuarios y auth

- **`users`** — `id`, `name`, `last_name`, `email` (unique), `password`, `current_team_id` (Jetstream, sin FK real), `profile_photo_path`, `disabled` (bool), campos 2FA de Fortify, `softDeletes`.
- **`user_contacts`** — libreta de direcciones/contactos de envío del cliente: `user_id`, `name`, `last_name`, `email`, `dni`, `phone`, `street`, `between_streets`, `number`, `province_id`, `municipality_id` (ambos nullable), **`prefer`** (bool — marca el contacto por defecto usado en checkout), `softDeletes`.
- **`password_reset_tokens`**, **`sessions`**, **`personal_access_tokens`** (Sanctum), **`failed_jobs`**, **`jobs`** — infraestructura estándar de Laravel.
- **`user_jobs`** — `user_id`, `job_id` (entero, **sin FK real** a `jobs`); vincula un usuario a un job en cola (probablemente el job que libera el carrito tras timeout, ver [07-deuda-tecnica.md](07-deuda-tecnica.md)).

### Permisos (Spatie Permission)

`permissions`, `roles`, `model_has_permissions`, `model_has_roles`, `role_has_permissions` — esquema estándar del paquete, sin "teams". Roles existentes: `administrator`, `editor`, `customer`.

### Geografía

- **`provinces`** — `id`, `name`.
- **`municipalities`** — `id`, `name`, `province_id` (FK).
- **`rate_transportations`** — `province_id`, `municipality_id` (FK `cascadeOnDelete`), `amount` (double) — tarifa de envío fija por combinación provincia/municipio, usada en el checkout cuando el método de entrega es "a domicilio".

### Catálogo

- **`categories`** — `image`, `name` (unique), `description`, `show` (bool), `softDeletes`.
- **`subcategories`** — `name` (unique), `category_id` (FK), `show` (bool), `softDeletes`.
- **`branches`** — proveedores/vendors del marketplace: `name` (unique), `phone`, `email` (unique), `contract_number`, `person_contact`, `sub_branch` (int nullable, añadido en migración posterior — sugiere jerarquía de sub-sucursales, pero **sin FK real ni self-relation en el modelo**; se maneja a mano en la capa de aplicación). `softDeletes`.
- **`products`** — `image`, `name` (unique), `sku` (unique), `slug` (unique), `short_description`, `description`, `price` (double), `previous_price` (double nullable, para mostrar descuentos), `stock` (int), `show` (bool), `recommend` (bool), `category_id`, `subcategory_id`, `branch_id` (FK). `softDeletes`.
- **`product_starts`** — sistema de valoración: `product_id` (FK `cascadeOnDelete`), y cinco contadores `one`..`five` (uno por cada valor de estrella). **No es un promedio**: cada voto incrementa el contador de esa estrella; `getStarts()` en el modelo devuelve la estrella con más votos (moda), no una media ponderada.
- **`sliders`** — banners del home: `image`, `title`, `text`, `link`.

### Carrito y pedidos

- **`carts`** — `user_id`, `product_id`, `units`, `price` (precio **congelado** al momento de agregar al carrito, no se recalcula si el producto cambia de precio). Sin `softDeletes` (se borra la fila al quitar del carrito).
- **`delivery_methods`** — `name` (unique). Demo: "Recogida en Tienda", "Entrega Domicilio".
- **`order_statuses`** — `name` (unique). Demo: "Procesando", "Enviada", "Entregada".
- **`user_orders`** — `number` (unique, formato tipo ORD-XXXXX), `order_status_id`, `delivery_method_id`, `user_id`, `user_contact_id` (a qué dirección se envía), `payment` (bool simple — pagado/no pagado, **sin tabla de transacciones separada**).
- **`user_purchased_products`** — línea de pedido, snapshot inmutable: `user_order_id` (FK `cascadeOnDelete`), `product_id`, `units`, `price` (unitario en el momento de compra), `amount` (total de línea).

### Configuración

- **`upagos_directs`** — singleton de configuración: `token` y `mode` (demo/producción) de la pasarela UPagos, más `email`, `phone`, `address`, `facebook`, `instagram`, `twitter`, `google`, `linkedin` (mezcla config de pagos con datos de contacto/redes del sitio, usados en el footer).

## Modelos y relaciones

| Modelo | Tabla | Relaciones clave | Notas |
|---|---|---|---|
| `User` | `users` | `cart()`, `userContact()`, `userOrder()`, `userJob()` hasMany | Traits: `HasApiTokens`, `HasProfilePhoto`, `Notifiable`, `TwoFactorAuthenticatable`, `HasRoles`, `SoftDeletes`. Scope `createOrRestore` (reactiva usuario soft-eliminado). `cartAmount()` suma el total del carrito. |
| `UserContact` | `user_contacts` | `user()`, `province()`, `municipality()` belongsTo; `userOrder()` hasMany | Scopes `wherePrefer`, `whereContact`. |
| `Branch` | `branches` | `product()` hasMany | Proveedor. `sub_branch` sin relación Eloquent real (ver arriba). |
| `Category` | `categories` | `subcategory()`, `product()` hasMany | `userContact()` hasMany declarada pero **sin FK real** (código vestigial). |
| `Subcategory` | `subcategories` | `category()` belongsTo, `product()` hasMany | |
| `Product` | `products` | `category()`, `subcategory()`, `branch()` belongsTo; `cart()`, `userPurchasedProduct()` hasMany; `productStart()` hasOne | Scopes: `show`, `recommend`, `whereName`, `whereBranch`, `whereSubcategory`, `whereCategory`, `wherePrice`, `whereInCategory`. Métodos: `purchasedUnits/Price/Amount($date)` filtran por `created_at LIKE %date%`. |
| `ProductStart` | `product_starts` | `product()` belongsTo | |
| `Cart` | `carts` | `user()`, `product()` belongsTo | |
| `DeliveryMethod` | `delivery_methods` | `order()` hasMany `App\Models\Order` | **Este modelo `Order` no existe** — relación rota/sin uso (el modelo real de pedidos es `UserOrder`). |
| `OrderStatus` | `order_statuses` | `userOrder()` hasMany | Scope `whereName`. |
| `UserOrder` | `user_orders` | `user()`, `deliveryMethod()`, `orderStatus()`, `userContact()` belongsTo; `userPurchasedProduct()` hasMany | Scopes ricos para el panel admin: `whereStatus`, `whereMethod`, `whereDate`, `whereDateBetween`, `whereNumber`, `whereUser`, `joinUserContact` + `whereContact` (búsqueda por nombre/DNI del contacto). Métodos `totalProducts()`, `totalCost()`. |
| `UserPurchasedProduct` | `user_purchased_products` | `product()`, `userOrder()` belongsTo | Fillable declara `order_id` pero la columna real es `user_order_id` — ver [07-deuda-tecnica.md](07-deuda-tecnica.md). |
| `UserJob` | `user_jobs` | `user()` belongsTo | |
| `Province` | `provinces` | `municipality()`, `rateTransportation()` hasMany; `user()` hasMany | `user()` es relación vestigial: no existe `province_id` en `users`. |
| `Municipality` | `municipalities` | `rateTransportation()` **hasOne** | Asume una sola tarifa vigente por municipio. |
| `RateTransportation` | `rate_transportations` | `province()`, `municipality()` belongsTo | Scopes `whereProvince`, `whereMunicipality` (like). |
| `Slider` | `sliders` | — | Solo fillable. |
| `UpagosDirect` | `upagos_directs` | — | Config singleton. |
| `Role` / `ModelHasRole` | `roles` / `model_has_roles` | `Role::modelHasRole()` hasMany; `ModelHasRole::role()`/`user()` | Modelos Eloquent **propios** que se superponen a las tablas de Spatie Permission, para poder hacer joins/eager-loading normales sobre roles además de usar la API del paquete. |

## Reglas de negocio no obvias

- **Carrito**: `CartTrait::totalAmount()` recorre las líneas del carrito sumando `price * units` usando el **precio congelado al agregar**, no el precio actual del producto — protege al cliente de subidas de precio a mitad de compra.
- **Sistema de estrellas**: no promedia calificaciones; `product_starts` es un histograma (una columna por valor de estrella) y se muestra la moda (la calificación más votada).
- **Stock reactivo**: se descuenta al añadir al carrito (reserva optimista) y se restaura al quitar del carrito, cancelar el pedido o borrar una orden desde el admin. No se descuenta "al pagar" — ver riesgo asociado en [07-deuda-tecnica.md](07-deuda-tecnica.md).
- **Flujo de compra**: `carts` (temporal) → al confirmar checkout se crea `user_orders` + líneas `user_purchased_products` (snapshot inmutable de producto/precio/unidades) → se borran las filas de `carts`.
- **Tarifas de transporte**: cada combinación provincia+municipio tiene una tarifa fija (`rate_transportations.amount`), sin variar por peso, distancia o producto; se aplica en el checkout solo si el método de entrega es "a domicilio".
- **Soft deletes** en `users`, `user_contacts`, `categories`, `subcategories`, `branches`, `products`: permite desactivar proveedores/productos/usuarios sin perder el historial de pedidos, ya que `user_purchased_products` guarda un snapshot inmutable independiente de si el producto o proveedor sigue activo.
- **Seeders demo**: crean roles, un usuario `administrator` (ver README para credenciales), datos geográficos, métodos de entrega, estados de orden, la fila singleton de `upagos_directs`, un catálogo de muestra (3 branches demo con categorías/productos), sliders del home, y un `DemoSalesSeeder` que genera clientes con pedidos aleatorios para poblar reportes.
