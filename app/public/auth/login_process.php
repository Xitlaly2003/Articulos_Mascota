<?php
session_start();
// Definir una clave secreta para mayor seguridad
$secret_key = 'JIFOEW8NY43TD7839WMEPDOXKQMNWIHUY8G73Y029POWDLÑKSJLNKXBVGU2YXG';

require_once '../../config/database.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Preparar la consulta para buscar al usuario
$sql = "SELECT * FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    $hashed_password = hash('sha256', $password . $secret_key);
    
    // Verificar la contraseña
    if ($hashed_password === $user['password']) {
        // Guardar datos del usuario en la sesión
        $_SESSION['usuario'] = $user['nombre'];
        $_SESSION['rol'] = $user['idrol'];
        $_SESSION['idusuario'] = $user['idusuario'];
        
        // Redirigir según el rol
        if ($user['idrol'] == 1) { // Admin
            header("Location: ../home.php");
        } elseif ($user['idrol'] == 2) { // Cliente
            header("Location: ../client_home.php");
        } else {
            header("Location: home.php");
        }
        exit();
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
    }
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
