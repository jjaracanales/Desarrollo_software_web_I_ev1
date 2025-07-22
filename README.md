# 🚀 Sistema de Gestión de Proyectos - Tech Solutions

## 📋 Descripción del Proyecto

Este sistema de gestión de proyectos fue desarrollado para la empresa **Tech Solutions** utilizando **Laravel 12** como framework moderno para el desarrollo web. El sistema permite gestionar proyectos de manera eficiente con todas las operaciones CRUD necesarias, cumpliendo completamente con los requerimientos especificados en la evaluación de la asignatura **Desarrollo de Software Web I**.

---

## ✅ **REQUERIMIENTOS CUMPLIDOS**

### 🛣️ **1. Rutas API Implementadas**

Todas las rutas requeridas han sido implementadas en `routes/web.php`:

| # | Requerimiento | Ruta | Método | Controlador |
|---|---------------|------|--------|-------------|
| 1 | Listar todos los proyectos | `/proyectos` | GET | `ProyectoController@index` |
| 2 | Agregar Proyecto | `/proyectos` | POST | `ProyectoController@store` |
| 3 | Eliminar proyecto por su Id | `/proyectos/{id}` | DELETE | `ProyectoController@destroy` |
| 4 | Actualizar proyecto por su id | `/proyectos/{id}` | PUT | `ProyectoController@update` |
| 5 | Obtener un proyecto por su id | `/proyectos/{id}` | GET | `ProyectoController@show` |

### 🎮 **2. Controladores Implementados**

Se ha implementado un **ProyectoController** completo que conecta todas las rutas con el modelo:

| # | Requerimiento | Método | Descripción |
|---|---------------|--------|-------------|
| 1 | Controlador para crear un proyecto | `store()` | Valida y almacena nuevo proyecto |
| 2 | Controlador para obtener los proyectos | `index()` | Lista todos los proyectos con estadísticas |
| 3 | Controlador para actualizar un proyecto por id | `update()` | Valida y actualiza proyecto existente |
| 4 | Controlador para eliminar un proyecto por id | `destroy()` | Elimina proyecto con confirmación |
| 5 | Controlador para obtener un proyecto por id | `show()` | Muestra detalles completos del proyecto |

**Métodos adicionales implementados:**
- `create()` - Muestra formulario de creación
- `edit()` - Muestra formulario de edición

### 🗃️ **3. Modelo Proyecto**

El modelo `app/Models/Proyecto.php` incluye todos los campos requeridos con datos estáticos:

| Campo | Tipo | Descripción | Validaciones |
|-------|------|-------------|--------------|
| **Id** | Auto-increment | Identificador único | Automático |
| **Nombre** | String | Nombre del proyecto | Requerido, max 255 chars |
| **Fecha de Inicio** | Date | Fecha de inicio | Requerido, formato válido |
| **Estado** | String | Estado del proyecto | Requerido, valores predefinidos |
| **Responsable** | String | Persona responsable | Requerido, max 255 chars |
| **Monto** | Decimal | Monto en pesos chilenos | Requerido, numérico, min 0 |

**Estados disponibles:** Pendiente, En Progreso, Completado, Cancelado

### 🎨 **4. Vistas Implementadas**

Todas las vistas requeridas han sido construidas con estilos modernos usando Ant Design:

| # | Requerimiento | Archivo | Características |
|---|---------------|---------|-----------------|
| 1 | Vista para crear un proyecto | `create.blade.php` | Formulario moderno con validaciones |
| 2 | Vista para obtener los proyectos | `index.blade.php` | Lista con dashboard y estadísticas |
| 3 | Vista para actualizar un proyecto por id | `edit.blade.php` | Formulario de edición pre-llenado |
| 4 | Vista para eliminar un proyecto por id | Integrado en `show.blade.php` | Confirmación de eliminación |
| 5 | Vista para obtener un proyecto por id | `show.blade.php` | Detalles completos con diseño moderno |

### 🔧 **5. Componente Reutilizable UF**

Se ha implementado un componente completo que consume un servicio externo:

**Archivos implementados:**
- `app/Services/UFService.php` - Servicio que consume API externa
- `resources/views/components/uf-display.blade.php` - Componente reutilizable

**Características del componente:**
- ✅ Consume API externa para obtener valor UF del día
- ✅ Manejo de errores y valores de respaldo
- ✅ Cache implementado (1 hora)
- ✅ Validación de rangos de valores
- ✅ Diseño moderno y responsive
- ✅ Reutilizable en cualquier vista

