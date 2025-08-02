<?php
session_start();

if (isset($_SESSION['email'])) {
    header('Location: dashboard.php');
    exit;
}

$archivo = 'users.json';
$usuarios = [];

if (file_exists($archivo)) {
    $usuarios = json_decode(file_get_contents($archivo), true);
    if (!is_array($usuarios)) $usuarios = [];
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    foreach ($usuarios as $user) {
        if ($user['email'] === $email) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Contraseña incorrecta.';
            }
            break;
        }
    }
    if (!$error) {
        $error = 'Correo no registrado.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Login ENACOM Kids</title>
</head>
<body>
<h2>Iniciar sesión ENACOM Kids</h2>

<?php if ($error): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="">
  <label>Email:</label><br />
  <input type="email" name="email" required><br /><br />

  <label>Contraseña:</label><br />
  <input type="password" name="password" required><br /><br />

  <button type="submit">Ingresar</button>
</form>

<p>¿No tenés cuenta? <a href="https://lavacraft.loca.lt/registro.php">Registrate</a></p>
</body>
</html>
