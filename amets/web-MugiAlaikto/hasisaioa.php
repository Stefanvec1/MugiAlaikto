<?php
session_start();
include("konexioa.php");

if (isset($_GET['alerta']) && $_GET['alerta'] === 'login') {
    echo "<script>alert('Erreserba egiteko, saioa hasi behar duzu.');</script>";
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Saioa Hasi | AlaiktoMUGI</title>
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
    <?php if (isset($_SESSION['usuario'])): ?>
      <a href="saioaitxi.php" class="button">Saioa Itxi</a>
    <?php else: ?>
      <a href="hasisaioa.php" class="button">Saioa Hasi</a>
    <?php endif; ?>
  </nav>
</header>

<div class="login-container">
  <h2>
    <?php echo isset($_SESSION['usuario']) ? 'Saioa Hasita' : 'Saioa Hasi'; ?>
  </h2>

  <?php if (isset($_SESSION['usuario'])): ?>
    <p style="text-align: center; font-size: 1.1em;">
      Ongi etorri, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!
    </p>
  <?php else: ?>
    <form action="hasisaioa.php" method="POST">
      <label for="usuario">Erabiltzailea:</label>
      <input type="text" id="usuario" name="usuario" required />

      <label for="pasahitza">Pasahitza:</label>
      <input type="password" id="pasahitza" name="pasahitza" required />

      <input type="submit" value="Hasi saioa" />

      <div class="register-link">
        Ez duzu konturik? <a href="erregistroa.php">Erregistratu orain</a>
      </div>

      <?php
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
          $usuario = $_POST['usuario'];
          $pasahitza = $_POST['pasahitza'];

          if (empty($usuario) || empty($pasahitza)) {
              $message = "errordata";
          } else {
              $stmt = $conn->prepare("SELECT * FROM bezeroa WHERE Korreoa = ? AND Pasahitza = ?");
              $stmt->bind_param("ss", $usuario, $pasahitza);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $_SESSION['usuario'] = $usuario;
$_SESSION['usuario_id'] = $row['BezeroID'];
$_SESSION['korreoa'] = $row['Korreoa'];  // ✅ ESTA ES LA NUEVA LÍNEA


                  // Redirigir al index.php después de login exitoso
                  header("Location: index.php");

                  exit;
              } else {
                  $message = "errorlogin";
              }

              $stmt->close();
              $conn->close();
          }
      }

      if (isset($message)) {
          if ($message == "errordata") {
              echo "<p style='color: red;'>Sartu erabiltzaile eta pasahitz baliozkoak.</p>";
          } elseif ($message == "errorlogin") {
              echo "<p style='color: red;'>Kredentzial okerrak. Saiatu berriro.</p>";
          }
      }
      ?>
    </form>
  <?php endif; ?>
</div>

<footer>
  <div style="max-width: 1200px; margin: 0 auto; padding: 30px; background-color: #0d0d0d; color: #ccc; font-size: 0.95em;">
    <div style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px;">
      <div>
        <strong>AlaiktoMUGI S.A.</strong><br>
        Tel: <a href="tel:+34900123456" style="color: #ccc;">+34 900 123 456</a><br>
        Email: <a href="mailto:info@alaiktomugi.eus" style="color: #ccc;">info@alaiktomugi.eus</a><br>
        Helbidea: Donostia kalea 7, 20001 Bilbo, Euskal Herria
      </div>
      <div>
        <a href="https://facebook.com" target="_blank"><img src="imgs/descarga.jpg" alt="Facebook" width="24"></a>
        <a href="https://twitter.com" target="_blank"><img src="imgs/descarga (1).jpg" alt="Twitter" width="24"></a>
        <a href="https://instagram.com" target="_blank"><img src="imgs/descarga.png" alt="Instagram" width="24"></a>
      </div>
      <div style="margin-top: 20px; font-size: 0.85em; color: #888;">
        &copy; 2025 AlaiktoMUGI S.A. - Eskubide guztiak erreserbatuta
      </div>
    </div>
  </div>
</footer>

</body>
</html>