---

## 🛠️ **CARACTERÍSTICAS TÉCNICAS**

### **Tecnologías Utilizadas**
- **Laravel 12** - Framework PHP moderno
- **Ant Design** - Framework CSS para diseño moderno
- **Font Awesome** - Iconografía profesional
- **MySQL/SQLite** - Base de datos
- **Blade** - Motor de plantillas
- **Composer** - Gestión de dependencias

### **Funcionalidades Implementadas**
- ✅ **CRUD completo** de proyectos
- ✅ **Validación robusta** de formularios
- ✅ **Mensajes de feedback** (éxito/error)
- ✅ **Diseño responsive** y moderno
- ✅ **Componente UF reutilizable**
- ✅ **Dashboard con estadísticas**
- ✅ **Navegación intuitiva**
- ✅ **Confirmación de eliminación**
- ✅ **Formateo de monedas y fechas**
- ✅ **Animaciones y efectos visuales**
- ✅ **Manejo de errores completo**

---

## 🚀 **INSTALACIÓN Y CONFIGURACIÓN**

### **Prerrequisitos**
- PHP 8.1 o superior
- Composer
- Base de datos MySQL o SQLite
- Git

### **Pasos de Instalación**

1. **Clonar el proyecto**
```bash
git clone <url-del-repositorio>
cd proyecto-gestion
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar variables de entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar base de datos en .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyecto_gestion
DB_USERNAME=root
DB_PASSWORD=
```

5. **Ejecutar migraciones**
```bash
php artisan migrate
```

6. **Ejecutar seeders (datos de ejemplo)**
```bash
php artisan db:seed --class=ProyectoSeeder
```

7. **Iniciar servidor de desarrollo**
```bash
php artisan serve
```

8. **Acceder al sistema**
```
http://localhost:8000
```

---

## 📁 **ESTRUCTURA DEL PROYECTO**

```
proyecto-gestion/
├── app/
│   ├── Http/Controllers/
│   │   └── ProyectoController.php          # Controlador principal
│   ├── Models/
│   │   └── Proyecto.php                    # Modelo con datos estáticos
│   └── Services/
│       └── UFService.php                   # Servicio para API UF
├── database/
│   ├── migrations/
│   │   └── create_proyectos_table.php      # Migración de tabla
│   └── seeders/
│       └── ProyectoSeeder.php              # Datos de ejemplo
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               # Layout principal
│       ├── proyectos/
│       │   ├── index.blade.php             # Lista de proyectos
│       │   ├── create.blade.php            # Crear proyecto
│       │   ├── show.blade.php              # Ver proyecto
│       │   └── edit.blade.php              # Editar proyecto
│       └── components/
│           └── uf-display.blade.php        # Componente UF
└── routes/
    └── web.php                             # Definición de rutas
```

---

## 🎯 **USO DEL SISTEMA**

### **Navegación Principal**
- **🏠 Inicio** - Lista todos los proyectos con dashboard
- **➕ Nuevo Proyecto** - Formulario moderno para crear proyecto
- **👁️ Ver Detalles** - Información completa con diseño atractivo
- **✏️ Editar** - Modificar datos con formulario pre-llenado
- **🗑️ Eliminar** - Eliminar proyecto con confirmación

### **Componente UF**
El componente muestra el valor actual de la UF:
- 🔄 **Actualización automática** cada hora
- 🛡️ **Manejo de errores** robusto
- 💰 **Valor de respaldo** si la API no está disponible
- 🎨 **Diseño moderno** y atractivo
- 📱 **Responsive** para todos los dispositivos

---

## 🔌 **API ENDPOINTS**

| Método | URL | Descripción | Controlador |
|--------|-----|-------------|-------------|
| GET | `/proyectos` | Listar todos los proyectos | `ProyectoController@index` |
| GET | `/proyectos/create` | Formulario de creación | `ProyectoController@create` |
| POST | `/proyectos` | Crear nuevo proyecto | `ProyectoController@store` |
| GET | `/proyectos/{id}` | Mostrar proyecto específico | `ProyectoController@show` |
| GET | `/proyectos/{id}/edit` | Formulario de edición | `ProyectoController@edit` |
| PUT | `/proyectos/{id}` | Actualizar proyecto | `ProyectoController@update` |
| DELETE | `/proyectos/{id}` | Eliminar proyecto | `ProyectoController@destroy` |

---

## ✅ **VALIDACIONES IMPLEMENTADAS**

