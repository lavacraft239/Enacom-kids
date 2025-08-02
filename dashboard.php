<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Dashboard ENACOM Kids</title>
</head>
<body>
<h1>Bienvenido <?= htmlspecialchars($_SESSION['email']) ?></h1>
<p>¡Ya estás logueado en ENACOM Kids!</p>
<form method="POST" action="logout.php">
  <button type="submit">Cerrar sesión</button>
</form>
</body>
</html>
