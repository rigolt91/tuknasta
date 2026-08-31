# Componentes Livewire

Livewire 2, namespace `App\Http\Livewire`, ~70 componentes. Patrón consistente en todo el proyecto:

- **Listado + modal CRUD**: un componente "listado" (paginado con `WithPagination`) abre modales de Create/Edit/Destroy vía `$this->emit('openModal', 'vista.componente', [...])` (paquete `livewire-ui/modal`, clase base `LivewireUI\Modal\ModalComponent`). Los modales, al terminar, cierran devolviendo un evento al padre: `$this->closeModalWithEvents([Componente::getName() => 'refreshX'])`.
- **Comunicación por eventos** (`$emit`/`$listeners`) es el mecanismo dominante de desacoplamiento, incluso entre árboles de componentes que no se conocen entre sí (ej. `CartComponent::refresh()` notifica a 5 componentes distintos).
- La lógica de negocio compartida vive en traits: `App\Http\Traits\CartTrait` y `ProductStartTrait`.

## Panel admin (`AdminPanel/`)

- **`AdminPanelComponent`** — dashboard con contadores (pedidos por estado, categorías, productos, sucursales, clientes) y 3 gráficos vía `LaravelChart` (pedidos/mes, ventas/mes, productos más vendidos).
- **`NavPanelComponent`** — barra de navegación admin, solo abre modales de creación y de reportes.
- **CRUD estándar** (mismo patrón `XComponent` + `CreateComponent`/`EditComponent`/`DestroyComponent`): `Branch/`, `Category/`, `SubCategory/`, `RateTransportation/`, `User/`.
  - `CategoryComponent`/`RateTransportationComponent` usan `AuthorizesRequests` con las policies.
  - `RateTransportationComponent` filtra por `province_id`; es la tabla usada por el checkout para calcular el costo de envío a domicilio.
  - `User/CreateComponent`/`EditComponent` usan `PasswordValidationRules` de Fortify y `assignRole`/`removeRole` de Spatie; reactivan usuarios soft-eliminados si el email ya existía.
- **`Product/`** — listado filtrable por sucursal/subcategoría/categoría; `setShow()`/`setRecommend()` togglean flags in-place. Create/Edit usan `WithFileUploads`, suben imagen a `products/{sku}/{hash}.jpg` (disk `uploads`), autogeneran `slug`. Edit guarda `previous_price` cuando cambia el precio (para mostrar descuentos).
- **`Slider/SliderComponent`** — un único componente maneja todo el CRUD de banners sin modales separados.
- **`UpagosDirect/UpagosDirectComponent`** — singleton de configuración de la pasarela de pago y datos de contacto/redes sociales.
- **`Order/`** (lógica no trivial):
  - `OrderComponent` — listado filtrable por estado/fecha/método/contacto (scopes de `UserOrder`); genera PDF de todas las órdenes filtradas (dompdf, `streamDownload`).
  - `ShowComponent` — detalle en modal con totales calculados, recupera el contacto de envío aunque esté soft-eliminado (`withTrashed()`), genera PDF individual.
  - `EditComponent` — solo cambia `order_status_id`.
  - `DestroyComponent` — al eliminar una orden, **restaura el stock** de cada producto comprado.
  - `SearchComponent` — modal que abre el formulario de búsqueda de `OrderComponent`.
- **`Reports/`** (lógica no trivial):
  - `DailySales`/`WeeklySales`/`MonthlySales`/`YearSales` — serie temporal desde `UserPurchasedProduct`, calculan `overall_growth` (diferencia absoluta) y `full_percent` (variación % respecto al periodo anterior). Gráficos vía `LaravelChart`.
  - `SalesInTheWeekBySupplier` — ventas por proveedor: `Branch::with('product.userPurchasedProduct')` filtrado por semana (jueves a jueves).
  - `Reports/Components/` — subcomponentes reutilizables: `Orders`, `Products`, `Profits` (agregados en rango), `Graphics` (los 2 gráficos reutilizables), y los 4 `Modal*Sales` (wrappers que abren cada reporte como modal).

## Carrito (`Cart/`)

- **`CartComponent`** — pieza central. Escucha `addProductCart`, `clearCart`, `clearCartAll`, `removeProductCart`, `deleteUserJob`, `restoreProductStock`, `refreshCart`.
  - `addProductCart(Product, units=1)`: valida stock disponible, **reduce el stock inmediatamente** (reserva optimista), crea o incrementa la línea de `Cart`. Sin stock o sin usuario autenticado → abre `error-modal-component`.
  - Al crear una línea nueva dispara `AddProductCart::dispatch($user)` y guarda el `job_id` en `user_job` (para poder cancelarlo con `deleteUserJob()` si la compra se completa antes de que expire).
  - `clearCart`/`clearCartAll`/`removeProductCart` siempre restauran el stock antes de borrar/decrementar.
  - `refresh()` reemite `refreshCartSm`, `refreshCartDetails`, `refreshPayment`, `refreshDelivery`, `refreshConfirm` para sincronizar todos los componentes que muestran el carrito.
