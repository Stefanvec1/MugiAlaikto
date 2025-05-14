<?php
include("konexioa.php");
session_start();

// Si el usuario no está logueado, redirige a la página de inicio de sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: hasisaioa.php?alerta=debes_iniciar_sesion");
    exit();
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Erreserba | AlaiktoMUGI</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header class="main-header">
  <div class="logo">
    <img src="imgs/logo_sin_texto_ampliado.png" alt="AlaiktoMUGI logo">
  </div>
  <nav>
    <a href="index.php" class="button">Menua</a>
    <a href="historial.php" class="button">Historiala</a>
    <a href="hasisaioa.php" class="button">Saioa Itxi</a>
  </nav>
</header>

<div class="register-container">
  <h2>Erreserba egin</h2>
  <form action="erreserba.php" method="POST">
    <label for="data_irteera">Irteeraren data:</label>
    <input type="date" id="data_irteera" name="data_irteera" required>

    <label for="ordu_irteera">Irteeraren ordua:</label>
    <input type="time" id="ordu_irteera" name="ordu_irteera" required>

    <label for="data_iristea">Iristearen data:</label>
    <input type="date" id="data_iristea" name="data_iristea" required>

    <label for="ordu_iristea">Iristearen ordua:</label>
    <input type="time" id="ordu_iristea" name="ordu_iristea" required>

    <label for="pasaiariak">Pasaiari kopurua:</label>
    <input type="number" id="pasaiariak" name="pasaiariak" min="1" required>

    <label for="irteera">Irteera lekua:</label>
    <input type="text" id="irteera" name="irteera" required>

    <label for="helmuga">Helmuga:</label>
    <input type="text" id="helmuga" name="helmuga" required>

    <input type="submit" value="Erreserbatu">
  </form>
</div>

<footer>
  <div style="max-width: 1200px; margin: 0 auto; padding: 30px; background-color: #0d0d0d; color: #ccc; font-size: 0.95em;">
    <div style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px;">
      <div>
        <strong>AlaiktoMUGI S.A.</strong><br>
        Tel: <a href="tel:+34900123456" style="color: #ccc; text-decoration: none;">+34 900 123 456</a><br>
        Email: <a href="mailto:info@alaiktomugi.eus" style="color: #ccc; text-decoration: none;">info@alaiktomugi.eus</a><br>
        Helbidea: Donostia kalea 7, 20001 Bilbo, Euskal Herria
      </div>
      <div>
        <a href="https://facebook.com" target="_blank"><img src="imgs/descarga.jpg" alt="Facebook" width="24"></a>
        <a href="https://twitter.com" target="_blank"><img src="imgs/descarga (1).jpg" alt="Twitter" width="24"></a>
        <a href="https://instagram.com" target="_blank"><img src="imgs/descarga.png" alt="Instagram" width="24"></a>
      </div>
    </div>
    <div style="text-align: center; margin-top: 20px; font-size: 0.85em; color: #888;">
      &copy; 2025 AlaiktoMUGI S.A. - Eskubide guztiak erreserbatuta.
    </div>
  </div>
</footer>

</body>
</html>




