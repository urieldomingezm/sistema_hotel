<!--MENU PRINCIPAL-->
<nav class="navbar navbar-light bg-pantone" aria-label="Light offcanvas navbar">
    <div class="container-fluid">
        <!-- Flexbox para alinear elementos -->
        <div class="d-flex justify-content-between w-100">
            <!-- Título alineado a la izquierda -->
            <a class="navbar-breands"><strong class="SII">Iberostar Selection Playa Mita | Gestion de Inventarios</strong></a>

            <!-- Botón de la hamburguesa alineado a la derecha -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarLight"
                aria-controls="offcanvasNavbarLight" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Offcanvas Menu -->
        <div class="offcanvas offcanvas-end bg-pantone" tabindex="-1" id="offcanvasNavbarLight" aria-labelledby="offcanvasNavbarLightLabel">
            <div class="offcanvas-header justify-content-center position-relative">
                <button type="button" class="btn-close position-absolute btn-close-white" style="top: 20px; right: 20px;" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <form class="d-flex mt-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar." aria-label="Search">
                        <button class="btn btn-success" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                    <br>
                    <li class="nav-item">
                        <a class="nav-links" href="index.php">
                            <strong><i class="bi bi-box-seam me-1"></i> Inicio</strong>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-links dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <strong><i class="bi bi-table me-1"></i> Tablas</strong>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"  href="index.php?page=TCP"><i class="bi bi-pc-display me-1"></i> Tabla de Computadoras</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-arrow-left-right me-1"></i> Tabla de Movimientos</a></li>
                            <li><a class="dropdown-item" href="index.php?page=TUB"><i class="bi bi-geo-alt-fill me-1"></i> Tabla de Ubicaciones</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-tags-fill me-1"></i> Tabla de Categorías</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-links dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <strong><i class="bi bi-plus-circle-fill me-1"></i> Crear Registro</strong>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-pc me-1"></i> Registrar Computadora</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-journal-arrow-up me-1"></i> Registrar Movimiento</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-geo-fill me-1"></i> Registrar Ubicación</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-tags me-1"></i> Registrar Categoría</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-links">
                            <button class="btn btn-danger" href="javascript:void(0);" onclick="showLogoutModal();"><i class="bi bi-box-arrow-left"></i> Salir</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba(255, 255, 255, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    .navbar-toggler {
        padding: var(--bs-navbar-toggler-padding-y) var(--bs-navbar-toggler-padding-x);
        font-size: var(--bs-navbar-toggler-font-size);
        line-height: 1;
        color: rgb(0 0 0 / 0%);
        background-color: transparent;
        border: var(--bs-border-width) solid rgb(0 0 0 / 0%);
        border-radius: var(--bs-navbar-toggler-border-radius);
        transition: var(--bs-navbar-toggler-transition);
    }

    @media (max-width: 767px) {
        .SII::before {
            content: "I.S.P.M. | Gestion de Inventarios";
            display: inline-block;
        }

        .SII {
            visibility: hidden;
        }

        .SII::before {
            visibility: visible;
        }

        .navbar-breands {
            overflow-x: hidden;
            width: 100%;
        }
    }


    .nav-links {
        color: rgb(255, 255, 255);
        display: block;
        padding: var(--bs-nav-link-padding-y) var(--bs-nav-link-padding-x);
        font-size: var(--bs-nav-link-font-size);
        font-weight: var(--bs-nav-link-font-weight);
        text-decoration: none;
        background: 0 0;
        border: 0;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
    }

    .navbar-breands {
        color: rgb(255, 255, 255);
        padding-top: var(--bs-navbar-brand-padding-y);
        padding-bottom: var(--bs-navbar-brand-padding-y);
        margin-right: var(--bs-navbar-brand-margin-end);
        font-size: var(--bs-navbar-brand-font-size);
        text-decoration: none;
        white-space: nowrap;
    }

    .dropdown-submenu {
        position: relative;
    }

    .bg-pantone {
        --bs-bg-opacity: 1;
        background-color: #1B396A !important;
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
    }
</style>

<script>
    function showLogoutModal() {
        Swal.fire({
            title: '¿Estás seguro de que deseas cerrar sesión?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Cerrar Sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/inventario_hotel/private/procesos/logout.php';
            }
        });
    }
</script>