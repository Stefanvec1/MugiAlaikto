<?php
include("konexioa.php"); 
?>

<!DOCTYPE html>
<html lang="eu">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Erregistroa | AlaiktoMUGI</title>
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
      <a href="hasisaioa.php" class="button">Saioa Hasi</a>
    </nav>
  </header>

  <div class="register-container">
    <h2>Erregistroa</h2>
    <form action="erregistroa.php" method="POST">
      <label for="izena">Izena:</label>
      <input type="text" id="izena" name="izena" required />

      <label for="abizena">Abizena:</label>
      <input type="text" id="abizena" name="abizena" required />

      <label for="telefonoa">Telefonoa:</label>
      <input type="tel" id="telefonoa" name="telefonoa" required />

      <label for="helidea">Helbidea:</label>
      <input type="text" id="helidea" name="helidea" required />

      <label for="korreoa">Korreoa:</label>
      <input type="email" id="korreoa" name="korreoa" required />

      <label for="pasahitza">Pasahitza:</label>
      <input type="password" id="pasahitza" name="pasahitza" required />

      <input type="submit" value="Erregistratu" />

      <div class="login-link">
        Jada baduzu kontu bat? <a href="hasisaioa.php">Saioa hasi hemen</a>
      </div>
    </form>
  </div>

  <?php
  
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger los datos del formulario
    $izena = $_POST['izena'];
    $abizena = $_POST['abizena'];
    $telefonoa = !empty($_POST['telefonoa']) ? $_POST['telefonoa'] : null;
    $helbidea = !empty($_POST['helbidea']) ? $_POST['helbidea'] : null;
    $korreoa = $_POST['korreoa'];
    $pasahitza = $_POST['pasahitza'];

    // Verificación de campos
    if (empty($izena) || empty($abizena) || empty($korreoa) || empty($pasahitza)) {
        header("Location: erregistroa.php?message=rerregistratu");
        exit;
    } else {
        // Preparar la consulta SQL
        $stmt = $conn->prepare("INSERT INTO bezeroa (Izena, Abizena, Telefonoa, Helbidea, Korreoa, Pasahitza)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $izena, $abizena, $telefonoa, $helbidea, $korreoa, $pasahitza);

        // Ejecutar la consulta y verificar si se insertó correctamente
        if ($stmt->execute()) {
            header("Location: erregistroa.php?message=erregistratuta");
        } else {
            header("Location: erregistroa.php?message=rerregistratu");
        }

        // Cerrar la consulta y la conexión
        $stmt->close();
        $conn->close();
        exit;
    }
}
  if (isset($_GET['message'])) {
      $message = $_GET['message'];
      if ($message == "erregistratuta") {
          echo "<script>alert('Erregistratuta!');</script>";
      } elseif ($message == "rerregistratu") {
          echo "<script>alert('Erregistroa ez da ondo egin. Saiatu berriro.');</script>";
      }
  }
  ?>

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
          <a href="https://facebook.com" target="_blank" style="margin-right: 10px;">
            <img src="imgs/descarga.jpg" alt="Facebook" width="24">
          </a>
          <a href="https://twitter.com" target="_blank" style="margin-right: 10px;">
            <img src="imgs/descarga (1).jpg" alt="Twitter" width="24">
          </a>
          <a href="https://instagram.com" target="_blank" style="margin-right: 10px;">
            <img src="imgs/descarga.png" alt="Instagram" width="24">
          </a>
        </div>
      </div>

      <div style="text-align: center; margin-top: 20px; font-size: 0.85em; color: #888;">
        &copy; 2025 AlaiktoMUGI S.A. - Eskubide guztiak erreserbatuta.
      </div>
    </div>
  </footer>

</body>
</html>

