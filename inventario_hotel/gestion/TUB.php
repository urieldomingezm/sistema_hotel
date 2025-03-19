<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

// Conectar a la base de datos
$conn = conectarBD();

// Verificar si la conexión fue exitosa
if (!$conn) {
    die("Error al conectar a la base de datos.");
}

// Procesar eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $query = "DELETE FROM ubicaciones WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Procesar edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $query = "
        UPDATE ubicaciones 
        SET nombre = :nombre, descripcion = :descripcion
        WHERE id = :id
    ";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->execute();
}

// Procesar registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $query = "INSERT INTO ubicaciones (nombre, descripcion) VALUES (:nombre, :descripcion)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->execute();
}

// Obtener los datos de la tabla `ubicaciones`
$query_ubicaciones = "SELECT id, nombre, descripcion FROM ubicaciones";
$stmt_ubicaciones = $conn->prepare($query_ubicaciones);
$stmt_ubicaciones->execute();
$ubicaciones = $stmt_ubicaciones->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="bi bi-geo-alt-fill me-2"></i>Gestión de Ubicaciones
                </h3>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
                    <i class="bi bi-plus-circle me-2"></i>Nueva Ubicación
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabla-ubicaciones" class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Ubicación</th>
                            <th>Descripción</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ubicaciones as $ubicacion): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#<?php echo htmlspecialchars($ubicacion['id']); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-building text-primary me-2"></i>
                                        <strong><?php echo htmlspecialchars($ubicacion['nombre']); ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted d-inline-block text-truncate" style="max-width: 300px;">
                                        <?php echo htmlspecialchars($ubicacion['descripcion']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button class="btn btn-outline-warning btn-sm" 
                                                onclick="editarUbicacion(<?php echo htmlspecialchars(json_encode($ubicacion)); ?>)">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" 
                                                onclick="confirmarEliminacion(<?php echo $ubicacion['id']; ?>, '<?php echo $ubicacion['nombre']; ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarEliminacion(id, nombre) {
    Swal.fire({
        title: '¿Eliminar ubicación?',
        html: `¿Estás seguro de eliminar la ubicación <strong>${nombre}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash me-2"></i>Sí, eliminar',
        cancelButtonText: '<i class="bi bi-x-circle me-2"></i>Cancelar',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `index.php?page=Gestion ubicaciones&eliminar=${id}`;
        }
    });
}

function editarUbicacion(ubicacion) {
    const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
    document.getElementById('idUbicacion').value = ubicacion.id;
    document.getElementById('nombre').value = ubicacion.nombre;
    document.getElementById('descripcion').value = ubicacion.descripcion;
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    const dataTable = new simpleDatatables.DataTable("#tabla-ubicaciones", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        labels: {
            placeholder: "Buscar ubicaciones...",
            perPage: "Mostrar registros por página",
            noRows: "No se encontraron ubicaciones",
            info: "Mostrando {start} a {end} de {rows} ubicaciones",
            noResults: "No hay resultados para la búsqueda"
        },
        layout: {
            top: "{search}",
            bottom: "{select}{info}{pager}"
        }
    });
});
</script>

<style>
.table th {
    white-space: nowrap;
}
.badge {
    font-size: 0.85em;
    padding: 0.5em 0.75em;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
}
.table-responsive {
    min-height: 400px;
}
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
.btn-outline-warning:hover,
.btn-outline-danger:hover {
    transform: translateY(-2px);
    transition: transform 0.2s;
}
</style>

    <!-- Modal para registrar -->
    <div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalRegistrarLabel">Registrar Nueva Ubicación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formRegistrar" method="POST">
                        <input type="hidden" name="registrar" value="1">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Registrar ubicacion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Ubicación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditar" method="POST">
                        <input type="hidden" id="idUbicacion" name="id">
                        <div class="row">
                            <!-- Columna 1 -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Ubicacion</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                            <!-- Columna 2 -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Simple DataTables JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
    <script>
        // Inicializar Simple DataTables
        document.addEventListener('DOMContentLoaded', function () {
            const dataTable = new simpleDatatables.DataTable("#tabla-ubicaciones", {
                searchable: true,
                paging: true,
                perPage: 10,
                labels: {
                    placeholder: "Buscar...",
                    perPage: "registros por página",
                    noRows: "No se encontraron registros",
                    info: "Mostrando {start} a {end} de {rows} registros",
                },
            });
        });

        // Función para confirmar la eliminación con SweetAlert2
        function confirmarEliminacion(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `index.php?page=Gestion ubicaciones&eliminar=${id}`;
                }
            });
        }

        // Llenar el modal de editar con los datos de la ubicación
        document.getElementById('modalEditar').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Botón que activó el modal
            const id = button.getAttribute('data-id'); // Obtener el ID de la ubicación
            const nombre = button.getAttribute('data-nombre'); // Obtener el nombre
            const descripcion = button.getAttribute('data-descripcion'); // Obtener la descripción

            // Llenar los campos del formulario con los datos de la ubicación
            document.getElementById('idUbicacion').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('descripcion').value = descripcion;
        });
    </script>
</body>