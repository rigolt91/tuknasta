---
name: laravel-inertia-react
description: >
  Implementa aplicaciones full-stack en Laravel usando Inertia.js con React como capa de vistas: controladores que devuelven páginas Inertia en vez de JSON puro o Blade, componentes React por página, formularios con el hook useForm de Inertia, y navegación SPA sin necesidad de una API REST separada ni de duplicar rutas en el cliente. Usa esta skill SIEMPRE que el usuario pida crear o modificar una página Inertia, mencione explícitamente Inertia.js, o quiera usar React dentro de un proyecto Laravel sin separar frontend y backend en dos proyectos. No uses esta skill junto con `laravel-api-rest` en el mismo recurso — Inertia reemplaza la necesidad de una API REST intermedia para las páginas propias de la app.
---

# Laravel + Inertia.js + React

Esta skill cubre el desarrollo full-stack con Inertia.js y React: un solo proyecto Laravel donde los controladores devuelven páginas Inertia (que renderizan un componente React específico con props tipadas) en vez de JSON puro o vistas Blade. No hay API REST intermedia ni un proyecto Next.js separado — el enrutamiento del lado servidor sigue siendo el de Laravel, e Inertia se encarga de que la navegación se sienta como una SPA sin recargar la página completa.

Es un paradigma distinto tanto de `laravel-api-rest` (que expone JSON puro para consumidores externos) como de `laravel-livewire` (que renderiza Blade con estado en servidor). Si el proyecto también expone una API pública para terceros, esa parte sí usa `laravel-api-rest`, pero las páginas propias de la app usan Inertia.

## Principios que debe seguir siempre

1. **El controlador devuelve una página Inertia, no JSON ni una vista Blade.** `return Inertia::render('Products/Index', ['products' => ProductResource::collection($products)]);` — el segundo argumento son las props que recibe el componente React.
2. **Un componente React por página**, ubicado siguiendo la misma estructura que las rutas/controladores (ver `references/estructura-paginas.md`). No mezcles componentes de página con componentes reutilizables de UI en la misma carpeta.
3. **Formularios con el hook `useForm` de Inertia**, no `fetch`/`axios` manual — maneja automáticamente el estado de envío, errores de validación devueltos por Laravel, y el progreso de subida de archivos.
4. **La validación sigue viviendo en Form Requests de Laravel**, igual que en `laravel-api-rest` — Inertia simplemente propaga los errores de validación al componente React de forma automática vía props especiales (`errors`).
5. **Props tipadas end-to-end.** Define un tipo TypeScript para las props de cada página, reflejando exactamente lo que el controlador envía (idealmente generado o mantenido cerca de los API Resources correspondientes, para que no se desincronicen).
6. **Navegación con `<Link>` de Inertia**, no `<a>` plano ni recargas de página completa — así se mantiene el comportamiento de SPA.
7. **Autorización con Policies**, igual que cualquier app Laravel — se verifica en el controlador antes de renderizar la página o ejecutar la acción, no solo se oculta un botón en el componente React.

## Flujo de trabajo

### 1. Entender qué se está construyendo

Si hay documentos previos de la cadena (requisitos, base de datos, diseño UX/UI), léelos para confirmar entidades, campos y pantallas esperadas. El diseño UX/UI es especialmente relevante porque cada pantalla mapea a una página Inertia con su componente React.

### 2. Implementar en el orden correcto

Para una funcionalidad nueva:
1. Migración y modelo (igual que en cualquier app Laravel)
2. Policy si el recurso requiere autorización
3. Form Request(s) para validación de entrada
4. API Resource para dar forma a los datos que se envían como props (mismo patrón que en `laravel-api-rest`, reutilizado aquí para tipar la salida)
5. Controlador que devuelve `Inertia::render()`
6. Ruta (`routes/web.php`, no `api.php` — Inertia usa las rutas web de Laravel)
7. Componente React de la página, con su tipo de props
8. Tests (backend con Pest/PHPUnit, frontend con Vitest + React Testing Library si el proyecto lo tiene configurado)

### 3. Formularios

```tsx
import { useForm } from '@inertiajs/react';

export default function CreateProduct() {
  const { data, setData, post, processing, errors } = useForm({
    name: '',
    price: 0,
  });

  function submit(e: React.FormEvent) {
    e.preventDefault();
    post('/products');
  }

  return (
    <form onSubmit={submit}>
      <input value={data.name} onChange={(e) => setData('name', e.target.value)} />
      {errors.name && <span>{errors.name}</span>}

      <input
        type="number"
        value={data.price}
        onChange={(e) => setData('price', Number(e.target.value))}
      />
      {errors.price && <span>{errors.price}</span>}

      <button type="submit" disabled={processing}>Guardar</button>
    </form>
  );
}
```

- `errors` viene automáticamente de la respuesta de Laravel cuando el Form Request rechaza la validación (422) — no necesitas parsear la respuesta a mano.
- `processing` refleja el estado de envío en curso, útil para deshabilitar el botón sin estado manual adicional.

### 4. Escribir tests junto con el código

- **Backend**: igual que `laravel-api-rest` — Pest/PHPUnit, verificando que el controlador devuelve la página Inertia correcta con las props esperadas (`assertInertia()` del paquete de testing de Inertia para Laravel).
- **Frontend**: Vitest + React Testing Library para componentes de página, mockeando las props tal como Inertia las proveería.

```php
it('muestra la página de productos con los datos del usuario', function () {
    $user = User::factory()->create();
    Product::factory()->for($user)->count(2)->create();

    $this->actingAs($user)
        ->get('/products')
        ->assertInertia(fn (Assert $page) => $page
            ->component('Products/Index')
            ->has('products', 2)
        );
});
```

Consulta `references/convenciones-tests-inertia.md` para más casos.

### 5. Verificar antes de dar por terminado

- Corre los tests de backend y frontend del proyecto.
- Confirma que ninguna página React acceda a datos que debería recibir como prop en vez de fetch manual (romper eso reintroduce la necesidad de una API separada innecesariamente).
- Verifica que la navegación entre páginas use `<Link>`, no recargas completas.

## Referencias

- `references/estructura-paginas.md` — organización de páginas Inertia y componentes compartidos, layouts persistentes.
- `references/props-y-tipos.md` — cómo tipar las props de cada página en TypeScript y mantenerlas sincronizadas con los API Resources del backend.
- `references/convenciones-tests-inertia.md` — estructura de tests de backend (`assertInertia`) y frontend para páginas Inertia.
- `assets/ejemplo-pagina-completa.md` — ejemplo de referencia de una página CRUD completa (controlador → Resource → página Inertia → formulario → tests).