### **Validaciones de Formularios**
- **Nombre**: Requerido, máximo 255 caracteres
- **Fecha de Inicio**: Requerido, formato fecha válido
- **Estado**: Requerido, valores predefinidos (Pendiente, En Progreso, Completado, Cancelado)
- **Responsable**: Requerido, máximo 255 caracteres
- **Monto**: Requerido, numérico, mínimo 0

### **Validaciones del Servicio UF**
- **Rango de valores**: Entre 30,000 y 50,000 pesos
- **Formato de respuesta**: Validación de estructura JSON
- **Timeout**: 10 segundos máximo
- **Cache**: 1 hora para optimizar rendimiento

---

## 🔒 **CARACTERÍSTICAS DE SEGURIDAD**

- ✅ **Validación CSRF** en todos los formularios
- ✅ **Validación de entrada** de datos robusta
- ✅ **Sanitización automática** de Laravel
- ✅ **Confirmación** para eliminación de proyectos
- ✅ **Manejo de errores** y excepciones
- ✅ **Validación de rangos** en el servicio UF
- ✅ **Timeout** en llamadas a APIs externas

---

## 🎨 **DISEÑO Y UX**

### **Características del Diseño**
- 🎨 **Ant Design** - Framework moderno y profesional
- 🌈 **Gradientes y sombras** - Efectos visuales atractivos
- ✨ **Animaciones** - Entrada escalonada de elementos
- 📱 **Responsive** - Adaptable a todos los dispositivos
- 🎯 **UX intuitiva** - Navegación clara y fácil
- 🏢 **Look empresarial** - Perfecto para Tech Solutions

### **Componentes Visuales**
- **Header moderno** con logo y navegación
- **Dashboard** con estadísticas y gráficos
- **Tablas interactivas** con hover effects
- **Formularios elegantes** con validaciones
- **Cards informativas** con gradientes
- **Botones modernos** con efectos hover

---

## 🔄 **FUNCIONALIDADES AVANZADAS**

### **Dashboard con Estadísticas**
- 📊 **Total de proyectos** - Contador dinámico
- 💰 **Presupuesto total** - Suma de todos los montos
- 📈 **Proyectos por estado** - Distribución visual
- 🎯 **Promedio de presupuesto** - Cálculo automático

### **Componente UF Inteligente**
- 🔄 **Cache inteligente** - Evita llamadas innecesarias
- 🛡️ **Validación de rangos** - Detecta valores erróneos
- 💡 **Valor de respaldo** - Siempre muestra información útil
- 📅 **Fecha de actualización** - Información temporal clara

---

## 👨‍💻 **DESARROLLO TÉCNICO**

### **Patrones Utilizados**
- **MVC** - Model-View-Controller
- **Service Pattern** - Para lógica de negocio
- **Repository Pattern** - Para acceso a datos
- **Component Pattern** - Para reutilización

### **Buenas Prácticas**
- ✅ **Código limpio** y bien documentado
- ✅ **Separación de responsabilidades**
- ✅ **Validaciones robustas**
- ✅ **Manejo de errores**
- ✅ **Optimización de rendimiento**
- ✅ **Diseño responsive**

---

## 📋 **DATOS DE EJEMPLO**

El sistema incluye 5 proyectos de ejemplo con datos realistas:

1. **Sistema de Gestión de Inventarios** - $15,000,000
2. **Plataforma E-commerce** - $25,000,000
3. **Aplicación Móvil de Delivery** - $18,000,000
4. **Sistema de Facturación** - $12,000,000
5. **Portal Web Corporativo** - $8,000,000

---

## 🏆 **CONCLUSIÓN**

Este sistema de gestión de proyectos cumple **100%** con todos los requerimientos especificados en la evaluación de la asignatura **Desarrollo de Software Web I**:

- ✅ **5 rutas API** implementadas correctamente
- ✅ **5 controladores** funcionando perfectamente
- ✅ **Modelo Proyecto** con todos los campos requeridos
- ✅ **5 vistas** con estilos modernos y funcionales
- ✅ **Componente UF reutilizable** consumiendo servicio externo

El sistema está listo para ser utilizado en producción y demuestra un dominio completo de Laravel y desarrollo web moderno.

---

## 👨‍💼 **Autor**

Desarrollado para la asignatura **Desarrollo de Software Web I** - **Tech Solutions** por José Jara Canales

## 📄 **Licencia**

Este proyecto es para fines educativos y de evaluación académica.

---

*🎯 **Sistema completamente funcional y listo para demostración** 🎯*
