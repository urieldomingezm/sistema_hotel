<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/rutas.php');
?>

<!-- Loading Screen -->
<div id="loading-screen" class="loading-overlay">
    <div class="loading-content">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h4 class="text-light mt-3">Cargando...</h4>
    </div>
</div>

<style>
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(27, 57, 106, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.3s ease-out;
}

.loading-content {
    text-align: center;
}

.loading-overlay.fade-out {
    opacity: 0;
    pointer-events: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide loading screen after page loads
    window.addEventListener('load', function() {
        const loadingScreen = document.getElementById('loading-screen');
        loadingScreen.classList.add('fade-out');
        setTimeout(() => {
            loadingScreen.style.display = 'none';
        }, 300);
    });
});
</script>

<?php
require_once(TEMPLATES_PATH . 'header.php');
require_once(MENU_PATH . 'menu_principal.php');

// Verify session
if (!isset($_SESSION['id_usuario'])) {
    header("Location: /index.php");
    exit;
}

// Handle search functionality
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $query = strtolower(trim($_GET['q']));
    $pages = [
        'TCP.php' => ['title' => 'Gestion computadoras', 'keywords' => 'gestion de computadoras,pc,equipos,hardware'],
        'TUB.php' => ['title' => 'Gestion ubicaciones', 'keywords' => 'Gestion de ubicaciones para edificiones,edificios'],
        'FO.php' => ['title' => 'Inicio', 'keywords' => 'inicio,dashboard,principal'],
    ];

    $results = [];
    foreach ($pages as $file => $info) {
        $keywords = explode(',', $info['keywords']);
        foreach ($keywords as $keyword) {
            if (strpos($keyword, $query) !== false) {
                $results[] = [
                    'title' => $info['title'],
                    'url' => "index.php?page=" . urlencode($info['title'])
                ];
                break;
            }
        }
    }

    echo '<div class="container mt-4">';
    echo '<div class="card shadow">';
    echo '<div class="card-header bg-primary text-white">';
    echo '<h5 class="mb-0">Resultados para: "' . htmlspecialchars($query) . '"</h5>';
    echo '</div>';
    echo '<div class="card-body">';

    if (!empty($results)) {
        foreach ($results as $result) {
            echo '<div class="d-flex align-items-center p-2 border-bottom">';
            echo '<i class="fas fa-link me-3"></i>';
            echo '<a href="' . $result['url'] . '" class="text-decoration-none">';
            echo '<h6 class="mb-0">' . htmlspecialchars($result['title']) . '</h6>';
            echo '</a>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-muted">No se encontraron resultados.</p>';
    }
    echo '</div></div></div>';
}

// Load page based on GET parameter
if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'Gestion computadoras':
            include 'TCP.php';
            break;
        case 'Gestion ubicaciones':
            include 'TUB.php';
            break;
        case 'Inicio':
            include 'FO.php';
            break;
        case 'GSP':
            include 'GSP.php';
            break;
        case 'GVE':
            include 'GVE.php';
            break;
        case 'GVP':
            include 'GVP.php';
            break;
        default:
            echo "<div class='alert alert-warning'>Página no encontrada</div>";
            header("refresh:3;url=index.php");
    }
} else {
    include 'FO.php';
}

require_once(TEMPLATES_PATH . 'footer.php');
?>