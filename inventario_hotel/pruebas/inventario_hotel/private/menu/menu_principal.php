<?php
class NavigationMenu
{
    private $menuItems;
    private $brandName;

    public function __construct()
    {
        $this->brandName = "Iberostar Selection Playa Mita | Gestion de Inventarios";
        $this->initializeMenuItems();
    }

    private function initializeMenuItems()
    {
        $this->menuItems = [
            'inicio' => [
                'icon' => 'bi bi-box-seam',
                'text' => 'Inicio',
                'link' => 'index.php?page=Inicio'
            ],
            'tablas' => [
                'icon' => 'bi bi-table',
                'text' => 'Tablas',
                'submenu' => [
                    ['icon' => 'bi bi-pc-display', 'text' => 'Tabla de Computadoras', 'link' => 'index.php?page=Gestion computadoras'],
                    ['icon' => 'bi bi-arrow-left-right', 'text' => 'Tabla de Movimientos', 'link' => '#'],
                    ['icon' => 'bi bi-geo-alt-fill', 'text' => 'Tabla de Ubicaciones', 'link' => 'index.php?page=Gestion ubicaciones'],
                    ['icon' => 'bi bi-tags-fill', 'text' => 'Tabla de Categorías', 'link' => '#']
                ]
            ],
            'crear' => [
                'icon' => 'bi bi-plus-circle-fill',
                'text' => 'Crear Registro',
                'submenu' => [
                    ['icon' => 'bi bi-pc', 'text' => 'Registrar Computadora', 'link' => '#'],
                    ['icon' => 'bi bi-journal-arrow-up', 'text' => 'Registrar Movimiento', 'link' => '#'],
                    ['icon' => 'bi bi-geo-fill', 'text' => 'Registrar Ubicación', 'link' => '#'],
                    ['icon' => 'bi bi-tags', 'text' => 'Registrar Categoría', 'link' => '#']
                ]
            ]
        ];
    }

    public function renderNavbar()
    {
?>
        <nav class="navbar navbar-light bg-pantone" aria-label="Light offcanvas navbar">
            <div class="container-fluid">
                <div class="d-flex justify-content-between w-100">
                    <a class="navbar-breands"><strong class="SII"><?php echo $this->brandName; ?></strong></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbarLight" aria-controls="offcanvasNavbarLight">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <?php $this->renderOffcanvasMenu(); ?>
            </div>
        </nav>
    <?php
        $this->renderStyles();
        $this->renderScripts();
    }

    private function renderOffcanvasMenu()
    {
    ?>
        <div class="offcanvas offcanvas-end bg-pantone" tabindex="-1" id="offcanvasNavbarLight">
            <div class="offcanvas-header justify-content-center position-relative">
                <button type="button" class="btn-close position-absolute btn-close-white"
                    style="top: 20px; right: 20px;" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <?php
                    $this->renderSearchForm();
                    $this->renderMenuItems();
                    $this->renderLogoutButton();
                    ?>
                </ul>
            </div>
        </div>
    <?php
    }

    private function renderSearchForm()
    {
    ?>
        <form class="d-flex" action="index.php" method="GET">
            <input class="form-control me-2" type="search" name="q" placeholder="Buscar...">
            <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>
        <br>
    <?php
    }

    private function renderMenuItems()
    {
        foreach ($this->menuItems as $item) {
            if (isset($item['submenu'])) {
                $this->renderDropdownItem($item);
            } else {
                $this->renderSingleItem($item);
            }
        }
    }

    private function renderDropdownItem($item)
    {
    ?>
        <li class="nav-item dropdown">
            <a class="nav-links dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <strong><i class="<?php echo $item['icon']; ?> me-1"></i> <?php echo $item['text']; ?></strong>
            </a>
            <ul class="dropdown-menu">
                <?php foreach ($item['submenu'] as $subItem): ?>
                    <li>
                        <a class="dropdown-item" href="<?php echo $subItem['link']; ?>">
                            <i class="<?php echo $subItem['icon']; ?> me-1"></i> <?php echo $subItem['text']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php
    }

    private function renderSingleItem($item)
    {
    ?>
        <li class="nav-item">
            <a class="nav-links" href="<?php echo $item['link']; ?>">
                <strong><i class="<?php echo $item['icon']; ?> me-1"></i> <?php echo $item['text']; ?></strong>
            </a>
        </li>
    <?php
    }

    private function renderLogoutButton()
    {
    ?>
        <li class="nav-item">
            <a class="nav-links">
                <button class="btn btn-danger" href="javascript:void(0);" onclick="showLogoutModal();">
                    <i class="bi bi-box-arrow-left"></i> Salir
                </button>
            </a>
        </li>
    <?php
    }

    private function renderStyles()
    {
    ?>
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
    <?php
    }

    private function renderScripts()
    {
    ?>
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
                        window.location.href = '/private/procesos/logout.php';
                    }
                });
            }
        </script>
<?php
    }
}

// Initialize and render the menu
$menu = new NavigationMenu();
$menu->renderNavbar();
?>