<?php
session_start();

$archivo = 'users.json';
$usuarios = [];

if (file_exists($archivo)) {
    $usuarios = json_decode(file_get_contents($archivo), true);
    if (!is_array($usuarios)) $usuarios = [];
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 6) {
        foreach ($usuarios as $user) {
            if ($user['email'] === $email) {
                $error = "El email ya está registrado.";
                break;
            }
        }
        if (!$error) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $usuarios[] = ['email' => $email, 'password' => $hash, 'created_at' => date('Y-m-d H:i:s')];
            file_put_contents($archivo, json_encode($usuarios, JSON_PRETTY_PRINT));
            $success = "Usuario registrado con éxito.";
        }
    } else {
        $error = "Email inválido o contraseña muy corta (mínimo 6 caracteres).";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Registro ENACOM Kids</title>
</head>
<body>
<h2>Registro ENACOM Kids</h2>

<?php if ($error): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php elseif ($success): ?>
<p style="color:green"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<form method="POST" action="">
  <label>Email:</label><br />
  <input type="email" name="email" required><br /><br />

  <label>Contraseña (mín 6 caracteres):</label><br />
  <input type="password" name="password" required minlength="6"><br /><br />

  <button type="submit">Registrarse</button>
</form>

<p>¿Ya tenés cuenta? <a href="https://lavacraft.loca.lt/login.php">Iniciar sesión</a></p>
</body>
</html>
