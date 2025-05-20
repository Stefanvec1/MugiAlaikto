<?php
include("konexioa.php");
session_start();

// Si el usuario no está logueado, redirige a la página de inicio de sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: hasisaioa.php?alerta=debes_iniciar_sesion");
    exit();
}

// Si se ha enviado el formulario, procesar los datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hasieraData = $_POST['data_irteera'];
    $hasieraOrdua = $_POST['ordu_irteera'];
    $abiapuntua = $_POST['irteera'];
    $helmuga = $_POST['helmuga'];
    $pertsonaKop = $_POST['pasaiariak'];

    // ID del usuario logueado (cliente)
    $bezeroID = $_SESSION['usuario_id'];

    // Insertar en la tabla bidaia (sin amaiera data/ordua)
    $sql = "INSERT INTO bidaia (
                Abiapuntua, Helmuga, HasieraData, HasieraOrdua,
                Bezeroa_BezeroID, Langilea_LangileID, Egoera, PertsonaKop
            ) VALUES (?, ?, ?, ?, ?, NULL, 0, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssii", $abiapuntua, $helmuga, $hasieraData, $hasieraOrdua, $bezeroID, $pertsonaKop);
        if ($stmt->execute()) {
            header("Location: historial.php?mezua=erreserba_egin_da");
            exit();
        } else {
            echo "Errorea erreserba gordetzean: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Errorea SQL prestaketarekin: " . $conn->error;
    }

    $conn->close();
}
?>

<!-- HTML HTML HTML -->
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
<a href="index.php">
  <div class="logo">
    <img src="imgs/logo_sin_texto_ampliado.png" alt="AlaiktoMUGI logo">
  </div>
</a>

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




