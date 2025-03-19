<?php
session_start();

$host = 'db';
$dbname = 'hotel_inventario';
$username = 'root';
$password = 'root';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $e->getMessage()]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["register_nombre"]);
    $apellidos = trim($_POST["register_apellidos"]);
    $email = trim($_POST["register_email"]);
    $contraseña = password_hash($_POST["register_password"], PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("SELECT id_usuario FROM login_usuarios WHERE usuario_email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Este correo ya está registrado']);
            exit;
        }

        $sql = "INSERT INTO login_usuarios (usuario_nombre, usuario_apellido, usuario_email, usuario_password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute([$nombre, $apellidos, $email, $contraseña])) {
            echo json_encode(['success' => true, 'message' => '¡Registro exitoso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar']);
        }
        exit;
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
</head>
<body style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="card shadow-lg" style="max-width: 500px; width: 100%;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="private/img/logo.jpg" alt="Logo" class="img-fluid mb-3" style="max-width: 200px;">
                    <h2 class="fw-bold text-primary">Registro de Usuario</h2>
                </div>

                <form id="registerForm" method="POST">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombre" name="register_nombre" placeholder="Nombre">
                                <label for="nombre">Nombre</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="apellidos" name="register_apellidos" placeholder="Apellidos">
                                <label for="apellidos">Apellidos</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="register_email" placeholder="correo@ejemplo.com">
                        <label for="email">Correo electrónico</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="password" name="register_password" placeholder="Contraseña">
                        <label for="password">Contraseña</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Registrarse</button>

                    <p class="text-center mt-3">
                        ¿Ya tienes cuenta? <a href="index.php" class="text-decoration-none">Iniciar sesión</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        const validation = new JustValidate('#registerForm', {
            validateBeforeSubmitting: true,
        });

        validation
            .addField('#nombre', [
                {
                    rule: 'required',
                    errorMessage: 'El nombre es obligatorio',
                },
                {
                    rule: 'minLength',
                    value: 3,
                    errorMessage: 'Mínimo 3 caracteres',
                },
                {
                    rule: 'custom',
                    validator: (value) => /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(value),
                    errorMessage: 'Solo letras y espacios',
                }
            ])
            .addField('#apellidos', [
                {
                    rule: 'required',
                    errorMessage: 'Los apellidos son obligatorios',
                },
                {
                    rule: 'minLength',
                    value: 3,
                    errorMessage: 'Mínimo 3 caracteres',
                },
                {
                    rule: 'custom',
                    validator: (value) => /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(value),
                    errorMessage: 'Solo letras y espacios',
                }
            ])
            .addField('#email', [
                {
                    rule: 'required',
                    errorMessage: 'El correo es obligatorio',
                },
                {
                    rule: 'email',
                    errorMessage: 'Correo no válido',
                }
            ])
            .addField('#password', [
                {
                    rule: 'required',
                    errorMessage: 'La contraseña es obligatoria',
                },
                {
                    rule: 'minLength',
                    value: 6,
                    errorMessage: 'Mínimo 6 caracteres',
                }
            ])
            .onSuccess((event) => {
                event.preventDefault();
                const formData = new FormData(event.target);

                fetch(event.target.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.php';
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al procesar la solicitud',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            });
    </script>
</body>
</html>