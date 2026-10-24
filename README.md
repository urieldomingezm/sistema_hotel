<div align="center">

# 🏨 Sistema de Inventario para Hotel

Aplicación web para controlar el inventario de equipos de cómputo de un hotel: qué equipo hay, en qué ubicación está y qué movimientos ha tenido.

![PHP](https://img.shields.io/badge/PHP_8.2-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL_8-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap_5-7952B3?style=flat-square&logo=bootstrap&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white)
![License](https://img.shields.io/badge/licencia-MIT-green?style=flat-square)

</div>

## ✨ Funcionalidades

- **Registro e inicio de sesión** con contraseñas cifradas (`password_hash` / `password_verify`).
- **Equipos**: alta, edición y consulta de computadoras.
- **Ubicaciones**: dónde está cada equipo dentro del hotel.
- **Categorías** de equipos.
- **Movimientos**: historial de asignaciones, cambios de ubicación, mantenimientos y bajas.
- Menú dinámico con secciones de inventario, reportes y perfil.

## 🛠️ Stack

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.2 (PDO) + `vlucas/phpdotenv` |
| Base de datos | MySQL 8 |
| Frontend | Bootstrap 5, Bootstrap Icons, Boxicons, SweetAlert2 |
| Infraestructura | Docker Compose (Apache, MySQL, phpMyAdmin) |

## 📁 Estructura

```
.
├── database/
│   └── schema.sql        # Tablas y datos de ejemplo (se carga solo en Docker)
├── gestion/              # Módulos del inventario (equipos, ubicaciones, etc.)
├── private/
│   ├── conexion/         # Conexión PDO a MySQL
│   ├── menu/             # Menú principal
│   ├── plantillas/       # Header y footer
│   └── procesos/         # Logout y consultas
├── public/assets/        # CSS, JS y librerías de frontend
├── index.php             # Login
├── registrer.php         # Registro de usuarios
├── config.php
├── docker-compose.yml
└── Dockerfile
```

## 🗄️ Modelo de datos

| Tabla | Contenido |
|---|---|
| `equipos` | Computadoras y sus datos |
| `categorias` | Tipos de equipo |
| `ubicaciones` | Áreas del hotel |
| `movimientos` | Asignaciones, traslados, mantenimientos y bajas |
| `login_usuarios` | Usuarios del sistema |

## 🚀 Instalación

**Requisitos:** Docker y Docker Compose.

```bash
git clone https://github.com/urieldomingezm/sistema_hotel.git
cd sistema_hotel
cp .env.example .env                        # cambia la contraseña
docker compose build
docker compose run --rm web composer install
docker compose up -d
```

La base de datos se crea sola al primer arranque con `database/schema.sql`.

| Servicio | URL |
|---|---|
| Aplicación | http://localhost:9090 |
| phpMyAdmin | http://localhost:8081 |

## 🔐 Variables de entorno

| Variable | Descripción |
|---|---|
| `DB_HOST` | Host de MySQL (`db` dentro de Docker) |
| `DB_USER` | Usuario de MySQL |
| `DB_PASSWORD` | Contraseña (también se usa como root de MySQL) |
| `DB_NAME` | Nombre de la base de datos |

## 👤 Autor

**Angel Uriel Domínguez Medina** · [GitHub](https://github.com/urieldomingezm) · [Portafolio](https://cv-uriel-nine.vercel.app/)

## 📄 Licencia

Distribuido bajo la licencia MIT. Consulta [LICENSE](LICENSE).
