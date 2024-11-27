<?php
session_start();
// Definir una clave secreta para mayor seguridad
$secret_key = 'JIFOEW8NY43TD7839WMEPDOXKQMNWIHUY8G73Y029POWDLÑKSJLNKXBVGU2YXG';

require_once '../../config/database.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    echo "Conexión exitosa";
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$idrol = $_POST['role'] ?? '';
echo "<script>alert(idrol);</script>";


// Validar que no falten datos
if (empty($nombre) || empty($email) || empty($password)) {
    echo "<script>alert('Todos los campos son obligatorios'); window.history.back();</script>";
    exit();
}

// Verificar si el correo ya existe
$sql = "SELECT email FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('El correo ya está registrado'); window.history.back();</script>";
} else {

        // Encriptar la contraseña con clave secreta
        $hashed_password = hash('sha256', $password . $secret_key);

        // Insertar el nuevo usuario
        $insert_sql = "INSERT INTO usuario (idrol, nombre, email, password) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);

        if ($insert_stmt === false) {
            // Muestra un error si la preparación de la sentencia falla
            echo "<script>alert('Error al preparar la consulta: " . $conn->error . "'); window.history.back();</script>";
            exit();
        }

        $insert_stmt->bind_param("isss", $idrol, $nombre, $email, $hashed_password);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Registro exitoso'); window.location='login.php';</script>";
        } else {
            // Mostrar detalles del error si la ejecución falla
            echo "<script>
                    alert('" . addslashes("Error al registrar el usuario: " . $insert_stmt->error) . "'); 
                    window.history.back();
                </script>";
        }

        $insert_stmt->close();
}

// Cerrar la conexión
$stmt->close();
$conn->close();
