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
                'icon' => 'fas fa-home',
                'text' => 'Inicio',
                'link' => 'index.php?page=Inicio'
            ],
            'tablas' => [
                'icon' => 'fas fa-table',
                'text' => 'Tablas',
                'submenu' => [
                    ['icon' => 'fas fa-laptop', 'text' => 'Tabla de Computadoras', 'link' => 'index.php?page=Gestion computadoras'],
                    ['icon' => 'fas fa-exchange-alt', 'text' => 'Tabla de Movimientos', 'link' => '#'],
                    ['icon' => 'fas fa-map-marker-alt', 'text' => 'Tabla de Ubicaciones', 'link' => 'index.php?page=Gestion ubicaciones'],
                    ['icon' => 'fas fa-tags', 'text' => 'Tabla de Categorías', 'link' => '#']
                ]
            ],
            'crear' => [
                'icon' => 'fas fa-plus-circle',
                'text' => 'Crear Registro',
                'submenu' => [
                    ['icon' => 'fas fa-desktop', 'text' => 'Registrar Computadora', 'link' => '#'],
                    ['icon' => 'fas fa-arrows-alt', 'text' => 'Registrar Movimiento', 'link' => '#'],
                    ['icon' => 'fas fa-map-pin', 'text' => 'Registrar Ubicación', 'link' => '#'],
                    ['icon' => 'fas fa-tag', 'text' => 'Registrar Categoría', 'link' => '#']
                ]
            ]
        ];
    }

    public function renderNavbar()
    {
?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                    <i class="fas fa-sign-out-alt"></i> Salir
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
                padding: 0.8rem 1rem;
                font-size: 1rem;
                font-weight: 500;
                text-decoration: none;
                background: 0 0;
                border: 0;
                transition: all 0.3s ease;
                border-radius: 5px;
                margin: 2px 0;
            }

            .bg-pantone {
                --bs-bg-opacity: 1;
                background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .dropdown-menu {
                background: #ffffff;
                border: none;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .nav-links:hover {
                background-color: rgba(255, 255, 255, 0.15);
                transform: translateX(5px);
                cursor: pointer;
            }

            .offcanvas {
                --bs-offcanvas-transition: transform 0.3s ease-in-out;
            }

            .btn-close {
                opacity: 1;
                transition: transform 0.2s;
            }

            .btn-close:hover {
                transform: rotate(90deg);
                opacity: 1;
            }

            .dropdown-item:hover {
                background-color: #1e3c72;
                color: white;
            }

            .dropdown-item {
                padding: 0.8rem 1rem;
                transition: all 0.3s ease;
            }

            .dropdown-item:hover {
                background-color: #1B396A;
                color: white;
                transform: translateX(5px);
            }

            .dropdown-menu {
                border: none;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            }

            .btn-danger {
                transition: all 0.3s ease;
            }

            .btn-danger:hover {
                transform: scale(1.05);
            }

            .form-control {
                border-radius: 20px;
            }

            .btn-outline-light {
                border-radius: 20px;
                padding: 0.375rem 1.5rem;
            }
        </style>
    <?php
    }

    private function renderScripts()
    {
    ?>
        <script>
            // Add this at the beginning
            document.addEventListener('DOMContentLoaded', function() {
                const dropdownItems = document.querySelectorAll('.dropdown-item');
                const offcanvas = document.getElementById('offcanvasNavbarLight');
                const bsOffcanvas = new bootstrap.Offcanvas(offcanvas);

                dropdownItems.forEach(item => {
                    item.addEventListener('click', () => {
                        bsOffcanvas.hide();
                    });
                });
            });

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