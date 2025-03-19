<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');
require_once(TEMPLATES_PATH . 'plantilla_header.php');
?>

<div class="container-fluid mt-3">
    <!-- Header Section -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card bg-primary text-white shadow-lg border-0">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-building-fill me-3 display-4"></i>
                                <div>
                                    <h1 class="h2 fw-bold mb-1">Sistema de Gestión de Inventario</h1>
                                    <p class="mb-0">Iberostar Selection Playa Mita</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex justify-content-md-end align-items-center">
                                <div class="text-end me-3">
                                    <h6 class="mb-1"><?php echo date('d/m/Y'); ?></h6>
                                    <h5 class="mb-0"><?php echo date('H:i'); ?></h5>
                                </div>
                                <div class="bg-white rounded-circle p-3">
                                    <i class="bi bi-clock-history text-primary fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-3">
        <div class="col-xl-3 col-sm-6">
            <div class="card bg-info text-white h-100 shadow border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Equipos</h6>
                        <h2 class="display-6 mb-0" id="totalEquipos">0</h2>
                    </div>
                    <div class="bg-white p-3 rounded-circle">
                        <i class="bi bi-pc-display text-info fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card bg-success text-white h-100 shadow border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Ubicaciones</h6>
                        <h2 class="display-6 mb-0" id="totalUbicaciones">0</h2>
                    </div>
                    <div class="bg-white p-3 rounded-circle">
                        <i class="bi bi-geo-alt text-success fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card bg-warning text-dark h-100 shadow border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Estados</h6>
                        <h2 class="display-6 mb-0" id="totalEstados">0</h2>
                    </div>
                    <div class="bg-white p-3 rounded-circle">
                        <i class="bi bi-list-check text-warning fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card bg-danger text-white h-100 shadow border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Movimientos</h6>
                        <h2 class="display-6 mb-0" id="totalMovimientos">0</h2>
                    </div>
                    <div class="bg-white p-3 rounded-circle">
                        <i class="bi bi-arrow-left-right text-danger fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card shadow h-100">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle fs-4 me-2"></i>
                        <div>
                            <h5 class="mb-1">Bienvenido(a), <?php echo $_SESSION['usuario_nombre']; ?></h5>
                            <small>Último acceso: <?php echo date('d/m/Y H:i'); ?></small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card bg-light h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3 text-primary">
                                        <i class="bi bi-star-fill text-warning me-2"></i>Acciones Rápidas
                                    </h6>
                                    <div class="d-grid gap-3">
                                        <a href="index.php?page=Gestion computadoras" class="btn btn-primary">
                                            <i class="bi bi-pc-display me-2"></i>Gestionar Equipos
                                        </a>
                                        <a href="index.php?page=Gestion ubicaciones" class="btn btn-success">
                                            <i class="bi bi-geo-alt me-2"></i>Gestionar Ubicaciones
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3 text-primary">
                                        <i class="bi bi-graph-up me-2"></i>Resumen
                                    </h6>
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary rounded-pill me-2">1</span>
                                                <span>Total de equipos registrados</span>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-success rounded-pill me-2">2</span>
                                                <span>Ubicaciones activas</span>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-info rounded-pill me-2">3</span>
                                                <span>Movimientos registrados hoy</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card shadow h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>Estado del Sistema
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white p-2 rounded-circle me-3">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Servicios Activos</h6>
                                    <small class="text-success">Funcionando correctamente</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-info text-white p-2 rounded-circle me-3">
                                    <i class="bi bi-database-check"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Base de Datos</h6>
                                    <small class="text-info">Conectada y actualizada</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning text-dark p-2 rounded-circle me-3">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Último Respaldo</h6>
                                    <small class="text-warning">Hace 2 horas</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning text-dark p-2 rounded-circle me-3">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Último Respaldo</h6>
                                    <small class="text-warning">Hace 2 horas</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
.btn {
    transition: all 0.2s;
}
.btn:hover {
    transform: scale(1.02);
}
</style>

<script>
    fetch('../private/procesos/obtener_datos.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalEquipos').textContent = data.equipos.reduce((sum, item) => sum + parseInt(item.total), 0);
            document.getElementById('totalUbicaciones').textContent = data.ubicaciones.length;
            document.getElementById('totalEstados').textContent = data.estados.length;
            document.getElementById('totalMovimientos').textContent = data.movimientos.reduce((sum, item) => sum + parseInt(item.total), 0);
        });
</script>