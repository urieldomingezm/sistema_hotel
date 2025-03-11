<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/rutas.php');
require_once(TEMPLATES_PATH . 'header.php');

// Conexión a la base de datos
require_once(CONFIG_PATH . 'bd.php'); // Asegúrate de que este archivo contenga $conn

// Verificar si la conexión es válida
if (!$conn) {
    die("<div class='alert alert-danger' id='alert'>Error de conexión con la base de datos.</div>");
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = trim($_POST["register_nombre"]);
    $apellidos = trim($_POST["register_apellidos"]);
    $email = trim($_POST["register_email"]);
    $contraseña = $_POST["register_contraseña"];

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($contraseña)) {
        echo "<div class='alert alert-danger' id='alert'>Todos los campos son obligatorios.</div>";
        exit;
    }

    try {
        // Verificar si el correo ya está registrado
        $sql = "SELECT id_usuario FROM login_usuarios WHERE usuario_email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<div class='alert alert-danger' id='alert'>El correo electrónico ya está registrado.</div>";
            header("Location: registrer.php");
            exit;
        }

        // No hacer hash de la contraseña, se guarda tal cual
        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO login_usuarios (usuario_nombre, usuario_apellido, usuario_email, usuario_password) 
                VALUES (:nombre, :apellidos, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $contraseña, PDO::PARAM_STR); // Guardamos la contraseña tal cual

        if ($stmt->execute()) {
            // Registro exitoso
            echo "<div class='alert alert-success' id='alert'>Registro exitoso. Ahora puedes iniciar sesión.</div>";
            // Redireccionar al usuario a la página de inicio de sesión
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='alert alert-danger' id='alert'>Hubo un error al registrar el usuario.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' id='alert'>Error en la base de datos: " . $e->getMessage() . "</div>";
    }
}
?>


<body class="d-flex flex-column min-vh-100" style="background-color: rgb(14 177 251) !important;">
    <br>
    <br>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-body text-center" style="background-color: #f9f6f5;">
                <img alt="Iberostar Selection Playa Mita" src="private/img/logo.jpg" class="img-fluid mb-4">
                <h2>Registros de usuarios</h2>
                <br>
                <form id="registerForm" method="POST">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="register_nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="register_apellidos" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="register_email" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="register_contraseña" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-block">Registrar datos</button>
                </form>
                <br>
                <p>¿Tienes cuenta? <a href="index.php">Iniciar sesión</a></p>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const validation = new JustValidate('#registerForm', {
            validateBeforeSubmitting: true,
        });

        validation
            .addField('#nombre', [{
                    rule: 'required',
                    errorMessage: 'El nombre es obligatorio',
                },
                {
                    rule: 'minLength',
                    value: 3,
                    errorMessage: 'El nombre debe tener al menos 3 caracteres',
                },
                {
                    rule: 'custom',
                    validator: (value) => /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(value),
                    errorMessage: 'El nombre solo puede contener letras y espacios',
                }
            ])
            .addField('#apellidos', [{
                    rule: 'required',
                    errorMessage: 'Los apellidos son obligatorios',
                },
                {
                    rule: 'minLength',
                    value: 3,
                    errorMessage: 'Los apellidos deben tener al menos 3 caracteres',
                },
                {
                    rule: 'custom',
                    validator: (value) => /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(value),
                    errorMessage: 'Los apellidos solo pueden contener letras y espacios',
                }
            ])
        .addField('#email', [{
                    rule: 'required',
                    errorMessage: 'El correo electrónico es obligatorio',
                },
                {
                    rule: 'email',
                    errorMessage: 'El correo electrónico no es válido',
                },
            ])
            .addField('#password', [{
                    rule: 'required',
                    errorMessage: 'La contraseña es obligatoria',
                },
                {
                    rule: 'minLength',
                    value: 6,
                    errorMessage: 'La contraseña debe tener al menos 6 caracteres',
                },
            ])
            .onSuccess((event) => {
                // Si la validación es exitosa, el formulario se envía
                event.target.submit();
            });

        // Hacer desaparecer las alertas después de 3 segundos
        setTimeout(function() {
            const alert = document.getElementById("alert");
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000); // 3000 milisegundos = 3 segundos
    });
</script>

<?php
require_once(TEMPLATES_PATH . 'footer.php');
?>
