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
    $email = trim($_POST["usuario_email"]);
    $password = $_POST["usuario_password"];

    try {
        $sql = "SELECT id_usuario, usuario_nombre, usuario_apellido, usuario_password FROM login_usuarios WHERE usuario_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            // Change the password verification to use password_verify
            if (password_verify($password, $usuario['usuario_password'])) {
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['usuario_nombre'] = $usuario['usuario_nombre'];
                $_SESSION['usuario_apellido'] = $usuario['usuario_apellido'];
                $_SESSION['usuario_email'] = $email;
                
                echo json_encode(['success' => true, 'message' => '¡Bienvenido!']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            exit;
        }
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
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
</head>
<body style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-lg" style="max-width: 400px; width: 100%;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="private/img/logo.jpg" alt="Logo" class="img-fluid mb-3" style="max-width: 200px;">
                    <h2 class="fw-bold text-primary">Inicio de Sesión</h2>
                </div>

                <form id="loginForm" method="POST">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="usuario_email" placeholder="correo@ejemplo.com">
                        <label for="email">Correo electrónico</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="password" name="usuario_password" placeholder="Contraseña">
                        <label for="password">Contraseña</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                        Iniciar Sesión
                    </button>

                    <p class="text-center mb-0">
                        ¿No tienes cuenta? <a href="registrer.php" class="text-decoration-none">Regístrate</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        const validation = new JustValidate('#loginForm', {
            validateBeforeSubmitting: true,
        });

        validation
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
                                window.location.href = 'gestion/index.php';
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


<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

require_once(TEMPLATES_PATH . 'plantilla_footer.php');
?>
