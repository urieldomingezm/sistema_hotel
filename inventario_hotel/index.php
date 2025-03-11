<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/rutas.php');
require_once(TEMPLATES_PATH . 'header.php');

// Conexión a la base de datos
require_once(CONFIG_PATH . 'bd.php'); // Asegúrate de que este archivo contenga $conn

// Verificar si la conexión es válida
if (!$conn) {
    die("<div class='alert alert-danger'>Error de conexión con la base de datos.</div>");
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = trim($_POST["usuario_email"]);
    $password = $_POST["usuario_password"];

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        echo "<div class='alert alert-danger'>Todos los campos son obligatorios.</div>";
        exit;
    }

    try {
        // Buscar el usuario en la base de datos
        $sql = "SELECT id_usuario, usuario_nombre, usuario_apellido, usuario_password FROM login_usuarios WHERE usuario_email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Comparar la contraseña en texto claro
            if ($password === $usuario['usuario_password']) {
                // Iniciar sesión
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['usuario_nombre'] = $usuario['usuario_nombre'];
                $_SESSION['usuario_apellido'] = $usuario['usuario_apellido'];
                $_SESSION['usuario_email'] = $email;

                // Redireccionar a la página principal
                header("Location: public/gestion_inventario/index.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Contraseña incorrecta.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Usuario no encontrado.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error en la base de datos: " . $e->getMessage() . "</div>";
    }
}
?>

<body class="d-flex flex-column min-vh-100" style="background-color: rgb(14 177 251) !important;">
    <br>
    <br>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-body text-center" style="background-color: #f9f6f7;">
                <img alt="Iberostar Selection Playa Mita" src="private/img/logo.jpg" class="img-fluid mb-4">
                <h2>Inicio de Sesión</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="text" class="form-control" id="email" name="usuario_email" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="usuario_password" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-block">Iniciar Sesión</button>
                </form>
                <br>
                <p>¿No tienes una cuenta? <a href="registrer.php">Regístrate</a></p>
            </div>
        </div>
    </div>
</body>

<?php
require_once(TEMPLATES_PATH . 'footer.php');
?>

<!-- Agregar un script para desaparecer las alertas después de unos segundos -->
<script>
    setTimeout(function() {
        var alert = document.querySelector('.alert');
        if (alert) {
            alert.style.transition = 'opacity 1s';
            alert.style.opacity = 0;
            setTimeout(function() {
                alert.remove();
            }, 1000); // Elimina la alerta después de la transición
        }
    }, 3000); // Duración de la alerta (en milisegundos)
</script>
