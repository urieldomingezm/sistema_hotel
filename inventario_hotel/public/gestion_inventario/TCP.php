<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/rutas.php');
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
    $query = "DELETE FROM equipos WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Procesar edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $numero_serie = $_POST['numero_serie'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $fecha_adquisicion = $_POST['fecha_adquisicion'];
    $fecha_expericion = $_POST['fecha_expericion'];
    $fecha_garantia = $_POST['fecha_garantia'];
    $estado = $_POST['estado'];

    $query = "
        UPDATE equipos 
        SET nombre = :nombre, descripcion = :descripcion, numero_serie = :numero_serie, 
            marca = :marca, modelo = :modelo, fecha_adquisicion = :fecha_adquisicion, fecha_garantia = :fecha_garantia,fecha_expericion = :fecha_expericion, estado = :estado
        WHERE id = :id
    ";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':numero_serie', $numero_serie);
    $stmt->bindParam(':marca', $marca);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':fecha_adquisicion', $fecha_adquisicion);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':fecha_expericion', $fecha_expericion);
    $stmt->bindParam(':fecha_garantia', $fecha_garantia);
    $stmt->execute();
}

// Obtener los datos de la tabla `equipos`
$query_equipos = "
    SELECT e.id, e.nombre, e.descripcion, e.fecha_garantia, e.estado, e.fecha_expericion, e.numero_serie, e.marca, e.modelo, 
           c.nombre AS categoria_nombre, u.nombre AS ubicacion_nombre, 
           e.fecha_adquisicion, e.estado 
    FROM equipos e
    LEFT JOIN categorias c ON e.categoria_id = c.id
    LEFT JOIN ubicaciones u ON e.ubicacion_id = u.id
";
$stmt_equipos = $conn->prepare($query_equipos);
$stmt_equipos->execute();
$equipos = $stmt_equipos->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Computadoras</h1> 
        <table id="tabla-equipos" class="table table-bordered table-borderless table-striped table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Número de Serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Categoría</th>
                    <th>Ubicación</th>
                    <th>Adquisición</th>
                    <th>Estado</th>
                    <th>garantia</th>
                    <th>expericion</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipos as $equipo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($equipo['id']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['numero_serie']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['marca']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['categoria_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['ubicacion_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['fecha_adquisicion']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['estado']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['fecha_garantia']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['fecha_expericion']); ?></td>
                        <td>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="accionesMenu"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Acciones
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="accionesMenu">
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEditar"
                                        href="#">Editar</a></li>
                                <li><a class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#modal_despedir_persona" href="#">Eliminar</a></li>
                            </ul>
                        </div>
                            <!-- Botón para abrir el modal de editar -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar"
                                data-id="<?php echo $equipo['id']; ?>"
                                data-nombre="<?php echo htmlspecialchars($equipo['nombre']); ?>"
                                data-descripcion="<?php echo htmlspecialchars($equipo['descripcion']); ?>"
                                data-numero_serie="<?php echo htmlspecialchars($equipo['numero_serie']); ?>"
                                data-marca="<?php echo htmlspecialchars($equipo['marca']); ?>"
                                data-modelo="<?php echo htmlspecialchars($equipo['modelo']); ?>"
                                data-categoria="<?php echo htmlspecialchars($equipo['categoria_nombre']); ?>"
                                data-ubicacion="<?php echo htmlspecialchars($equipo['ubicacion_nombre']); ?>"
                                data-fecha_adquisicion="<?php echo htmlspecialchars($equipo['fecha_adquisicion']); ?>"
                                data-estado="<?php echo htmlspecialchars($equipo['estado']); ?>"
                                data-fecha_garantia="<?php echo htmlspecialchars($equipo['fecha_garantia']); ?>"
                                data-fecha_expericion="<?php echo htmlspecialchars($equipo['fecha_expericion']); ?>">

                                <i class="bi bi-pencil"></i>
                            </button>
                            <!-- Botón para eliminar -->
                            <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?php echo $equipo['id']; ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Equipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditar" method="POST">
                        <input type="hidden" id="idEquipo" name="id">
                        <div class="row">
                            <!-- Columna 1 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="numero_serie" class="form-label">Número de Serie</label>
                                    <input type="text" class="form-control" id="numero_serie" name="numero_serie" required>
                                </div>
                            </div>
                            <!-- Columna 2 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="marca" class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="marca" name="marca" required>
                                </div>
                                <div class="mb-3">
                                    <label for="modelo" class="form-label">Modelo</label>
                                    <input type="text" class="form-control" id="modelo" name="modelo" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fecha_adquisicion" class="form-label">Fecha de Adquisición</label>
                                    <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" required>
                                </div>
                            </div>
                            <!-- Columna 3 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado" required>
                                </div>
                                <div class="mb-3">
                                    <label for="categoria" class="form-label">Categoría</label>
                                    <input type="text" class="form-control" id="categoria" name="categoria" disabled readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="ubicacion" class="form-label">Ubicación</label>
                                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" disabled readonly>
                                </div>
                                <div class="mb-2">
                                    <label for="fecha_garantia" class="form-label">Fecha de garantia</label>
                                    <input type="date" class="form-control" id="fecha_garantia" name="fecha_garantia">
                                </div>
                                <div class="mb-3">
                                    <label for="fecha_expericion" class="form-label">Fecha de expericion</label>
                                    <input type="date" class="form-control" id="fecha_expericion" name="fecha_expericion">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Inicializar Simple DataTables
        document.addEventListener('DOMContentLoaded', function() {
            const dataTable = new simpleDatatables.DataTable("#tabla-equipos", {
                searchable: true,
                paging: true,
                perPage: 5,
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
                    window.location.href = `index.php?page=Gestion computadoras&eliminar=${id}`;
                }
            });
        }

        // Llenar el modal de editar con los datos del equipo
        document.getElementById('modalEditar').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Botón que activó el modal
            const id = button.getAttribute('data-id'); // Obtener el ID del equipo

            // Llenar los campos del formulario con los datos del equipo
            document.getElementById('idEquipo').value = id;
            document.getElementById('nombre').value = button.getAttribute('data-nombre');
            document.getElementById('descripcion').value = button.getAttribute('data-descripcion');
            document.getElementById('numero_serie').value = button.getAttribute('data-numero_serie');
            document.getElementById('marca').value = button.getAttribute('data-marca');
            document.getElementById('modelo').value = button.getAttribute('data-modelo');
            document.getElementById('categoria').value = button.getAttribute('data-categoria');
            document.getElementById('ubicacion').value = button.getAttribute('data-ubicacion');
            document.getElementById('fecha_adquisicion').value = button.getAttribute('data-fecha_adquisicion');
            document.getElementById('estado').value = button.getAttribute('data-estado');
            document.getElementById('fecha_garantia').value = button.getAttribute('data-fecha_garantia');
            document.getElementById('fecha_expericion').value = button.getAttribute('data-fecha_expericion');
        });
    </script>
</body>