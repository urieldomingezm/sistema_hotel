<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inventario_hotel/rutas.php');
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

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Tabla de Ubicaciones</h1>
        <!-- Botón para abrir el modal de registro -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
            <i class="bi bi-plus"></i> Registrar Nueva Ubicación
        </button>
        <table id="tabla-ubicaciones" class="table table-bordered table-borderless table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ubicaciones as $ubicacion): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ubicacion['id']); ?></td>
                        <td><?php echo htmlspecialchars($ubicacion['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($ubicacion['descripcion']); ?></td>
                        <td>
                            <!-- Botón para abrir el modal de editar -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar"
                                data-id="<?php echo $ubicacion['id']; ?>"
                                data-nombre="<?php echo htmlspecialchars($ubicacion['nombre']); ?>"
                                data-descripcion="<?php echo htmlspecialchars($ubicacion['descripcion']); ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <!-- Botón para eliminar -->
                            <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?php echo $ubicacion['id']; ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para registrar -->
    <div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
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
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
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
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                            <!-- Columna 2 -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
                    window.location.href = `index.php?page=TUB&eliminar=${id}`;
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