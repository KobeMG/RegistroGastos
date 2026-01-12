# 💰 GastosPro - Sistema de Control Financiero Personal

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

**Una aplicación web moderna y elegante para el control de gastos e ingresos personales**

[Demo en Vivo](https://controlgastos.free.nf/) | [Reportar Bug](https://github.com/KobeMG/RegistroGastos/issues) | [Solicitar Funcionalidad](https://github.com/KobeMG/RegistroGastos/issues)

</div>

---

## 📋 Descripción

**GastosPro** es una aplicación web completa desarrollada con **CodeIgniter 4** que permite a los usuarios gestionar sus finanzas personales de manera eficiente. Con una interfaz moderna y responsiva, los usuarios pueden registrar gastos, administrar ingresos ordinarios y extraordinarios, y visualizar su situación financiera a través de un dashboard interactivo.

### ✨ Características Principales

- 🔐 **Sistema de Autenticación Seguro**
  - Registro de usuarios con validación
  - Login con protección CSRF
  - Gestión de sesiones seguras

- 💸 **Gestión de Gastos**
  - CRUD completo de gastos
  - Categorización de gastos
  - Registro con fecha y descripción
  - Edición y eliminación con confirmación

- 💵 **Administración de Ingresos**
  - Ingresos ordinarios (salarios, rentas)
  - Ingresos extraordinarios (bonos, premios)
  - Historial completo de ingresos
  - Cálculo automático de totales

- 📊 **Dashboard Financiero**
  - Resumen visual de ingresos totales
  - Total de gastos del período
  - Balance financiero en tiempo real
  - Interfaz intuitiva con indicadores visuales

- 👤 **Perfil de Usuario**
  - Edición de datos personales
  - Actualización de información de cuenta
  - Gestión centralizada de ingresos

- 🎨 **Diseño Moderno**
  - Interfaz responsiva compatible con dispositivos móviles
  - Diseño limpio y profesional con Bootstrap 5
  - Animaciones y transiciones suaves
  - Alertas interactivas con SweetAlert2

---

## 🚀 Tecnologías Utilizadas

### Backend
- **PHP 8.1+** - Lenguaje de programación del lado del servidor
- **CodeIgniter 4** - Framework PHP MVC moderno y ligero
- **MySQL 8.0+** - Sistema de gestión de base de datos

### Frontend
- **HTML5 & CSS3** - Estructura y estilos
- **Bootstrap 5.3** - Framework CSS responsivo
- **JavaScript (ES6+)** - Interactividad del lado del cliente
- **SweetAlert2** - Alertas y notificaciones elegantes
- **Font Awesome 6.4** - Iconografía moderna

### Seguridad
- **CSRF Protection** - Protección contra ataques Cross-Site Request Forgery
- **Password Hashing** - Encriptación segura de contraseñas
- **Session Management** - Gestión segura de sesiones de usuario

---

## 📦 Instalación

### Requisitos Previos

```bash
- PHP >= 8.1
- MySQL >= 8.0 o MariaDB >= 10.3
- Composer
- Servidor web (Apache/Nginx)
- Extensiones PHP: intl, mbstring, mysqli
```

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/KobeMG/RegistroGastos.git
cd RegistroGastos
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar la base de datos**
```bash
# Crear archivo .env desde .env.example
cp env .env

# Editar .env con tus credenciales de base de datos
database.default.hostname = localhost
database.default.database = tu_base_de_datos
database.default.username = tu_usuario
database.default.password = tu_contraseña
database.default.DBDriver = MySQLi
```

4. **Configurar la URL base**
```bash
# En .env, configurar la URL de tu aplicación
app.baseURL = 'http://localhost:8080/'
# Para producción con SSL:
app.baseURL = 'https://tu-dominio.com/'
```

5. **Ejecutar migraciones** (si las tienes configuradas)
```bash
php spark migrate
```

6. **Iniciar el servidor de desarrollo**
```bash
php spark serve
```

7. **Acceder a la aplicación**
```
http://localhost:8080
```

---

## 🗂️ Estructura del Proyecto

```
RegistroGastos/
├── app/
│   ├── Config/
│   │   ├── App.php           # Configuración principal
│   │   ├── Database.php      # Configuración de BD
│   │   ├── Routes.php        # Definición de rutas
│   │   └── Security.php      # Configuración de seguridad
│   ├── Controllers/
│   │   ├── Auth.php          # Autenticación
│   │   ├── Home.php          # Gestión de gastos
│   │   ├── Perfil.php        # Perfil de usuario
│   │   └── DashboardFinanciero.php  # Dashboard
│   ├── Models/
│   │   ├── UsuarioModel.php
│   │   ├── GastoModel.php
│   │   ├── IngresoModel.php
│   │   └── CategoriaModel.php
│   └── Views/
│       ├── auth/             # Vistas de login/registro
│       ├── dashboard_financiero/
│       ├── perfil/
│       └── layouts/          # Plantillas base
├── public/
│   ├── css/
│   │   └── login.css        # Estilos personalizados
│   └── index.php            # Punto de entrada
├── writable/                # Logs y caché
└── composer.json
```

---

## 🎯 Uso

### 1. Registro de Usuario
- Accede a `/registro` o haz clic en "Crea una cuenta aquí"
- Completa el formulario con tu nombre, email y contraseña
- Inicia sesión con tus credenciales

### 2. Gestión de Gastos
- Desde el dashboard principal, haz clic en "Registrar Nuevo Gasto"
- Selecciona la categoría, monto, descripción y fecha
- Los gastos aparecerán en la tabla principal
- Puedes editar o eliminar gastos existentes

### 3. Administración de Ingresos
- Ve a tu perfil (`/perfil`)
- Agrega ingresos ordinarios (salarios mensuales)
- Registra ingresos extraordinarios (bonos, premios)
- Visualiza el total consolidado

### 4. Dashboard Financiero
- Accede a `/dashboard-financiero`
- Visualiza el resumen de ingresos totales
- Revisa tus gastos acumulados
- Observa tu balance financiero actual

---

## 🔒 Seguridad

Este proyecto implementa múltiples capas de seguridad:

- ✅ **Tokens CSRF** en todos los formularios
- ✅ **Validación de datos** en cliente y servidor
- ✅ **Encriptación de contraseñas** con algoritmos modernos
- ✅ **Protección contra inyección SQL** mediante consultas preparadas
- ✅ **Sanitización de inputs** para prevenir XSS
- ✅ **Gestión segura de sesiones**
- ✅ **Soporte SSL/HTTPS** para conexiones seguras

---

## 🌐 Despliegue en Producción

### Configuración Recomendada

1. **Habilitar SSL/HTTPS** en tu hosting
2. **Actualizar baseURL** a tu dominio con HTTPS:
```php
// app/Config/App.php
public string $baseURL = 'https://tu-dominio.com/';
```

3. **Configurar entorno de producción**:
```bash
# En .env
CI_ENVIRONMENT = production
```

4. **Optimizar para producción**:
```bash
# Deshabilitar toolbar de debug
# En app/Config/Filters.php, remover 'toolbar' de $required['after']
```

---

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Si deseas mejorar este proyecto:

1. Fork el repositorio
2. Crea una rama para tu funcionalidad (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.

---

## 👨‍💻 Autor

**Kobe MG**

- GitHub: [@KobeMG](https://github.com/KobeMG)
- Demo: [https://controlgastos.free.nf/](https://controlgastos.free.nf/)

---

## 🙏 Agradecimientos

- [CodeIgniter 4](https://codeigniter.com/) - Framework PHP
- [Bootstrap](https://getbootstrap.com/) - Framework CSS
- [SweetAlert2](https://sweetalert2.github.io/) - Alertas elegantes
- [Font Awesome](https://fontawesome.com/) - Iconos

---

<div align="center">

**⭐ Si te ha gustado este proyecto, considera darle una estrella ⭐**

Hecho con ❤️ por Kobe MG

</div>

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
