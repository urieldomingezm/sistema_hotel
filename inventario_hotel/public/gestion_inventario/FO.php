<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/rutas.php');
require_once(CONFIG_PATH . 'bd.php');
?>

<!-- CONTENIDO PRINCIPAL -->
<div class="container mt-5 pt-5">
    <!-- BIENVENIDA -->
    <div class="jumbotron text-center bg-primary text-white p-4 rounded shadow">
        <h1 class="display-5">Bienvenido al Inventario de Equipos</h1>
        <p class="lead">Administra y visualiza el estado de tu inventario en tiempo real con gráficos dinámicos.</p>
    </div>

    <!-- RESUMEN RÁPIDO -->
    <div class="row text-center mt-4">
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Total Equipos</h5>
                    <h2 id="totalEquipos">5</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Ubicaciones</h5>
                    <h2 id="totalUbicaciones">5</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Estados</h5>
                    <h2 id="totalEstados">1</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">movimiento</h5>
                    <h2 id="totalMovimientos">4</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- DASHBOARD GRÁFICAS -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-lg p-3">
                <h5 class="text-center">Equipos por Categoría</h5>
                <canvas id="graficoEquipos"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg p-3">
                <h5 class="text-center">Equipos por Ubicación</h5>
                <canvas id="graficoUbicaciones"></canvas>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-lg p-3">
                <h5 class="text-center">Estados de Equipos</h5>
                <canvas id="graficoEstados"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg p-3">
                <h5 class="text-center">Movimientos de Equipos</h5>
                <canvas id="graficoMovimientos"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    fetch('../../private/procesos/obtener_datos.php')
        .then(response => response.json())
        .then(data => {
            // Configuración de degradado para gráficos
            function createGradient(ctx, color1, color2) {
                let gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, color1);
                gradient.addColorStop(1, color2);
                return gradient;
            }

            // Gráfico de Equipos por Categoría
            let ctx1 = document.getElementById('graficoEquipos').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: data.equipos.map(d => d.categoria),
                    datasets: [{
                        label: 'Cantidad de Equipos',
                        data: data.equipos.map(d => d.total),
                        backgroundColor: createGradient(ctx1, '#007bff', '#17a2b8'),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Gráfico de Equipos por Ubicación (Barras Horizontales)
            let ctx2 = document.getElementById('graficoUbicaciones').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: data.ubicaciones.map(d => d.ubicacion),
                    datasets: [{
                        data: data.ubicaciones.map(d => d.total),
                        backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff']
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y'
                }
            });

            // Gráfico de Estados de Equipos (Doughnut)
            new Chart(document.getElementById('graficoEstados'), {
                type: 'doughnut',
                data: {
                    labels: data.estados.map(d => d.estado),
                    datasets: [{
                        data: data.estados.map(d => d.total),
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d']
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Gráfico de Movimientos de Equipos (Línea con Puntos)
            new Chart(document.getElementById('graficoMovimientos'), {
                type: 'line',
                data: {
                    labels: data.movimientos.map(d => d.tipo),
                    datasets: [{
                        label: 'Movimientos',
                        data: data.movimientos.map(d => d.total),
                        backgroundColor: '#17a2b8',
                        borderColor: '#17a2b8',
                        fill: true,
                        tension: 0.4, // Suavizado de la línea
                        pointRadius: 5,
                        pointBackgroundColor: '#17a2b8'
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
</script>
