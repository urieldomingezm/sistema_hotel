<?php
class BootstrapNavbar
{
    private $brand;
    private $menuItems;
    private $searchEnabled;

    public function __construct($brand = 'Hotel Inventory')
    {
        $this->brand = $brand;
        $this->searchEnabled = true;
        $this->initializeMenu();
    }

    private function initializeMenu()
    {
        $this->menuItems = [
            [
                'text' => 'Inicio',
                'icon' => 'fas fa-house',
                'link' => 'index.php?page=Inicio'
            ],
            [
                'text' => 'Inventory',
                'icon' => 'fas fa-boxes',
                'submenu' => [
                    ['text' => 'Computadoras', 'icon' => 'fas fa-laptop', 'link' => 'index.php?page=Gestion computadoras'],
                    ['text' => 'Ubicaciones', 'icon' => 'fas fa-map-marker-alt', 'link' => 'index.php?page=Gestion ubicaciones'],
                    ['text' => 'Categories', 'icon' => 'fas fa-tags', 'link' => 'index.php?page=categories']
                ]
            ],
            [
                'text' => 'Reports',
                'icon' => 'fas fa-chart-bar',
                'submenu' => [
                    ['text' => 'Daily Report', 'icon' => 'fas fa-calendar-day', 'link' => 'index.php?page=daily-report'],
                    ['text' => 'Monthly Report', 'icon' => 'fas fa-calendar-alt', 'link' => 'index.php?page=monthly-report']
                ]
            ],
            [
                'text' => 'Usuario',
                'icon' => 'fas fa-user',
                'submenu' => [
                    ['text' => 'Perfil de usuario', 'icon' => 'fas fa-user-circle', 'link' => 'index.php?page=daily-report'],
                    ['text' => 'Cerrar session', 'icon' => 'fas fa-sign-out-alt', 'link' => 'index.php?page=monthly-report']
                ]
            ]
        ];
    }

    public function render()
    {
?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:  #1B396A;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><?php echo $this->brand; ?></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php $this->renderMenuItems(); ?>
                    </ul>

                    <?php if ($this->searchEnabled) $this->renderSearchForm(); ?>

                </div>
            </div>
        </nav>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php
        $this->renderStyles();
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

    private function renderSingleItem($item)
    {
    ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $item['link']; ?>">
                <i class="<?php echo $item['icon']; ?> me-1"></i> <?php echo $item['text']; ?>
            </a>
        </li>
    <?php
    }

    private function renderDropdownItem($item)
    {
    ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="<?php echo $item['icon']; ?> me-1"></i> <?php echo $item['text']; ?>
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

    private function renderSearchForm()
    {
    ?>
        <form class="d-flex" action="index.php" method="GET">
            <input class="form-control me-2" type="search" name="q" placeholder="Search...">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
    <?php
    }

    private function renderStyles()
    {
    ?>
        <style>
            .navbar {
                box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
                padding: 0.8rem 1rem;
            }

            .nav-link i {
                font-size: 1.2rem;
                width: 25px;
                text-align: center;
                margin-right: 8px;
            }

            .dropdown-item i {
                font-size: 1.1rem;
                width: 25px;
                text-align: center;
            }

            .navbar-brand {
                font-size: 1.4rem;
                font-weight: 500;
            }

            .dropdown-item {
                padding: 0.7rem 1.2rem;
            }

            .dropdown-item:hover {
                background-color: #f8f9fa;
            }

            .form-control:focus {
                border-color: #80bdff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
            }

            .fa-user-circle {
                font-size: 1.5rem;
            }

            @media (max-width: 768px) {
                .nav-link i {
                    width: 20px;
                    margin-right: 10px;
                }
            }
        </style>

        <script>
            function confirmLogout() {
                if (confirm('¿Estás seguro que deseas cerrar sesión?')) {
                    window.location.href = '/private/procesos/logout.php';
                }
            }
        </script>
<?php
    }
}

// Usage
$navbar = new BootstrapNavbar('Iberostar Selection Playa Mita | Gestión de Inventarios');
$navbar->render();
?>