- **`CartDetailComponent`** — vista `/cart/cart-details`, usa `CartTrait`, solo `payment()` redirige al paso 1 del checkout.
- **`CartTrait`** (compartido Cart/Payment): `user()` (usuario + contacto preferido), `userCart()`, `totalAmount()` (recalcula desde cero sumando `price*units`), `totalProducts()` (cuenta **líneas**, no unidades — nota: inconsistente con `CartComponent` que en otro punto usa `sum('units')`, ver [07-deuda-tecnica.md](07-deuda-tecnica.md)).

## Pago / Checkout (`Payment/`) — wizard de 3 pasos

1. **`PaymentComponent`** (`/payment`) — si el carrito está vacío redirige al carrito; valida que exista un `contact` seleccionado y avanza.
2. **`DeliveryComponent`** (`/payment/delivery`) — elige `delivery_method` (default 1) y avanza pasando el método como parámetro de ruta.
3. **`ConfirmComponent`** (`/payment/confirm/{method}`) — genera un `order_number` único, calcula `transportation` (tarifa de `RateTransportation` si el método es "a domicilio"), y en `paymentConfirm()` crea el `UserOrder` + líneas `user_purchased_product`, borra el carrito, emite `deleteUserJob`/`refreshCart`, y envía el correo `OrderShipped`.

Detalle completo de cómo se integra esto con la pasarela real de pago (UPagos) en [05-flujo-de-pago.md](05-flujo-de-pago.md).

## Catálogo / Productos (tienda pública)

- **`DashboardComponent`** (raíz) — orquesta el filtrado real del catálogo: escucha `filterProduct` (del `FilterComponent`, vía `SidePanel`) y `orderProducts`; usa los scopes de `Product` (`whereInCategory`, `whereCategory`, `whereName`, `wherePrice`, `show`).
- **`Product/ProductComponent`** — listado paginado simple (20/página), solo por `search`.
- **`Product/FilterComponent`** — vive dentro del `SidePanel`; checkboxes de categoría + rango de precio; emite `filterProduct`.
- **`Product/CardComponent`** / **`CardPreferComponent`** — tarjetas de producto (grilla normal / destacados); emiten `addProductCart`; usan `ProductStartTrait` para las estrellas.
- **`Product/PreferProductComponent`** — productos con `recommend = true`.
- **`Product/ProductDetailComponent`** — página de producto (`/product/{slug}`).
- **`Product/RelatedProductComponent`** — productos de la misma subcategoría.
- **`Category/CardCategoryComponent`** — grilla de categorías visibles.

## Perfil de cliente (`Profile/`)

- **`MyContact/`** — CRUD de direcciones (mismo patrón modal). `setPrefer()` desmarca todas y marca la elegida como preferida, y re-emite `refreshPayment`/`refreshDelivery`/`refreshConfirm` para que el checkout recoja el cambio en caliente. Valida DNI (11 dígitos), teléfono, provincia/municipio; usa policies en Edit/Destroy.
- **`MyOrder/MyOrderComponent`** — historial de pedidos del cliente autenticado (mismos scopes que el admin, forzando `whereUser($user->id)`), reutiliza el modal de detalle/PDF del admin.

## Otros componentes sueltos

- **`ErrorModalComponent`** — modal genérico de error, destino estándar de errores de Cart/Payment/etc.
- **`FooterMenu`** — pie de página con datos de `UpagosDirect::first()` (contacto/redes sociales).
- **`LangApp`** — expone el locale activo; la vista asociada muestra el selector es/en.
- **`NavigationMenuSm`** — widget de carrito compacto para navbar móvil; duplica parte de la carga de `CartComponent`, reemite hacia él en vez de manejar el carrito localmente.
- **`SearchBarComponent`** — barra de búsqueda superior con selector de categoría.
- **`SliderComponent`** (raíz) — banner del home.
- **`WelcomeComponent`** — landing/home, cuenta productos recomendados.
- **`WholesalerComponent`** — formulario de contacto B2B, envía el mail `Wholesaler`.
- **`SidePanel/SidePanel`** — drawer genérico reutilizable: escucha `openPanel(title, component)`/`closePanel` y renderiza dinámicamente el componente indicado (usado hoy solo para `FilterComponent`).

## Observación transversal

Todos los reportes de ventas comparten la misma forma (query agregada por fecha + cálculo de crecimiento período-a-período + gráficos vía `LaravelChart`) — es un candidato natural a extraer a un trait/servicio común si se sigue extendiendo esa área.
